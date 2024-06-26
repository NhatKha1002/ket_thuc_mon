@extends('welcome')
@section('content')

<section id="cart_items">
		<div class="container">
			<div class="breadcrumbs">
				<ol class="breadcrumb">
				  <li><a href="{{URL::to('/')}}">Trang Chủ</a></li>
				  <li class="active">Thanh Toán Giỏ Hàng</li>
				</ol>
			</div>
			
			
			@if (session('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif
			

			<div class="shopper-informations">
				<div class="row">
					
					<div class="col-sm-12 clearfix">
						<div class="bill-to">
							<p>Điền Thông Tin Gửi Hàng</p>
							<div class="form-one">
								<form action="{{URL::to('/save-checkout-customer')}}" method="POST">
									{{ csrf_field() }}
									<input type="text" name="shipping_email" placeholder="Email">
									<input type="text" name="shipping_name" placeholder="Họ Và Tên">
									<input type="text" name="shipping_address" placeholder="Địa Chỉ">
									<input type="text" name="shipping_phone" placeholder="Số Điện thoại">
									<textarea  name="shipping_notes"  placeholder="Ghi Chú Đơn Hàng Của Bạn" rows="16"></textarea>
									<input type="submit" value="Gửi" name="send_order" class="btn btn-primary btn-sm">
								</form>
							</div>
							
						</div>
					</div>
								
				</div>
			</div>
			
		</div>
	</section> <!--/#cart_items-->

@endsection