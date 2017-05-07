<?php

namespace App\Http\Controllers;

use App\Transformers\Models\AddressTransformer;

class AddressController extends ApiController
{

    /**
     * Create a new controller instance.
     *
     * @param  Customer  $customer
     * @return void
     */
    public function __construct(Address $address, AddressTransformer $transformer)
    {
        $this->_model = $address;
        $this->_transformer = $transformer;
        parent::__construct();
    }

    public function _validate($vo, $request)
    {
        return Validator::make(Request::all(), ['customer_id' => 'required|integer',
            'zip_code' => 'required|max:9',
            'address' => 'required|max:255',
            'complement' => 'max:255',
            'number' => 'required|max:255',
            'city_id' => 'required|integer',
        ],
            [
                'customer_id.required' => 'O campo Cliente é obrigatório',
                'customer_id.integer' => 'O campo Cliente deve ser um número inteiro',
                'zip_code.required' => 'O campo CEP é obrigatório',
                'zip_code.max' => 'O campo CEP deve ter no máximo 9 caracteres',
                'address.required' => 'O campo Endereço é obrigatório',
                'address.max' => 'O campo Endereço  deve ter no máximo 255 caracteres',
                'complement.max' => 'O campo Complemento deve ter no máximo 255 caracteres',
                'number.required' => 'O campo Número é obrigatório',
                'number.max' => 'O campo Número deve ter no máximo 255 caracteres',
                'city_id.required' => 'O campo Cidade é obrigatório',
                'city_id.integer' => 'O campo Cidade deve ser um número inteiro',
            ]);
    }

}
