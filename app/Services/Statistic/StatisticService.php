<?php

namespace App\Services\Statistic;

use App\Models\Statistic;
use Illuminate\Database\Eloquent\Collection;

class StatisticService
{
    public function getAll(): Collection
    {
        return Statistic::get();
    }
}