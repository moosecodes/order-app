<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsDataArticle extends Model
{
    use HasFactory;

    protected $fillable = [
        'favs',
        'views'
    ];
}
