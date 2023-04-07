<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Str;


class Post extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];
    protected $hidden = ['deleted_at'];


    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = Str::slug($value).uniqid();
    }

    public function getCreatedAtAttribute($value){
        return Carbon::parse($value)->diffForHumans();
    }

    public function getUpdatedAtAttribute($value){
        return Carbon::parse($value)->diffForHumans();
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function images(){
        return $this->hasMany(PostMedia::class,'post_id','id');
    }
}
