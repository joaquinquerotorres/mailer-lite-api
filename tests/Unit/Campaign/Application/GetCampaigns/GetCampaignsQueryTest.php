<?php

declare(strict_types=1);

namespace App\Tests\Unit\Campaign\Application\GetCampaigns;

use App\Campaign\Application\GetCampaigns\GetCampaignsQuery;
use PHPUnit\Framework\TestCase;

final class GetCampaignsQueryTest extends TestCase
{
    public function test_it_should_return_a_get_campaigns_query()
    {
        $query = new GetCampaignsQuery('123', 10);
        $this->assertInstanceOf(GetCampaignsQuery::class, $query);
        $this->assertEquals('123', $query->cursor());
        $this->assertEquals(10, $query->limit());
    }
}
