<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestsInfo extends Model
{
    use HasFactory;

    protected $table = 'requests_info';
    protected $primaryKey = 'info_id';
}
