<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostMedia extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function getMediaUrlAttribute($value){
        return "https://s3.us-east-2.amazonaws.com/".env('AWS_BUCKET').'/'.$value;
    }
}
