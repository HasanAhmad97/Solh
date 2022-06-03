<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;

    protected $table = 'requests';
    protected $primaryKey = 'reqid';

    public function request_info(){
        return $this->hasOne(RequestsInfo::class, 'reqid', 'reqid');
    }
}
