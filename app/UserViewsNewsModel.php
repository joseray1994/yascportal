<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserViewsNewsModel extends Model
{
    protected $table = 'user_view_news';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_type_user','id_new'
    ];
}
