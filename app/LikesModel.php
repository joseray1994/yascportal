<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LikesModel extends Model
{
    protected $table = 'likes';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_user','id_news'
    ];
}
