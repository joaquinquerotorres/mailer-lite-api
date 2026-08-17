# MailerLite Campaign API

HTTP API for creating, updating, listing, and sending email campaigns. The application is built with **Laravel 13** and **PHP 8.3+**, using **CQRS** and **hexagonal architecture** so the campaign domain stays independent of the web framework and persistence details.

## Architecture

Business logic lives under `src/`, not under Laravel’s default `app/` tree (except HTTP Form Requests, API Resources, and service providers). Autoloading maps `App\` to both `app/` and `src/`.

```
src/
├── Campaign/
│   ├── Domain/            # Entities, value objects, repository contract, events, DTOs
│   ├── Application/       # Commands, queries, and handlers (use cases)
│   └── Infrastructure/    # HTTP controllers, Eloquent adapter, persistence mapping
└── Shared/
    ├── Domain/            # Buses, aggregate root, pagination, generic value objects
    └── Instrastructure/   # Laravel implementations of the buses
```

### Hexagonal architecture

The campaign bounded context is split into three layers:

| Layer | Responsibility | Depends on |
| --- | --- | --- |
| **Domain** | `Campaign` aggregate, value objects (`uuid`, `name`, date range), `CampaignRepository` contract, domain events | Nothing outside the domain |
| **Application** | Use cases as command/query handlers | Domain only |
| **Infrastructure** | Controllers, `CampaignEloquentRepository`, Laravel buses | Application + Domain + Laravel |

Inbound adapter: HTTP controllers in `src/Campaign/Infrastructure/Controllers`. They validate input, build a command or query, and talk to a bus — they never call Eloquent or domain services directly.

Outbound adapter: `CampaignEloquentRepository` implements `CampaignRepository`. The rest of the application depends on the interface; swapping storage does not change handlers.

```text
HTTP  →  Controller  →  Command/Query Bus  →  Handler  →  CampaignRepository (port)
                                                              │
                                                              ▼
                                                    Eloquent repository (adapter)
```

### CQRS

Reads and writes are separate models:

**Commands (writes)**

| Command | Handler | Delivery |
| --- | --- | --- |
| `CreateCampaignCommand` | `CreateCampaignCommandHandler` | Synchronous |
| `UpdateCampaignCommand` | `UpdateCampaignCommandHandler` | Synchronous |
| `SendCampaignCommand` | `SendCampaignCommandHandler` | **Asynchronous** (`ShouldQueue`) |

**Queries (reads)**

| Query | Handler | Delivery |
| --- | --- | --- |
| `GetCampaignQuery` | `GetCampaignQueryHandler` | Synchronous |
| `GetCampaignsQuery` | `GetCampaignsQueryHandler` | Synchronous |

Handlers are mapped in `AppServiceProvider` via Laravel’s `Bus::map()`. Controllers never instantiate handlers.

Domain events exist on the aggregate (`CampaignCreatedEvent` via `AggregateRoot::record()` / `pullDomainEvents()`), so the model can publish facts without coupling to Laravel’s event system.

## Buses (sync and async)

Two ports in `src/Shared/Domain/Bus` hide Laravel’s bus:

- **`QueryBus`** (`LaravelQueryBus`) always uses `Bus::dispatchSync()`. Queries return data and must finish in the same request.
- **`CommandBus`** (`LaravelCommandBus`) uses `Bus::dispatch()`. Behaviour depends on the command:
  - Create and update are **synchronous** (plain `Command` objects).
  - Send implements `ShouldQueue`, so it is **pushed to the queue** and processed by a worker. The HTTP response is `202 Accepted` as soon as the command is dispatched.
  - Failed send jobs retry with backoff **60s, 120s, 180s**.

Run a worker when using a real queue (not `sync`):

```bash
php artisan queue:work redis
```

## Redis

Redis is used in two places in the send flow:

1. **Queue backend** for `SendCampaignCommand` (`QUEUE_CONNECTION=redis`). The worker consumes jobs from Redis instead of blocking the HTTP request.
2. **Distributed lock** in `SendCampaignCommandHandler` via `Cache::lock()` (`CACHE_STORE=redis`), key `campaign:sent:{uuid}`, TTL 60 seconds. If another worker already holds the lock, the send is skipped so the same campaign is not emailed twice.

Point the app at Redis in `.env`:

```env
QUEUE_CONNECTION=redis
CACHE_STORE=redis
REDIS_CLIENT=phpredis
REDIS_HOST=127.0.0.1
REDIS_PORT=6379
```

## HTTP API

Laravel prefixes API routes with `/api`. JSON is returned for `api/*` requests. There is no authentication layer on these endpoints.

| Method | Path | Description | Status |
| --- | --- | --- | --- |
| `GET` | `/api/campaigns` | Cursor-paginated list | `200` |
| `GET` | `/api/campaigns/{campaignUuid}` | Single campaign | `200` |
| `POST` | `/api/campaigns` | Create campaign | `201` |
| `PUT` | `/api/campaigns/{campaignUuid}` | Update campaign | `200` |
| `POST` | `/api/campaigns/{campaignUuid}/send` | Queue campaign send | `202` |
| `GET` | `/up` | Health check | `200` |

### List campaigns

Query parameters:

- `cursor` — opaque cursor from a previous page (optional)
- `limit` — page size (optional)

Response shape:

```json
{
  "items": [
    {
      "id": "550e8400-e29b-41d4-a716-446655440000",
      "name": "Spring launch",
      "startDate": "2026-09-01",
      "endDate": "2026-09-30"
    }
  ],
  "nextCursor": "...",
  "prevCursor": null
}
```

### Create / update body

```json
{
  "name": "Spring launch",
  "startDate": "2026-09-01",
  "endDate": "2026-09-30"
}
```

Validation: `name` required string (max 255 at HTTP, max 100 in the domain), `startDate` and `endDate` required dates, `endDate` after `startDate`. The domain also rejects a start date in the past.

Missing campaigns respond with **404**.

Send currently mails a fixed recipient from `SendCampaignCommandHandler` (markdown mailable `mail.campaign-sent`).

## Persistence

Campaigns are stored in `campaigns`: `uuid` (unique), `name`, `start_date`, `end_date`, timestamps. Listing uses Eloquent **cursor pagination** ordered by `uuid` descending.

Default local database in `.env.example` is SQLite.

## Tests

The suite uses **Pest 5** (PHPUnit under the hood). Coverage is collected for `src/` only (`phpunit.xml`).

| Suite | Location | What it covers |
| --- | --- | --- |
| Unit | `tests/Unit` | Value objects, aggregate, commands/queries and handlers (repository mocked) |
| Feature | `tests/Feature` | HTTP controllers and status codes |
| Integration | `tests/Integration` | Eloquent repository and bus wiring (not in the default PHPUnit suites) |

Current default run (Unit + Feature):

- **30 tests**, **87 assertions**, all passing
- **85.0%** line coverage of `src/`

Lowest coverage is `CampaignEloquentRepository` (~49%) because the integration tests are not included in `phpunit.xml`. Application handlers and HTTP controllers are at or near 100%, except parts of the async send path (queue backoff, Redis lock skip, mailable view).

```bash
php artisan test --compact
php artisan test --compact --coverage
```

Coverage needs [PCOV](https://github.com/krakjoe/pcov) or Xdebug.

## Requirements

- PHP 8.3+ (8.5 supported)
- Composer
- Redis (queue + locks in the send flow)
- Node.js only if you need the default Laravel frontend assets

## Setup

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
```

Then configure Redis as shown above and start:

```bash
php artisan serve
php artisan queue:work redis
```

Or `composer run dev` for the bundled Laravel dev process.

## Stack

- Laravel 13, PHP 8.3+
- Eloquent as the persistence adapter
- Laravel Bus as the command/query transport
- Redis for queued send commands and send locks
- Pest for tests, Pint for PHP style (`vendor/bin/pint`)
