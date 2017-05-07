<?php
/**
 * File: ModelAbstract.php
 * Created by: Felipe Neuhauss
 * Email: felipe.neuhauss@gmail.com
 * Language: PHP
 * Date: 29/08/16
 * Time: 16:02
 * Project: sipred
 * Copyright: 2016
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AbstractModel extends Model {

    protected $table = '';


    public function getModelName() {
        return $this->table;
    }


    public function queryPagination($perPage, $search = '')
    {
        return $this->orderBy('id', 'DESC')->paginate($perPage);
    }

}