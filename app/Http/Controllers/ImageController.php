<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Mockery\Exception;

class ImageController extends Controller
{
    public function loadImages(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'files.*' => 'mimes:jpg,jpeg,png|max:2048'
            ]);
            if ($validator->fails()) {
                return response()->json(['errors'=>$validator->errors()]);
            }
            $loaded_images_path = array();
            foreach ($request->file('files') as $file) {
                $fileName = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();

                $file->move(public_path('photos'), $fileName);
                array_push($loaded_images_path, "/photos/".$fileName);
            }
            return response()->json(["success" => true,'message'=>"Изображения успешно загружены", "paths_to_new_images"=>$loaded_images_path]);
        }
        catch (Exception $exception)
        {
            logger("Сука");
            logger($exception->getMessage());
            return response()->json(["success"=>false,"message"=>$exception->getMessage()]);
        }
    }
}
