<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Rules\filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;


class Category extends Model
{
    use HasFactory,softDeletes;
    protected $fillable = [
        'name','parent_id','description','image','status','slug'
    ];

    public function products(){
      return $this->hasMany(Product::class,'category_id','id');
    }

    public function parent(){
      return $this->belongsTo(Category::class,'parent_id','id')
      ->withDefault([
        'name'=>'-'
      ]);
    }

    public function children(){
      return $this->hasMany(Category::class,'parent_id','id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function scopeFilter(Builder $builder,$filters)
    {
      $builder->when($filters['name'] ?? false,function($builder,$value){
      $builder->where('categories.name','LIKE',"%{$value}%");
     });
     $builder->when($filters['status'] ?? false,function($builder,$value){
      $builder->where('categories.status','=',$value);
     });
      
    }
    

    public static function rules($id=0) {
 
        return[
           'name'=>[     
             'required','string','min:3','max:255',"unique:categories,name,$id",
             'filter:laravel,php,html',
            
           ],
           'parent_id'=>[
           'nullable','int','exists:categories,id',
           ],
           'image'=>[
             'image','max:1048576','dimensions:min_width=100,min_height=100'
           ],
           'status'=>[
             'required','in:active,archived',
           ]
           
         ];
     }
}
