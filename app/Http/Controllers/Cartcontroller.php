<?php

namespace App\Http\Controllers;

use App\Models\DiscountCode;
use App\Models\ShippingDiscountCode;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class Cartcontroller extends Controller
{
    //
    public function save_cart(Request $req){
        

        $productId = $req->productid_hidden;
        $quantity = $req->qty;

        $product_info = DB::table('tbl_product')->where('product_id',$productId)->first();

        if (!$product_info) {
            // Xử lý khi không tìm thấy sản phẩm
            return Redirect::to('/show-cart')->with('error', 'Không tìm thấy sản phẩm');
        }
    
        // Loại bỏ dấu phẩy khỏi giá trị product_price
        $price = str_replace(',', '', $product_info->product_price);
    
        // Kiểm tra giá trị price có hợp lệ hay không
        if (!is_numeric($price) || $price <= 0) {
            return Redirect::to('/show-cart')->with('error', 'Giá sản phẩm không hợp lệ');
        }

        

        // Cart::add('293ad', 'Product 1', 1, 9.99);
        // Cart::destroy();

        $data['id'] = $product_info->product_id;
        $data['qty'] = $quantity;
        $data['name'] = $product_info->product_name;
        $data['price'] = $price;
        $data['options']['image'] = $product_info->product_image;
        
        Cart::add($data)->setTaxRate(10);  // Thiết lập thuế suất 10%;
        return Redirect::to('/show-cart');

    }

    public function show_cart()
    {
        // Xóa các session liên quan đến giảm giá và phí ship nếu cần thiết
        // Đảm bảo rằng session chỉ xóa khi bắt đầu một phiên mua hàng mới
        if (!Session::has('cart_visited')) {
            Session::forget('discount_amount');
            Session::forget('shipping_discount_amount');
            Session::forget('discount_code');
            Session::forget('shipping_discount_code');
            Session::put('cart_visited', true);
        }

        $cate_product = DB::table('tbl_category_product')->where('category_status', '0')->orderBy('category_id', 'desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status', '0')->orderBy('brand_id', 'desc')->get();

        $shipping_fee = 25000;

        return view('pages.cart.show_cart')->with('category', $cate_product)->with('brand', $brand_product)->with('shipping_fee', $shipping_fee);
    }


    public function delete_to_cart($rowId){
        Cart::update($rowId,0); // update dựa vào rowId và set giá trị bằng 0
        
        return Redirect::to('/show-cart');
    }

    public function update_cart_quantity(Request $req){
        $rowId = $req->rowId_cart;
        $qty = $req->cart_quantity;

        Cart::update($rowId,$qty); // update dựa vào rowId và set giá trị bằng $qty
        return Redirect::to('/show-cart');
    }


    public function applyDiscount(Request $request)
{
    $discountCode = DiscountCode::where('code', $request->discount_code)->first();

    if ($discountCode) {
        if ($discountCode->discount_type == 'fixed') {
            $discountAmount = $discountCode->discount_amount;
        } elseif ($discountCode->discount_type == 'percent') {
            $total = str_replace(',', '', Cart::total(0, ',', ''));
            $discountAmount = ($discountCode->discount_amount / 100) * $total;
        }

        Session::put('discount_amount', $discountAmount);
        Session::put('discount_code', $request->discount_code); // Save discount code in session
        return Redirect::to('/show-cart')->with('success', 'Mã giảm giá đã được áp dụng');
    } else {
        return Redirect::to('/show-cart')->with('error', 'Mã giảm giá không hợp lệ');
    }
}

public function applyShippingDiscount(Request $request)
{
    $shippingDiscountCode = ShippingDiscountCode::where('code', $request->shipping_discount_code)->first();
    $shipping_fee = 25000;
    if ($shippingDiscountCode) {
        if ($shippingDiscountCode->discount_type == 'fixed') {
            $shippingDiscountAmount = $shippingDiscountCode->discount_amount;
        } elseif ($shippingDiscountCode->discount_type == 'percent') {
            $shippingDiscountAmount = ($shippingDiscountCode->discount_amount / 100) * $shipping_fee;
        }

        Session::put('shipping_discount_amount', $shippingDiscountAmount);
        Session::put('shipping_discount_code', $request->shipping_discount_code); // Save shipping discount code in session
        return Redirect::to('/show-cart')->with('success', 'Mã giảm phí ship đã được áp dụng');
    } else {
        return Redirect::to('/show-cart')->with('error', 'Mã giảm phí ship không hợp lệ');
    }
}
}
