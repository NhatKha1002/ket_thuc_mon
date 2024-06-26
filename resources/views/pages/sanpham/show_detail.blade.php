@extends('welcome')
@section('content')


@foreach ($details_product as $key => $value)


								<div class="product-details"><!--product-details-->
														<div class="col-sm-5">
															<div class="view-product">
																<img src="{{URL::to('/public/upload/product/'.$value->product_image)}}" alt="" />
																<h3>ZOOM</h3>
															</div>
															<div id="similar-product" class="carousel slide" data-ride="carousel">
																
																<!-- Wrapper for slides -->
																	<div class="carousel-inner">
																		<div class="item active">
																		<a href=""><img src="{{URL::to('/public/frontend/images/similar1.jpg')}}" alt=""></a>
																		<a href=""><img src="{{URL::to('/public/frontend/images/similar2.jpg')}}" alt=""></a>
																		<a href=""><img src="{{URL::to('/public/frontend/images/similar3.jpg')}}" alt=""></a>
																		</div>
																		
																		
																	</div>

																<!-- Controls -->
																<a class="left item-control" href="#similar-product" data-slide="prev">
																	<i class="fa fa-angle-left"></i>
																</a>
																<a class="right item-control" href="#similar-product" data-slide="next">
																	<i class="fa fa-angle-right"></i>
																</a>
															</div>

														</div>
														<div class="col-sm-7">
															<div class="product-information"><!--/product-information-->
																<img src="images/product-details/new.jpg" class="newarrival" alt="" />
																<h2>{{$value->product_name}}</h2>
																<p>Mã ID: {{$value->product_id}}</p>
																<img src="images/product-details/rating.png" alt="" />

																<form action="{{URL::to('/save-cart')}}" method="POST">
																	{{csrf_field() }}
																	<span>
																		<span>{{ $value->product_price . ' VND' }}</span>
																		<label>Số Lượng:</label>
																		<input name="qty" type="number" min="1" value="1" />
																		<input name="productid_hidden" type="hidden" value="{{$value->product_id}}" />
																		<button type="submit" class="btn btn-fefault cart">
																			<i class="fa fa-shopping-cart"></i>
																			Thêm Vào Giỏ Hàng
																		</button>
																	</span>
																</form>

																<p><b>Tình Trạng:</b> Còn hàng</p>
																<p><b>Điều Kiện:</b> Mới 100%</p>
																<p><b>Thương hiệu:</b> {{$value->brand_name}}</p>
																<p><b>Danh Mục:</b> {{$value->category_name}}</p>
																<a href=""><img src="images/product-details/share.png" class="share img-responsive"  alt="" /></a>
															</div><!--/product-information-->
														</div>
													</div><!--/product-details-->



												<div class="category-tab shop-details-tab"><!--category-tab-->
													<div class="col-sm-12">
														<ul class="nav nav-tabs">
															<li class="active"><a href="#details" data-toggle="tab">Mô Tả Sản Phẩm</a></li>
															<li><a href="#companyprofile" data-toggle="tab">Chi Tiết Sản phẩm</a></li>
														</ul>
													</div>
													<div class="tab-content">
														<div class="tab-pane fade active in" id="details" >
															
															<p>{!!$value->product_desc!!}</p>

														</div>
														
														<div class="tab-pane fade" id="companyprofile" >

															<p>{!!$value->product_content!!}</p>
															
														</div>
														
														
													</div>
												</div><!--/category-tab-->
@endforeach
 <div class="recommended_items"><!--recommended_items-->
	<h2 class="title text-center">Sản Phẩm Liên Quan</h2>
						
		<div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
			<div class="carousel-inner">
				<div class="item active">	

								@foreach ($related as $key => $lienquan )
								<a href="{{URL::to('/chi-tiet-san-pham/'.$lienquan->product_id)}}">
									<div class="col-sm-4">
										<div class="product-image-wrapper">
											<div class="single-products">
													<div class="productinfo text-center">
														<img src="{{URL::to('public/upload/product/'.$lienquan->product_image)}}" alt="" style="height: 300px;"/>
														<h2>{{ $lienquan->product_price . ' VND' }}</h2>
														<p>{{$lienquan->product_name}}</p>
														<a href="{{URL::to('/chi-tiet-san-pham/'.$lienquan->product_id)}}" class="btn btn-default add-to-cart">Chi Tiết Sản Phẩm</a>
													</div>
											
											</div>
										</div>
									</div>
								</a>
								@endforeach

								
							<!-- </div>
							 <a class="left recommended-item-control" href="#recommended-item-carousel" data-slide="prev">
								<i class="fa fa-angle-left"></i>
							  </a>
							  <a class="right recommended-item-control" href="#recommended-item-carousel" data-slide="next">
								<i class="fa fa-angle-right"></i>
							  </a>			
						</div> -->
						</div>
			</div>
		</div>
					</div><!--/recommended_items-->

@endsection