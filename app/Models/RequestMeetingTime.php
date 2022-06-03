<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestMeetingTime extends Model
{
    use HasFactory;

    protected $table = 'request_meeting_time';
    protected $primaryKey = 'timeid';
}
