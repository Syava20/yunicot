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
    public function whResize($id, $filename, $w , $h = null, $type=null, $anchor=null)
    {
        $filePath = storage_path().'/app/public/' . $id .'/'. $filename;
        if (! $anchor) $anchor='center';
        if(!$type && (!$w || !$h || $w == 'w')) $type = 'outbox';
        else if (! $type) $type='asis';
        if ($w=='w' ) $w=null;
        if ($h=='h' || !$h) $h=null;

        $params = (object) array(
            'filePath' =>$filePath,
            'w' => $w,
            'h' => $h,
            'cw' => $w,
            'ch' => $h,
            'anchor' => $anchor,
        );

        switch ($type) {
            case 'asis':
                $cacheImage = Image::cache(function($image) use( $filePath, $w, $h, $type){
                    return $image->make($filePath)->resize($w, $h);
                });
                break;
            case 'prop':
                if($w>$h) $params->w = null;
                else $params->h = null;
                $cacheImage = $this->resizeAndChunk($params);
                break;
            case 'chunk':
                if($w>$h) $params->h = null;
                else $params->w = null;
                $cacheImage = $this->resizeAndChunk($params);
                break;
            case 'outbox':
                $cacheImage = Image::cache(function($image) use( $params){
                    if(!$params->w)
                        return $image->make($params->filePath)->heighten($params->h);
                    else if(!$params->h)
                        return $image->make($params->filePath)->widen($params->w);
                    else
                        return $image->make($params->filePath)->resize($params->w, $params->h);

                },$this->cacheTime,false);
                break;
        }
        return Response::make($cacheImage, 200, array('Content-Type' => 'image/jpeg'));
    }

    protected function resizeAndChunk($params)
    {
        return Image::cache(function($image) use( $params){
            return $image->make($params->filePath)->resize($params->w, $params->h, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->resizeCanvas($params->cw, $params->ch, $params->anchor);
        },$this->cacheTime,false);
    }

    /*public function showLogo($id, $w = null, $x = 0, $y = 0){
        $filePath = storage_path().'/app/public/logos/'.$id.'.jpg';
        $h = $w;
        return Image::cache(function($image) use ($param){

        });
    }*/
}