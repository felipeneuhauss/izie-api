<?php
/**
 * Created by PhpStorm.
 * User: felipeneuhauss
 * Date: 29/03/17
 * Time: 14:58
 */

namespace App\Transformers\Models;

use App\Transformers\AbstractTransformer;

class AddressTransformer extends AbstractTransformer
{

    public $arrayMap = [
        'id' => 'id',
        'customer_id' => 'customer_id',
        'zip_code' => 'zip_code',
        'address' => 'address',
        'complement' => 'complement',
        'number' => 'number',
        'city_id' => 'city_id'
    ];

    public function transform($item)
    {
        $row =  [
            'id' => $item->id,
            'customer_id' => $item->customer_id,
            'zip_code' => $item->zip_code,
            'address' => $item->address,
            'number' => $item->number,
            'complement' => $item->complement,
            'city_id' => $item->city_id,
            'city' => $item->city->name,
            'location' => $item->city ? $item->city->name . ' - '.$item->city->state->initials : '-'
        ];

        return $row;
    }
}