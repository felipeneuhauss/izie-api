<?php

namespace App\Http\Controllers;

use App\Models\State;
use App\Traits\RestfulMethods;

class StateController extends ApiController
{
    use RestfulMethods;

    public function __construct(State $state)
    {
        $this->_model = $state;
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = $this->_model->get();
        return $data;
    }


    public function cities($id) {
        $state = $this->_model->find($id);
        return $state->cities;
    }
}
