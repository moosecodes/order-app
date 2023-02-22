<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsCatcherArticle extends Model
{
    use HasFactory;

    protected $fillable = [
        'favs',
        'views',
        'saves'
    ];
}
