<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use App\Models\Scopes\StoreScope;
use Illuminate\Database\Eloquent\SoftDeletes;


class Product extends Model
{
    use HasFactory,softDeletes;
    protected $fillable=[
        'name','slug','description','image','category_id','store_id',
        'price','compare_price','status',
    ];
    protected static function booted(){
        static::addGlobalScope('store', new StoreScope());      
    }
    public function category(){
        return $this->belongsTo(Category::class,'category_id','id');
     }
     public function store(){
        return $this->belongsTo(Store::class,'store_id','id');
     }
}
