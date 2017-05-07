<?php
/**
 * Created by PhpStorm.
 * User: felipeneuhauss
 * Date: 31/03/17
 * Time: 13:06
 */

namespace App\Transformers;

use League\Fractal;

abstract class AbstractTransformer extends Fractal\TransformerAbstract
{
    public $arrayMap;

    public function transform($item)
    {
        $transformed = [];
        array_walk($this->arrayMap, function($val, $key) use ($item, &$transformed) {
            $transformed[$key] = $item->$val;
        });
        return $transformed;
    }
}