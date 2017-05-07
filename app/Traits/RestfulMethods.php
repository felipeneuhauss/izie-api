<?php
/**
 * Created by PhpStorm.
 * User: felipeneuhauss
 * Date: 03/05/17
 * Time: 19:19
 */

namespace App\Traits;


use App\Models\Contracts\InterfaceModel;
use Illuminate\Http\Request;

trait RestfulMethods
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = $this->_model->orderBy('created_at', 'DESC')->get();
        return $this->transform($data, $this->_transformer);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $this->prepare($request->all());
        $validator = $this->_validate($this->_model, $request);

        if (!$validator->fails()) {
            $vo = $this->_model->findOrNew(null);
            $vo->fill($data);
            $vo->save();
            return $this->transform($vo, $this->_transformer);
        }

        return response($validator->errors(), 400);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->transform($this->_model->find($id), $this->_transformer);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $vo = $this->_model->find($id);
        $data = $this->prepare($request->all());
        $validator = $this->_validate($vo, $request);

        if (!$validator->fails()) {
            $vo->fill($data);
            $vo->save();
            return $vo;
            return $this->transform($vo, $this->_transformer);
        }

        return ['type' => 'error', 'messages' => $validator->errors()];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $vo = $this->_model->find($id);

        if (!is_null($vo)) {
            $vo->delete();
            return ['type' => 'success', 'message' => 'Registro removido com sucesso!'];
        }

        return ['type' => 'error',  'message' => 'Informe um registro para ser removido.'];
    }

}