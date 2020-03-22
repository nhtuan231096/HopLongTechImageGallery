<?php 

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Excel;
use Auth;
use App\Services\PayUService\Exception;
use App\Models\ImageGallery;
/**
 * 
 */
class GalleryController extends Controller
{
	public function index(){
		$dataGallery = ImageGallery::paginate(15);
		return view('admin.gallery.index',[
			'dataGallery' => $dataGallery
		]);
	}
	
	public function gallery_import_view(){
		return view('admin.gallery.import');
	}

    public function gallery_import(Request $request)
    {
        $path = $request->file('import_file')->getRealPath();
        $data = Excel::load($path)->get();
        if($data->count()){
            foreach ($data as $key => $value) {
                $arr = [
                	'title' => $value->title, 
                	'images' => $value->actual_photo,
                	'created_by' => Auth::guard('admin')->user()->email,
                	'created_at' => date('Y-m-d')
                ];
                $gallery = ImageGallery::where('title',$arr['title']);
                if ($gallery->count()){
                	$gallery->update($arr);
                }
                else {
					ImageGallery::create($arr);
                }
            }
    //         if(!empty($arr)){
    //         	try {
				//     // ImageGallery::insert($arr);
				//     ImageGallery::insert($arr);
				// } catch (\Exception $e) {
				//     return $e->getMessage();
				// }
    //         } else {
            	// return redirect()->back()->with('error', 'Có lỗi vui lòng thử lại');
            // }
        }
        return back()->with('success', 'Import thành công.');
    }
}
