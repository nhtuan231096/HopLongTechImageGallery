<?php 

namespace App\Http\Controllers;
use App\Models\ImageGallery;
/**
 * 
 */
class GalleryController extends Controller
{
	public function viewImageGallery($title){
		$gallery = ImageGallery::where('title',$title)->first();
		$images = $gallery->images;
		$images = explode(",",$images);
		return view('home.gallery',[
			'images' => $images,
			'title' => $gallery->title
		]);
	}	
}