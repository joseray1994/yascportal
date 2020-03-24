<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SupplyModel extends Model
{
    protected $table = 'supplies';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_department', 'id_provider', 'name', 'quantity', 'price',  'cost', 'total_price','status',
    ];
}
