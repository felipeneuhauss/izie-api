<?php

namespace App\Models;

use App\Models\Contracts\InterfaceModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Picture extends AbstractModel implements InterfaceModel
{         
    protected $table = 'pictures';

    protected $primaryKey = 'id';

    protected $with = [];

    protected $fillable = ['id','name','created_at','updated_at'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
}