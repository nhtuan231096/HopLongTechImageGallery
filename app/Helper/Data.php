<?php 
namespace App\Helper;
use Auth;
use App\Models\Reward_points;
use App\Models\AdminNotification;
use App\Models\Terms;

class Data
{
	public $items = [];
	public $total_quantity = 0;
	public $total_amount = 0;
	function __construct()
	{
		$this->items = session('cart') ? session('cart') : [];
		$this->total_quantity = $this->total_quantity();
		$this->total_amount = $this->total_amount();
	}
		public function add($model){
			if (isset($this->items[$model->id])) {
				$this->items[$model->id]['quantity'] +=1;
			}
			else {
				// dd(Auth::guard('customer')->user()->cusGroup);
				$priceDiscount = date('Y-m-d') <= $model->time_discount ? $model->price - (($model->price*$model->discount)/100)
				 : (Auth::guard('customer')->check() ? 
				 	(isset($model->price_when_login) ? $model->price_when_login : $model->price)
				 : $model->price);
				 // dd($priceDiscount);
				 if(isset(Auth::guard('customer')->user()->cusGroup)){
					 $priceDiscount = !empty($this->DiscountAmount()) ? number_format(round($priceDiscount - (($priceDiscount/100) * $this->DiscountAmount()))) : $priceDiscount;
				 }
				 $priceDiscount = str_replace(",","",$priceDiscount);
				 // dd($priceDiscount);
				$this->items[$model->id] = [
				'id' => $model->id,
				'title' => $model->title,
				'slug' => $model->slug,
				'price' => $priceDiscount,
				'quantity' => 1,
				'image' => $model->cover_image
				];
			}
			// dd($this->items);
		session(['cart'=>$this->items]);
		
	}
	public function delete($id){
		if (isset($this->items[$id])) {
			unset($this->items[$id]);
		}
		session(['cart'=>$this->items]);
	}
	//---
	public function update($id,$quantity){
		if (isset($this->items[$id])) {
				$this->items[$id]['quantity'] = $quantity;
			}
		session(['cart'=>$this->items]);
	}
	//---
	public function updateQuantity($id,$quantity){
		$cats = (array_combine($id,$quantity));
		foreach($cats as $idItem=>$qty){
			if (isset($this->items[$idItem])) {
				$this->items[$idItem]['quantity'] = $qty;
			}
			session(['cart'=>$this->items]);
		}
	}
	//---
	public function clear(){
		session(['cart'=>[]]);
		session([
			'total_amount'=>[],
			'price_reduced'=>[],
			'coupon_code'=>[],
		]);
	}
	public function customer_user_group(){
		$user_group = 5;
		return $user_group;
	}

	protected function total_quantity(){
		$t = 0;
		foreach($this->items as $item){
			$t = $t+ $item['quantity'];
		}
		return $t;
	}
	protected function total_amount(){
		$t = 0;
		foreach($this->items as $item){
			$price = $item['price'] > 0 ? $item['price'] : 0;
			$t = $t + ($item['quantity']*$price);
		}
		return $t;
	}
	public function add_coupon($data_uses_coupon){
		session([
			'total_amount'=>[],
			'price_reduced'=>[],
			'coupon_code'=>[],
		]);
		session([
			'total_amount'=>$data_uses_coupon['total_amount'],
			'price_reduced'=>$data_uses_coupon['price_reduced'],
			'coupon_code'=>$data_uses_coupon['coupon_code']
		]);
	}
	public function order_status(){
		$status = [
			'1' => 'Đang chờ xử lý',
			'2' => 'Xác nhận đặt hàng',
			'3' => 'Đang giao hàng',
			'4' => 'Đã giao hàng',
			'5' => 'Hủy đơn hàng',
		];
		return $status;
	}

	public function DiscountAmount(){
		if(Auth::guard('customer')->check()){
			$discount_amount = isset(Auth::guard('customer')->user()->cusGroup->discount_amount) ? (Auth::guard('customer')->user()->cusGroup->discount_amount) : 0;
			return $discount_amount;
		}
	}
	public function deliveryTime(){
		$delivery_time = [
			'stock-local' => '24 hrs',
			'stock-remote' => '2-4 days',
			'MTO' => '2-8 weeks',
		];
		return $delivery_time;
	}
	public function getAdminNotification(){
		return AdminNotification::orderBy('id','desc')->limit(20)->get();
	}
	public function getStatusAdminNotification(){
		return AdminNotification::where('status',0)->get();
	}
	public function payment_method(){
		return [
			'0' => "Thanh toán tiền mặt khi nhận hàng",
			'1' => "Thanh toán bằng thẻ quốc tế Visa, Master, JCB",
		];
	}
	public function shipping_method(){
		return [
			'0' => "Giao hàng nhanh",
			'1' => "Giao tiêu chuẩn",
		];
	}
	public function Reward_points(){
		return Reward_points::first();
	}

	public function PriceProduct($product){
		// dd($product);
		$product = (object) $product;
		$price = $product['price'];
		if($price == '' || is_numeric($price) == false){
			return "Liên hệ 1900.6536";
		}
		elseif(($date = date('Y-m-d') <= $product['time_discount'])){
			$productPrice = $product['price'] - (($product['price'] * $product['discount'])/100);
			return number_format($productPrice)." VNĐ";
		}
		if(Auth::guard('customer')->check()){
			 $priceProduct = isset($product['price_when_login']) ? ($product['price_when_login']) : ($product['price'] > 0 ? ($product['price']) : $product['price']);
			 $showPrice = !empty($this->DiscountAmount()) ? number_format(round($priceProduct - (($priceProduct/100) * $this->DiscountAmount()))) : $priceProduct;
			 return ($showPrice)." VNĐ";
		}
		
		else{
			// return Auth::guard('customer')->check();
			return $product['price'] > 0 ? number_format($product['price']).'  VNĐ' : $product['price'];
		}
	}
	public function city(){
		return [
			'1' => 'Hà Nội',
			'2' => 'Hải Phòng',
			'3' => 'Đà Nẵng',
			'4' => 'Thành Phố HCM',
			'5' => 'Cần Thơ',
			'0' => 'Tỉnh thành khác',
		];
	}
	public function stringToArray($string){
		$arr = explode(",",$string);
		return $arr;
	}
	public function type_term(){
		return [
			'bao_hanh' => 'Chính sách bảo hành',
			'thanh_toan' => 'Quy định và hình thức thanh toán',
			'doi_tra' => 'Quy định đổi trả hàng',
			'van_chuyen' => 'Chính sách vận chuyển, giao hàng'
		];
	}
	public function getTerms(){
		$datas = Terms::paginate(20);
		return $datas;
	}
	public function check_order_status($stt){
		$status = [
			'1' => 'Đang chờ xử lý',
			'2' => 'Xác nhận đặt hàng',
			'3' => 'Đang giao hàng',
			'4' => 'Đã giao hàng',
			'5' => 'Hủy đơn hàng',
		];
		foreach ($status as $key => $value) {
			if($stt == $key) {
				return $value;
			}
		}
	}
}

