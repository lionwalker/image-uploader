<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class UploadController extends Controller
{
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'type' => 'required|in:campaigns,categories',
            'image' => 'required|image:jpeg,png,jpg|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->messages()->first()])->setStatusCode(Response::HTTP_BAD_REQUEST);
        }

        $uploadFolder = $request->type;
        $image = $request->file('image');
        $image->storeAs("$uploadFolder","$request->id.jpg");

        return response()->json(['message' => 'File uploaded.'])->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Request $request, $type, $id)
    {
        $exists = Storage::disk('local')->exists("$type/$id.jpg");
        if ($exists) {
            return response()->download(storage_path("app/$type/$id.jpg"))->setStatusCode(Response::HTTP_OK);
        }

        return response()->json(['message' => "File not exists."])->setStatusCode(Response::HTTP_BAD_REQUEST);
    }

    public function destroy(Request $request, $type, $id)
    {
        Storage::delete("$type/$id.jpg");
        return response()->json(['message' => "File deleted"])->setStatusCode(Response::HTTP_NO_CONTENT);
    }
}
