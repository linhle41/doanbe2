@extends('frontend.layout.master')

@section('title', 'Cart')

@section('body')
        <nav id="navigation">
			<!-- container -->
			<div class="container">
				<!-- responsive-nav -->
				<div id="responsive-nav">
					<!-- NAV -->
					<ul class="main-nav nav navbar-nav">
					<li class="active"><a href="">Home</a></li>
					</ul>
					<!-- /NAV -->
				</div>
				<!-- /responsive-nav -->
			</div>
			<!-- /container -->
		</nav>
    <!-- SECTION -->
		<div class="section">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row giohang" >
               
				<!-- /row -->
                </div>
			</div>
            <div class="back-thanhtoan" style="text-align:center; margin-bottom: 10px;" >
		          <a href=""><button class="add-to-cart-btn"><i class="fa fa-backward"></i> Quay lại</button></a>
		          <a href=""><button class="add-to-cart-btn"><i class="fa fa-shopping-cart"></i> Thanh Toán</button></a>
		    </div>
			<!-- /container -->
		</div>
		<!-- /SECTION -->

@endsection