<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Image;
use Storage;
use Response;


class ImageController extends Controller
{

    // livetime image in cache in min (default 129600 ~3 month )
    protected $cacheTime=12960;

    public function __construct()
    {
        $this->middleware('web');
    }

    public function fullImage($id, $filename=null)
    {
        $filePath = storage_path().'/app/public/' . $id .'/'. $filename;
        return Image::make($filePath)->response();
    }

    /**
     * @param $dateImg
     * @param $filename
     * @param $w
     * @param $h
     * @param null $type
     * @param null $anchor possible: top-left, top, top-right, left, center (default), right, bottom-left, bottom, bottom-right
     * @return mixed
     */
    public function whResize($id, $filename, $w , $h = null, $x = null, $y = null, $nw = null)
    {
        $filePath = storage_path().'/app/public/' . $id .'/'. $filename;
        if($w == 'w') $w = null;

        $params = (object) array(
            'filePath' => $filePath,
            'w' => $w,
            'h' => $h,
            'x' => $x,
            'y' => $y,
            'nw' => $nw,
        );


        $cacheImage = Image::cache(function($image) use($params){
            if(!$params->h){
                $image->make($params->filePath)->widen($params->w);
            }
            elseif(!$params->x){
                $image->make($params->filePath)->resize($params->w, $params->h);
            }
            elseif(!$params->y){
                $image->make($params->filePath)->crop($params->w, $params->w, $params->h, $params->x);
            }
            elseif (!$params->nw){
                $image->make($params->filePath)->crop($params->w, $params->h, $params->x, $params->y);
            }
            else{
                $image->make($params->filePath)->crop($params->w, $params->h, $params->x, $params->y)->widen($params->nw);
            }

        },$this->cacheTime, true);


        return $cacheImage->response();
    }

    /*public function showLogo($id, $w = null, $x = 0, $y = 0){
        $filePath = storage_path().'/app/public/logos/'.$id.'.jpg';
        $h = $w;
        return Image::cache(function($image) use ($param){

        });
    }*/
}