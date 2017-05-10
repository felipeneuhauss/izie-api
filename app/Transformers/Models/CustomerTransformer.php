<?php
/**
 * Created by PhpStorm.
 * User: felipeneuhauss
 * Date: 29/03/17
 * Time: 14:58
 */

namespace App\Transformers\Models;

use App\Transformers\AbstractTransformer;

class CustomerTransformer extends AbstractTransformer
{

    public $arrayMap = [
        'id' => 'id',
        'name' => 'name',
        'birthday' => 'birthday',
        'gender' => 'gender',
        'picture' => 'picture',
        'cpf' => 'cpf',
        'email' => 'email',
        'user_id' => 'user_id',
    ];

    public function transform($item)
    {
        $gender = ['male' => 'Masculino', 'female' => 'Feminino'];
        $row =  [
            'id' => $item->id,
            'name' => $item->name,
            'gender' => $item->gender,
            'created_at' => $item->created_at->format('d/m/Y'),
            'updated_at' => $item->updated_at->format('d/m/Y'),
            'birthday' => $item->birthday->format('d/m/Y'),
            'original_birthday' => $item->birthday->format('Y-m-d'),
            'cpf' => $item->cpf,
            'email' => $item->email,
            'picture' => is_object($item->picture) ? url('/uploads/customers/'.$item->picture->name) : null,
        ];
        return $row;
    }
}