<?php

namespace App\Http\Controllers;

use App\Models\Picture;
use App\Traits\RestfulMethods;
use Illuminate\Http\Request;

class PictureController extends ApiController
{
    use RestfulMethods;

    /**
     * Create a new controller instance.
     *
     * @param  Customer  $customer
     * @return void
     */
    public function __construct(Picture $picture)
    {
        $this->_model = $picture;
        parent::__construct();
    }

    public function store(Request $request)
    {
        $vo = new Picture();
        $image = $request->file('file');

        $uploadSuccess = false;
        if (!is_null($image)) {

            $destinationPath = public_path() . '/uploads/customers/';
            //            $filename = $brandImage->getClientOriginalName();
            $fileExtension = $image->getClientOriginalExtension();

            // Save the gallery object
            $fileName = uniqid(time()).'.'.$fileExtension;
            $vo->name = $fileName;
            // Save the upload file
            $uploadSuccess = $image->move($destinationPath, $fileName);

            if ($uploadSuccess) {
                $vo->save();
                return $vo;
            }

            return response('Sorry the image couldn\'t be uploaded' , 400);
        }
        return response('Select a image' , 400);
    }
}
