<?php
/**
 * Created by PhpStorm.
 * User: felipeneuhauss
 * Date: 15/09/15
 * Time: 17:24
 */

namespace App\Models\Contracts;


interface InterfaceModel {

    public function queryPagination($perPage, $search);

} 