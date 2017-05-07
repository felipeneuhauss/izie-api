<?php

namespace App\Models;

use App\Models\Contracts\InterfaceModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends AbstractModel implements InterfaceModel
{
    use SoftDeletes;
         
    protected $table = 'addresses';

    protected $primaryKey = 'id';

    protected $with = [];

    protected $fillable = ['id','customer_id','zip_code','address','complement','number','city_id',
        'created_at','updated_at','deleted_at'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public function city() 
    {
        return $this->belongsTo('App\Models\City', 'city_id', 'id');
    }

    public function customer() 
    {
        return $this->belongsTo('App\Models\Customer', 'customer_id', 'id');
    }

}