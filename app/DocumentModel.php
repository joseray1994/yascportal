<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DocumentModel extends Model
{
    protected $table = 'documents';
    protected $primaryKey = 'id';
    protected $fillable = [
        'mat','id_dad','name','status', 'path'
    ];
}
