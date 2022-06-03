<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CasesCloseStatus extends Model
{
    use HasFactory;

    protected $table = 'cases_close_status';
    protected $primaryKey = 'close_status_id';
}
