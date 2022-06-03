<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NationalityList extends Model
{
    use HasFactory;

    protected $table = 'nationality_list';
    protected $primaryKey = 'nationality_id';
}
