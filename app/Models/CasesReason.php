<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CasesReason extends Model
{
    use HasFactory;

    protected $table = 'cases_reasons';
    protected $primaryKey = 'reason_id';
}
