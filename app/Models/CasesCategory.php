<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CasesCategory extends Model
{
    use HasFactory;

    protected $table = 'cases_categories';
    protected $primaryKey = 'catid';
}
