<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestSession extends Model
{
    use HasFactory;

    protected $table = 'request_sessions';
    protected $primaryKey = 'sessionid';

    public function request(){
        return $this->belongsTo(Request::class, 'reqid', 'reqid')->with(['request_info']);
    }

    public function council(){
        return $this->belongsTo(CouncilsMeetingLocation::class, 'council_id', 'council_id');
    }

    public function time(){
        return $this->belongsTo(RequestMeetingTime::class, 'timeid', 'timeid');
    }

    public function moslh_name(){
        return $this->belongsTo(User::class, 'moslh_userid', 'userid');
    }
}
