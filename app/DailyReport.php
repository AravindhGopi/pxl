<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DailyReport extends Model
{
    public function details()
    {
        return $this->hasMany('App\DailyReportDetails');
    }
}
