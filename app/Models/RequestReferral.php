<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestReferral extends Model
{
    use HasFactory;

    protected $table = 'request_referral';
    protected $primaryKey = 'referid';
}
