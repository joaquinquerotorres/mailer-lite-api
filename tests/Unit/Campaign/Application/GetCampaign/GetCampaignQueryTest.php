<?php

declare(strict_types=1);

namespace App\Tests\Unit\Campaign\Application\GetCampaign;

use App\Campaign\Application\GetCampaign\GetCampaignQuery;
use PHPUnit\Framework\TestCase;

final class GetCampaignQueryTest extends TestCase
{
    public function test_it_should_return_a_get_campaign_query()
    {
        $query = new GetCampaignQuery('123e4567-e89b-12d3-a456-426614174000');

        $this->assertInstanceOf(GetCampaignQuery::class, $query);
        $this->assertEquals('123e4567-e89b-12d3-a456-426614174000', $query->campaignUuid());
    }
}
