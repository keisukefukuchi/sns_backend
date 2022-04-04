<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $guarded = array('id');

    protected $fillable = [
        'comment',
        'user_id',
        'post_id',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function share()
    {
        return $this->belongsTo('App\Models\Post');
    }
}
