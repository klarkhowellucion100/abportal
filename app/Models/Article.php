<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $connection = 'mysql_secondary'; // Use the secondary DB
    protected $table = 'articles'; // Your actual table

    protected $guarded = [];
}
