<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class NewsAPIArticle extends Model
{
    use HasFactory;

    protected $table = 'news_api_articles';

    protected $fillable = [
        'favs',
        'views',
        'saves'
    ];
}
