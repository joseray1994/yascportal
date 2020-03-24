<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommentsModel extends Model
{
    protected $table = 'comments';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_news','id_user', 'comment', 'status'
    ];
}
