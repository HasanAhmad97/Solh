<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CouncilsMeetingLocation extends Model
{
    use HasFactory;

    protected $table = 'councils_meeting_location';
    protected $primaryKey = 'council_id';
}
