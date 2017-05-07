<?php

namespace App\Models;

use App\Models\Contracts\InterfaceModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends AbstractModel implements InterfaceModel
{
    protected $table = 'cities';

    protected $primaryKey = 'id';

    protected $with = [];

    protected $fillable = ['id','name','state_id'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public function state() 
    {
        return $this->belongsTo('App\Models\State', 'state_id', 'id');
    }

    public function doctors()
    {
        return $this->hasMany('App\Models\Doctor', 'city_id', 'id');
    }

}