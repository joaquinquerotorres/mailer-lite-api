<?php

declare(strict_types=1);

namespace App\Campaign\Infrastructure\Repository;

use Database\Factories\CampaignEloquentFactory;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[UseFactory(CampaignEloquentFactory::class)]
final class CampaignEloquent extends Model
{
    use HasFactory;

    protected $table = 'campaigns';

    protected $fillable = [
        'uuid',
        'name',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];
}
