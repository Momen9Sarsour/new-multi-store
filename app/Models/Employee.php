<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory,softDeletes;

    protected $fillable=[
        'name','image','email','phone_number','address',
        'ipan',
    ];
    protected $attributes = [
        'email' => null,
    ];

    public function user()
   {
    return $this->belongsTo(User::class);
   }
   public static function rules($id=0) {
 
    return[
       'name'=>[     
         'required','string','min:3','max:255',"unique:employees,name,$id",
       ],
       'email' => [
        'required', 'email', "unique:employees,email,$id",
      ],
       'image'=>[
         'image','max:1048576','dimensions:min_width=100,min_height=100'
       ],
       
     ];
 }
}
