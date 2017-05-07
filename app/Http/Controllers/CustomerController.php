<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Traits\RestfulMethods;
use App\Transformers\Models\AddressTransformer;
use App\Transformers\Models\CustomerTransformer;
use Illuminate\Support\Facades\Validator;

class CustomerController extends ApiController
{
    use RestfulMethods;

    /**
     * Create a new controller instance.
     *
     * @param  Customer  $customer
     * @return void
     */
    public function __construct(Customer $customer, CustomerTransformer $transformer)
    {
        $this->_model = $customer;
        $this->_transformer = $transformer;
        parent::__construct();
    }

    public function _validate($vo, $request)
    {
        return Validator::make($request->all(), [
            'name' => 'required|max:255',
            'birthday' => 'required',
            'gender' => 'required',
            'cpf' => 'max:14',
            'email' => 'max:255|email'
        ],
            [
            'name.required' => 'O campo Nome é obrigatório',
            'name.max' => 'O campo Nome deve ter no máximo 255 caracteres',
            'birthday.required' => 'O campo Data de aniversário é obrigatório',
            'gender.required' => 'O campo Sexo é obrigatório',
            'cpf.max' => 'O campo CPF deve ter no máximo 14 caracteres',
            'email.max' => 'O campo E-mail deve ter no máximo 255 caracteres',
            'email.date' => 'O campo E-mail deve ser um e-mail válido'
        ]);
    }

    public function addresses($id) {
        $addressTransformer = new AddressTransformer();
        $customer = $this->_model->find($id);
        return $this->transform($customer->addresses, $addressTransformer);
    }
}
