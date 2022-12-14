<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $primaryKey = "article_id";

    public $timestamps = false;

    protected $fillable = ["id", "name", "description", "category", "price", "currency"];
}
