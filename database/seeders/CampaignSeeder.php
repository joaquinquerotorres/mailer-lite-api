<?php

namespace Database\Seeders;

use App\Campaign\Infrastructure\Repository\CampaignEloquent;
use Illuminate\Database\Seeder;

class CampaignSeeder extends Seeder
{
    public function run(): void
    {
        CampaignEloquent::factory()->createMany([
            [
                'name' => 'January Kickoff',
                'start_date' => '2027-01-05 09:00:00',
                'end_date' => '2027-01-31 18:00:00',
            ],
            [
                'name' => 'Valentine Promo',
                'start_date' => '2027-02-01 09:00:00',
                'end_date' => '2027-02-14 23:59:59',
            ],
            [
                'name' => 'Spring Launch',
                'start_date' => '2027-03-01 09:00:00',
                'end_date' => '2027-03-31 18:00:00',
            ],
            [
                'name' => 'Easter Campaign',
                'start_date' => '2027-04-01 09:00:00',
                'end_date' => '2027-04-20 18:00:00',
            ],
            [
                'name' => 'Mother\'s Day Special',
                'start_date' => '2027-05-01 09:00:00',
                'end_date' => '2027-05-09 18:00:00',
            ],
            [
                'name' => 'Summer Sale',
                'start_date' => '2027-06-01 09:00:00',
                'end_date' => '2027-06-30 18:00:00',
            ],
            [
                'name' => 'Independence Week',
                'start_date' => '2027-07-01 09:00:00',
                'end_date' => '2027-07-15 18:00:00',
            ],
            [
                'name' => 'Back to School',
                'start_date' => '2027-08-01 09:00:00',
                'end_date' => '2027-08-31 18:00:00',
            ],
            [
                'name' => 'September Newsletter',
                'start_date' => '2027-09-01 09:00:00',
                'end_date' => '2027-09-30 18:00:00',
            ],
            [
                'name' => 'Halloween Treats',
                'start_date' => '2027-10-01 09:00:00',
                'end_date' => '2027-10-31 23:59:59',
            ],
            [
                'name' => 'Black Friday',
                'start_date' => '2027-11-20 00:00:00',
                'end_date' => '2027-11-27 23:59:59',
            ],
            [
                'name' => 'Holiday Season',
                'start_date' => '2027-12-01 09:00:00',
                'end_date' => '2027-12-31 23:59:59',
            ],
        ]);
    }
}
