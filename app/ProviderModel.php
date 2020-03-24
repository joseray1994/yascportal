<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProviderModel extends Model
{
    protected $table = 'providers';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_department', 'name', 'rfc', 'phone','email','status',
    ];
}
