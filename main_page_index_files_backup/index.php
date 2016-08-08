<?require "config.php"; ?> 
<? 
$result          = mysql_query("SELECT * FROM  products WHERE category_id!='50' order by id desc limit 7", $db);
$row             = mysql_fetch_array($result);
 

$result_2         = mysql_query("SELECT * FROM  products WHERE category_id!='50' order by rand() limit 6", $db);
$row_2           = mysql_fetch_array($result_2);
?>
 
<!DOCTYPE html>
<html lang="en">
	<head>
		<!-- Meta -->
		<meta charset="utf-8">
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
		<meta name="description" content="Southeastern Restaurant Supply">
		<meta name="author" content="">
	    <meta name="keywords" content="Southeastern, Restaurant Supply">
	    <meta name="robots" content="all">
        <meta property="og:image" content="http://www.southeasternrestaurantsupply.com/uploads/logo.png" />

	    <title>Home - Southeastern Restaurant Supply</title>

	    <?require "header.php" ;?>

	</head>
    <body class="cnt-home">
	
		
	
		<!-- ============================================== HEADER ============================================== -->
<header class="header-style-1 header-style-3">

	<!-- ============================================== TOP MENU ============================================== -->
<? require "top.php"; ?>

	<!-- ============================================== NAVBAR ============================================== -->
<? require "menu.php"; ?>
<!-- ============================================== NAVBAR : END ============================================== -->

</header>

<!-- ============================================== HEADER : END ============================================== -->
<div class="body-content" id="top-banner-and-menu">
	<!-- ========================================== SECTION – HERO ========================================= -->
			
<div id="hero" class="home-page-slider4">
	<div id="owl-main" class="owl-carousel silder4 owl-inner-nav owl-ui-sm">
		
		<div class="item" style="background-image: url(assets/images/sliders/southeastern_banner_winco.jpg);">
			<!-- <div class="container-fluid">
				<div class="caption vertical-center text-left">
					<div class="big-text fadeInDown-1">
						The new <span class="highlight">imac</span> for you
					</div>

					<div class="excerpt m-t-20 fadeInDown-2 hidden-xs">
					
						<span>
							21.5-Inch Now Starting At $1099 <br>
							27-Inch Starting At $1799
						</span>
					</div>
					<div class="button-holder fadeInDown-3">
						<a href="index.php?page=single-product" class="btn btn-black btn-uppercase shop-now-button">Shop Now</a>
					</div>
				</div> 
			</div> -->
		</div> 
        <div class="item" style="background-image: url(/assets/images/sliders/Southeastern_banner_elmeco.jpg);">
        
        </div>
		<div class="item" style="background-image: url(assets/images/sliders/Southeastern_banner_ranges.jpg);">
			<!-- <div class="container-fluid">
				<div class="caption vertical-center text-left">
					<div class="big-text fadeInDown-1">
						The new <span class="highlight">imac</span> for you
					</div>

					<div class="excerpt m-t-20 fadeInDown-2 hidden-xs">
						 
					<span>
						21.5-Inch Now Starting At $1099 <br>
						27-Inch Starting At $1799
					</span>
					</div>
					<div class="button-holder fadeInDown-3">
						<a href="index.php?page=single-product" class="btn btn-black btn-uppercase shop-now-button">Shop Now</a>
					</div>
				</div>  
			</div> --><!-- /.container-fluid -->
		</div><!-- /.item -->

		<div class="item" style="background-image: url(assets/images/sliders/Southeastern_banner_robotcoupe.jpg);">
			<!-- <div class="container-fluid">
				<div class="caption vertical-center text-left">
					<div class="big-text fadeInDown-1">
						The new <span class="highlight">imac</span> for you
					</div>

					<div class="excerpt m-t-20 fadeInDown-2 hidden-xs">
						 
					<span>
						21.5-Inch Now Starting At $1099 <br>
						27-Inch Starting At $1799
					</span>
					</div>
					<div class="button-holder fadeInDown-3">
						<a href="index.php?page=single-product" class="btn btn-black btn-uppercase shop-now-button">Shop Now</a>
					</div>
				</div> 
			</div> --><!-- /.container-fluid -->
		</div><!-- /.item -->

		<div class="item" style="background-image: url(assets/images/sliders/3.jpg);">
			<!-- <div class="container-fluid">
				<div class="caption vertical-center text-left">
					<div class="big-text fadeInDown-1">
						The new <span class="highlight">imac</span> for you
					</div>

					<div class="excerpt m-t-20 fadeInDown-2 hidden-xs">
						 
					<span>
						21.5-Inch Now Starting At $1099 <br>
						27-Inch Starting At $1799
					</span>
					</div>
					<div class="button-holder fadeInDown-3">
						<a href="index.php?page=single-product" class="btn btn-black btn-uppercase shop-now-button">Shop Now</a>
					</div>
				</div> 
			</div> --><!-- /.container-fluid -->
		</div><!-- /.item -->
		

	</div><!-- /.owl-carousel -->
<!-- 	<div class="customNavigation">
		<div class="container">
				
				<div class="controls clearfix hidden-xs">
					<a href="#" data-target=".silder4" class="btn btn-primary pull-left owl-prev"><i class="fa fa-angle-left"></i></a>
					<a href="#" data-target=".silder4" class="btn btn-primary pull-right owl-next"><i class="fa fa-angle-right"></i></a>
				</div> 
				
			</div>
	</div> -->
</div>
			
<!-- ========================================= SECTION – HERO : END ========================================= -->	<div class="container">
	
		<!-- ============================================== WIDE PRODUCTS ============================================== -->
<div class="wide-banners wow fadeInUp new-banner inner-bottom-20">
	<div class="row">

		<div class="col-md-4">
			<div class="wide-banner cnt-strip">
				<div class="image">
					<a href="/category.php?id=50">
						<img class="img-responsive" data-echo="assets/images/banners/8.jpg" src="assets/images/blank.gif" alt="">
					</a>
				</div>	
				<div class="strip">
					<div class="strip-inner">
						<a href="/category.php?id=50">
						<h3 class="white"> &nbsp; Special</h3>
						<h5 class="white text-right"><span>save up to 20%</span></h5>
						</a>
					</div>	
				</div>
			</div><!-- /.wide-banner -->
		</div><!-- /.col -->

		<div class="col-md-4">
			<div class="wide-banner cnt-strip">
				<div class="image">
                <a href="/category.php?id=51">
					<img class="img-responsive" data-echo="assets/images/banners/9.jpg" src="assets/images/blank.gif" alt="">
			     </a>
            </div>	
				<div class="strip">
					<div class="strip-inner text-center">
                        <a href="/category.php?id=51">
    						<h3 class="white">Clearance</h3>
    						<h5 class="white text-right"><span>Find good deals</span></h5>
                        </a>
					</div>	
				</div>
			</div><!-- /.wide-banner -->
		</div><!-- /.col -->

		<div class="col-md-4">
			<div class="wide-banner cnt-strip">
				<div class="image">
					<a href="/category.php?id=50">
						<img class="img-responsive" data-echo="assets/images/banners/10.jpg" src="assets/images/blank.gif" alt="">
					</a>
				</div>	
				<div class="strip">
					<div class="strip-inner text-center">
						<a href="/category.php?id=50">
							<h3 class="white">PARTS</h3>
							<h5 class="white text-right"><span>PARTS & HARDWARE</span></h5>
						</a>
					</div>	
				</div>
			</div><!-- /.wide-banner -->
		</div><!-- /.col -->

		

	</div><!-- /.row -->
</div><!-- /.wide-banners -->

<!-- ============================================== WIDE PRODUCTS : END ============================================== -->
		<!-- ============================================== SCROLL TABS ============================================== -->
		<div id="product-tabs-slider" class="scroll-tabs outer-top-vs wow fadeInUp">
			<div class="more-info-tab clearfix ">
			   <h3 class="new-product-title pull-left">New Products</h3>
				<!-- <ul class="nav nav-tabs nav-tab-line pull-right" id="new-products-1">
					<li class="active"><a href="#all" data-toggle="tab">All</a></li>
					<li><a href="#smartphone" data-toggle="tab">smartphone</a></li>
					<li><a href="#laptop" data-toggle="tab">laptop</a></li>
					<li><a href="#apple" data-toggle="tab">apple</a></li>
				</ul> --><!-- /.nav-tabs -->
			</div>

			<div class="tab-content outer-top-xs">
				<div class="tab-pane in active" id="all">			
					<div class="product-slider">
						<div class="owl-carousel home-owl-carousel custom-carousel owl-theme" data-item="5">
						    
 <?do{?>
	
		<div class="item item-carousel">
			<div class="products">
				
	<div class="product">		
		<div class="product-image">
			<div class="image">
				<a href="/product.php?id=<?=$row['id']?>"><img  src="assets/images/blank.gif"   data-echo="/uploads/t.php?src=/uploads/<?=$row['image']?>&amp;h=228&amp;w=228&amp;q=100&amp;zc=1" alt=""></a>
			</div><!-- /.image -->			

			<div class="tag new"><span>new</span></div>                        		   
		</div><!-- /.product-image -->
			
		
		<div class="product-info text-left">
			<h3 class="name"><a href="/product.php?id=<?=$row['id']?>"><?=$row['name']?></a></h3>
 			<div class="description"><?=substr(strip_tags($row['description']), 0, 120);?>...</div>

			<div class="product-price">	
				<span class="price"><?if($row['price']!=='0.00'){?>
					$<?echo number_format($row['price'],2);}?>
				</span>
					<?if($row['old_price']!=='0.00' && $row['price']!=='0.00'){?>
					<span class="price-before-discount">$<?=number_format($row['old_price'],2)?>	
					</span>
					<?}?>					
			</div>
			
		</div><!-- /.product-info -->
					<div class="cart clearfix animate-effect" style="display:none;">
				<div class="action">
					<ul class="list-unstyled">
						<li class="add-cart-button btn-group">
							<button class="btn btn-primary icon" data-toggle="dropdown" type="button">
								<i class="fa fa-shopping-cart"></i>													
							</button>
							<button class="btn btn-primary" type="button">Add to cart</button>
													
						</li>
	                   
		                <li class="lnk wishlist">
							<a class="add-to-cart" href="detail.html" title="Wishlist">
								 <i class="icon fa fa-heart"></i>
							</a>
						</li>

						<li class="lnk">
							<a class="add-to-cart" href="detail.html" title="Compare">
							    <i class="fa fa-retweet"></i>
							</a>
						</li>
					</ul>
				</div><!-- /.action -->
			</div><!-- /.cart -->
			</div><!-- /.product -->
      
			</div><!-- /.products -->
		</div><!-- /.item -->
	<?} while ($row = mysql_fetch_array($result));  ?>
		 
					</div></div></div></div><!-- /.home-owl-carousel -->
		</section><!-- /.section --><br><br>
     <!-- ============================================== FEATURED PRODUCTS : END ============================================== -->
     <!-- ============================================== WIDE PRODUCTS ============================================== -->
	<div class="wide-banners wow fadeInUp outer-bottom-vs">
		<div class="row">

			<div class="col-md-12">
				<div class="wide-banner cnt-strip">
					<div class="image">
						<img data-echo="assets/images/banners/11.jpg" src="assets/images/blank.gif" alt="">
					</div>	
					<div class="strip">
						<div class="strip-inner text-right" >
							<h1 style="color: #fff;">restaurant equipment</h1>
							<p class="normal-shopping-needs" style="color: #fff;">HIGH QUALITY</p>
						</div>	
					</div>
					<!-- <div class="new-label">
					    <div class="text">NEW</div>
					</div --> <!-- /.new-label -->
				</div><!-- /.wide-banner -->
			</div><!-- /.col -->

		</div><!-- /.row -->
	</div><!-- /.wide-banners -->
    <!-- ============================================== WIDE PRODUCTS : END ============================================== -->
    <!-- ============================================== BEST SELLER ============================================== -->

	<section class="section seller-product wow fadeInUp">
		<h3 class="section-title">best seller</h3>
			<div class="row outer-top-xs">
	    		<?do{?>
				<div class="col-md-4 col-sm-6">
					<div class="products">
						
						<div class="product">
							<div class="product-micro">
								<div class="row product-micro-row">
									<div class="col col-xs-6">
										<div class="product-image">
											<div class="image">
												<a href="/uploads/<?=$row_2['image']?>" data-lightbox="image-1" data-title="<?=$row_2['name']?>">
													<img data-echo="/uploads/t.php?src=/uploads/<?=$row_2['image']?>&amp;h=180&amp;w=180&amp;q=100&amp;zc=1" src="assets/images/blank.gif" alt="">
													<div class="zoom-overlay"></div>
												</a>					
											</div><!-- /.image -->

										</div><!-- /.product-image -->
									</div><!-- /.col -->
									<div class="col col-xs-6">
										<div class="product-info">
											<h3 class="name"><a href="/product.php?id=<?=$row_2['id']?>"><?=$row_2['name']?></a></h3>
											 	<div class="description"><?=substr(strip_tags($row_2['description']), 0, 100);?>...</div>
											<div class="product-price">	
												<span class="price"><?if($row_2['price']!=='0.00'){?>
													$<?echo number_format($row_2['price'],2);}?>
												</span>
													<?if($row_2['old_price']!=='0.00' && $row_2['price']!=='0.00'){?>
													<span class="price-before-discount">$<?=number_format($row_2['old_price'],2)?>	
													</span>
													<?}?>					
											</div>
											 
										</div>
									</div><!-- /.col -->
								</div><!-- /.product-micro-row -->
							</div><!-- /.product-micro -->
						</div>
						
					</div>
				</div>
			<?} while ($row_2 = mysql_fetch_array($result_2));  ?>	
				 
				 
				
				 
				
				 
				
				 
							</div>
			
		</section>
		<!-- ============================================== BEST SELLER : END ============================================== -->

     <!-- ============================================== BLOG SLIDER ============================================== -->
	<section class="section wow fadeInUp outer-bottom-vs" style="display:none;">
		<h3 class="section-title">latest form blog</h3>
		<div class="blog-slider-container wow fadeInUp  outer-top-xs">
			<div class="owl-carousel blog-slider custom-carousel">
																				<div class="item">
						<div class="blog-post">
							<div class="blog-post-image">
								<div class="image">
									<a href="blog.html"><img data-echo="assets/images/blog-post/7.jpg" src="assets/images/blank.gif" width="370" height="165" alt=""></a>
								</div>
							</div><!-- /.blog-post-image -->
						
						
							<div class="blog-post-info text-left">
								<h3 class="name"><a href="blog.html">Simple Blog demo from fashion web</a></h3>	
								<span class="info">By Jone Doe-22 april 2014 -03 comments</span>
								<p class="text">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium</p>
								<a href="#" class="lnk btn btn-primary">Read more</a>
							</div><!-- /.blog-post-info -->
							
							
						</div><!-- /.blog-post -->
					</div><!-- /.item -->
						        											<div class="item">
						<div class="blog-post">
							<div class="blog-post-image">
								<div class="image">
									<a href="blog.html"><img data-echo="assets/images/blog-post/8.jpg" src="assets/images/blank.gif" width="370" height="165" alt=""></a>
								</div>
							</div><!-- /.blog-post-image -->
						
						
							<div class="blog-post-info text-left">
								<h3 class="name"><a href="blog.html">Simple Blog demo from fashion web</a></h3>	
								<span class="info">By Jone Doe-22 april 2014 -03 comments</span>
								<p class="text">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium</p>
								<a href="#" class="lnk btn btn-primary">Read more</a>
							</div><!-- /.blog-post-info -->
							
							
						</div><!-- /.blog-post -->
					</div><!-- /.item -->
						        											<div class="item">
						<div class="blog-post">
							<div class="blog-post-image">
								<div class="image">
									<a href="blog.html"><img data-echo="assets/images/blog-post/9.jpg" src="assets/images/blank.gif" width="370" height="165" alt=""></a>
								</div>
							</div><!-- /.blog-post-image -->
						
						
							<div class="blog-post-info text-left">
								<h3 class="name"><a href="blog.html">Simple Blog demo from fashion web</a></h3>	
								<span class="info">By Jone Doe-22 april 2014 -03 comments</span>
								<p class="text">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium</p>
								<a href="#" class="lnk btn btn-primary">Read more</a>
							</div><!-- /.blog-post-info -->
							
							
						</div><!-- /.blog-post -->
					</div><!-- /.item -->
						        											<div class="item">
						<div class="blog-post">
							<div class="blog-post-image">
								<div class="image">
									<a href="blog.html"><img data-echo="assets/images/blog-post/10.jpg" src="assets/images/blank.gif" width="370" height="165" alt=""></a>
								</div>
							</div><!-- /.blog-post-image -->
						
						
							<div class="blog-post-info text-left">
								<h3 class="name"><a href="blog.html">Simple Blog demo from fashion web</a></h3>	
								<span class="info">By Jone Doe-22 april 2014 -03 comments</span>
								<p class="text">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium</p>
								<a href="#" class="lnk btn btn-primary">Read more</a>
							</div><!-- /.blog-post-info -->
							
							
						</div><!-- /.blog-post -->
					</div><!-- /.item -->
						        											<div class="item">
						<div class="blog-post">
							<div class="blog-post-image">
								<div class="image">
									<a href="blog.html"><img data-echo="assets/images/blog-post/11.jpg" src="assets/images/blank.gif" width="370" height="165" alt=""></a>
								</div>
							</div><!-- /.blog-post-image -->
						
						
							<div class="blog-post-info text-left">
								<h3 class="name"><a href="blog.html">Simple Blog demo from fashion web</a></h3>	
								<span class="info">By Jone Doe-22 april 2014 -03 comments</span>
								<p class="text">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium</p>
								<a href="#" class="lnk btn btn-primary">Read more</a>
							</div><!-- /.blog-post-info -->
							
							
						</div><!-- /.blog-post -->
					</div><!-- /.item -->
						        											<div class="item">
						<div class="blog-post">
							<div class="blog-post-image">
								<div class="image">
									<a href="blog.html"><img data-echo="assets/images/blog-post/12.jpg" src="assets/images/blank.gif" width="370" height="165" alt=""></a>
								</div>
							</div><!-- /.blog-post-image -->
						
						
							<div class="blog-post-info text-left">
								<h3 class="name"><a href="blog.html">Simple Blog demo from fashion web</a></h3>	
								<span class="info">By Jone Doe-22 april 2014 -03 comments</span>
								<p class="text">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium</p>
								<a href="#" class="lnk btn btn-primary">Read more</a>
							</div><!-- /.blog-post-info -->
							
							
						</div><!-- /.blog-post -->
					</div><!-- /.item -->
						        	
			</div><!-- /.owl-carousel -->
		</div><!-- /.blog-slider-container -->
	</section><!-- /.section -->
<!-- ============================================== BLOG SLIDER : END ============================================== -->

      <!-- ============================================== BRANDS CAROUSEL ============================================== -->
<? require "brands.php"; ?>
<!-- ============================================== BRANDS CAROUSEL : END ============================================== -->	
	

	</div><!-- /.container -->
</div><!-- /#top-banner-and-menu -->




<? require "footer.php"; ?>