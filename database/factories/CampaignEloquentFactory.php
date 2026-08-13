<?php

namespace Database\Factories;

use App\Campaign\Infrastructure\Repository\CampaignEloquent;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CampaignEloquentFactory extends Factory
{
    protected $model = CampaignEloquent::class;

    public function definition(): array
    {
        $startDate = fake()->dateTimeBetween('2027-01-01', '2027-11-30');

        return [
            'uuid' => (string) Str::uuid(),
            'name' => fake()->unique()->words(3, true),
            'start_date' => $startDate,
            'end_date' => fake()->dateTimeBetween($startDate, '2027-12-31'),
        ];
    }
}
