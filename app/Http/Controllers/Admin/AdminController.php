<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Helper\Data;
/**
 * 
 */
class AdminController extends Controller
{
	public function login(){
		return view('admin.user.login');
	}
	public function post_login(Request $req,Data $data){
		$this->validate($req,[
			'email'=>'required|email',
			'password'=>'required'
		],[
			'email.required'=>'Email không được để trống',
			'email.email'=>'Email không đúng định dạng',
			'password.required'=>'Mật khẩu không được để trống'
		]);
		// Auth::logout();
		if(Auth::Guard('admin')->attempt($req->only('email','password'))){
			$check_customer = isset(Auth::user()->group_id) ? Auth::user()->group_id : '';
			if($check_customer != $data->customer_user_group()){
				return view('admin.index');
			}
			else{
				return redirect()->route('gallery')->with('error','Đăng nhập không thành công');
			}
		}
		else
		{
			return redirect()->back()->with('error','Tên đăng nhập hoặc mật khẩu không đúng');
		}
	}
	public function logout(){
		Auth::Guard('admin')->logout();
		return redirect()->route('login');
	}
}