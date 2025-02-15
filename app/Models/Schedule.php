<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $table ="schedules";
    function DailyScheduleData(){
        return $this->belongsTo('App\Models\DailySchedule', 'daily_schedule_id', 'id');
    }
}
