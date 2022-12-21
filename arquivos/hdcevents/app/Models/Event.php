<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $casts = [
        'itens' => 'array'
    ];

    protected $dates = ['date'];

    protected $guarded = [];

    //Evento pertence ao User
    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    //Evento pode pertencer a muitos User
    public function users() {
        return $this->belongsToMany('App\Models\User');
    }
}
