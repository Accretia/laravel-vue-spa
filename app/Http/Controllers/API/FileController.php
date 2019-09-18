<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use App\User;

class FileController extends Controller
{
    //

    public function upload(Request $request){
        $result = array();
        if ($request->hasFile('photos')){

            $filename = $request->file('photos')->getClientOriginalName();
            $user_id = Auth::user()->id;
            $path = Storage::disk('public')->put($user_id , $request->file('photos'));
            $result["url"] = "/uploads/".$path;
        }
        return Response::json($result);
    }

    public function fileList(Request $request){
        $result = array();
        $user_id = Auth::user()->id;
        $files = Storage::disk('public')->allFiles("/".$user_id);
        if(sizeof($files) > 0){
            foreach ($files as $file){
                $result[]["url"] = "uploads/".$file;
            }
        }
        return Response::json($result);
    }

    public function overview(){
        $result = array();
        $user_id = Auth::user()->id;
        $size = 0;
        $no_of_files = 0;
        $files = Storage::disk('public')->allFiles("/".$user_id);
        $no_of_files = sizeof($files);
        if($no_of_files > 0){
            foreach ($files as $file){
                $size += Storage::disk('public')->size($file);
            }
        }
        $result["noOfFiles"] = $no_of_files;
        $result["size"] = $size;
        return Response::json($result);
    }

    public function detail(){
        $result = array();
        $data = array();
        $user_id = Auth::user()->id;
        $size = 0;
        $no_of_files = 0;
        $files = Storage::disk('public')->allFiles("/".$user_id);
        $no_of_files = sizeof($files);
        if($no_of_files > 0){
            foreach ($files as $index => $file){
                $type = Storage::disk('public')->mimeType($file);
                $result[$type][$index] = Storage::disk('public')->size($file);

                //$size += Storage::disk('public')->size($file);
            }
            foreach ($result as $type => $res){
                $data[$type]["size"] = array_sum($result[$type]);
                $data[$type]["no_of_file"] = sizeof($result[$type]);
            }

        }

        return Response::json($data);
    }
}
