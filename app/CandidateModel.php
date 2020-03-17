<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CandidateModel extends Model
{
    protected $table = 'candidates';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_vacancy', 'name', 'last_name', 'phone', 'mail', 'channel', 'listening_test', 'grammar_test', 'typing_test', 'typing_test2','typing_test3','typing_test4','status',
    ];
}
