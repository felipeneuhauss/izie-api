<?php

namespace App\Models;

use App\Models\Contracts\InterfaceModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends AbstractModel implements InterfaceModel
{
    use SoftDeletes;
         
    protected $table = 'customers';

    protected $primaryKey = 'id';

    protected $with = [];

    protected $fillable = ['id','name','birthday','gender','picture_id','cpf','email',
        'user_id','created_at','updated_at','deleted_at'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at', 'created_at', 'updated_at', 'birthday'];

    public function user() 
    {
        return $this->belongsTo('App\Models\User');
    }

    public function addresses()
    {
        return $this->hasMany('App\Models\Address');
    }

    public function picture()
    {
        return $this->belongsTo('App\Models\Picture');
    }

}