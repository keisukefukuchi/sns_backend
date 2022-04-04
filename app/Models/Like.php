<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;
    protected $guarded = array('id');

    protected $fillable = ['user_id', 'post_id'];

    public function User()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function Share()
    {
        return $this->belongsTo('App\Models\Post');
    }
}
