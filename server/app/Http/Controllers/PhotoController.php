<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PhotosService;

class PhotoController extends Controller
{
    private $_photosService;

    public function __construct(PhotosService $photosService)
    {
        $this->_photosService = $photosService;
    }

    public function getAllPhotos(Request $request)
    {
        return $this->_photosService->getPhotoList();
    }

    public function getPhotoDetail($photoId)
    {
        return $this->_photosService->getPhotoDetail($photoId);
    }

    public function getPhotoExif($photoId)
    {
        return $this->_photosService->getPhotoExif($photoId);
    }

    public function registerPhotos(Request $request)
    {
        return $this->_photosService->registerPhotos($request);
    }
}
