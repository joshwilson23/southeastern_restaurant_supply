<? require "config.php"; ?>
<?
function no($str)
  {
    $str = stripslashes($str);
    $str = mysql_real_escape_string($str);
    $str = trim($str);
    $str = htmlspecialchars($str);
    return $str;
  }
if(!isset($_GET['id'])){
    header('Location: /'); 
	exit();
}
$m=no($_GET['id']);
$result          = mysql_query("SELECT * FROM  products WHERE id = '$m'", $db);
$row             = mysql_fetch_array($result);
if(empty($row['id'])){
	header('Location: /404.php'); 
	exit();
}
?>
<?
$category_id = $row['category_id'];
$manufacturer_id = $row['manufacturer_id'];

$result_categories             = mysql_query("SELECT * FROM  categories WHERE id = '$category_id'", $db);
$row_categories             = mysql_fetch_array($result_categories);

$result_manufacturer             = mysql_query("SELECT * FROM  manufacturers WHERE id = '$manufacturer_id'", $db);
$row_manufacturer             = mysql_fetch_array($result_manufacturer);

$result_pr          = mysql_query("SELECT * FROM  images WHERE product_id = '$m' order by position asc", $db);
$row_pr            = mysql_fetch_array($result_pr);

$result_pr2          = mysql_query("SELECT * FROM  images WHERE product_id = '$m' order by position asc", $db);
$row_pr2           = mysql_fetch_array($result_pr2);

$result_various          = mysql_query("SELECT * FROM  various_to_product WHERE product_id = '$m'", $db);
$row_various            = mysql_fetch_array($result_various);

$result_2         = mysql_query("SELECT * FROM  products where category_id='$category_id' AND id!='$m' order by rand()  limit 7", $db);
$row_2           = mysql_fetch_array($result_2);

$result_3         = mysql_query("SELECT * FROM  products where id!='$m' order by rand() limit 7", $db);
$row_3           = mysql_fetch_array($result_3);
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<!-- Meta -->
		<meta charset="utf-8">
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
		<meta name="description" content="Buy <?=$row_categories['name']?> <?=$row['name']?> from <?=$row_manufacturer['name']?> <?=$row_categories['name']?>">
		<meta name="author" content="">
	    <meta name="keywords" content="<?=$row['name']?>,<?=$row_manufacturer['name']?>,<?=$row_categories['name']?>">
	    <meta name="robots" content="all">

	    <title><?=$row['name']?> - <?=$row_manufacturer['name']?> | Southeastern Restaurant Supply</title>
        <meta property="og:image" content="http://www.southeasternrestaurantsupply.com/uploads/<?=$row['image']?>" />
		<?require "header.php" ;?>

	</head>
    <body class="cnt-homepage">
	
		
	
		<!-- ============================================== HEADER ============================================== -->
<header class="header-style-1 header-style-3">

	<!-- ============================================== TOP MENU ============================================== -->
  <? require "top.php"; ?>

	<!-- ============================================== NAVBAR ============================================== -->
<? require "menu.php"; ?>

</header>

<!-- ============================================== HEADER : END ============================================== -->
<div class="breadcrumb">
	<div class="container">
		<div class="breadcrumb-inner">
			<ul class="list-inline list-unstyled">
				<li><a href="/">Home</a></li> / 
				<li><a href="/"><?=$row_categories['name']?></a></li> /
				<li class='active'><?=$row['name']?></li>
			</ul>
		</div><!-- /.breadcrumb-inner -->
	</div><!-- /.container -->
</div><!-- /.breadcrumb -->
<div class="body-content outer-top-xs">
	<div class='container'>
		<div class="homepage-container">
			<div class='row single-product outer-bottom-sm '>
				<div class='col-md-3 sidebar'>
					<div class="sidebar-module-container">
						<!-- ============================================== COLOR============================================== -->
 
    
<!-- ============================================== COLOR: END ============================================== -->

					</div>
				</div><!-- /.sidebar -->
				<div class='col-md-9'>
					<div class="row  wow fadeInUp">
						     <div class="col-xs-12 col-sm-6 col-md-7 gallery-holder">
    <div class="product-item-holder size-big single-product-gallery small-gallery">

        <div id="owl-single-product">
        	<div class="single-product-gallery-item" id="slide0">
                <a data-lightbox="image-1" data-title="<?=$row['name']?>" href="/uploads/<?=$row['image']?>">
                    <img class="img-responsive" alt="" src="assets/images/blank.gif" data-echo="/uploads/<?=$row['image']?>" />
                </a>
            </div>
            <?if(!empty($row_pr['id'])){?>
        	<?$i=0;?>
        	 <?do{?>
        	 <?$i++;?>
        		<div class="single-product-gallery-item" id="slide<?=$i?>">
                <a data-lightbox="image-1" data-title="<?=$row['name']?>" href="/uploads/<?=$row_pr['name']?>">
                    <img class="img-responsive" alt="" src="assets/images/blank.gif" data-echo="/uploads/<?=$row_pr['name']?>" />
                </a>
            </div>
        		<?} while ($row_pr = mysql_fetch_array($result_pr));}?>
           <!-- /.single-product-gallery-item -->

            

        </div><!-- /.single-product-slider -->


        <div class="single-product-gallery-thumbs second-gallery-thumb gallery-thumbs">

            <div id="owl-single-product2-thumbnails">

				<div class="item">
                    <a class="horizontal-thumb active" data-target="#owl-single-product" data-slide="0" href="#slide0">
                        <img class="img-responsive" width="85" alt="" src="assets/images/blank.gif" data-echo="/uploads/<?=$row['image']?>" />
                    </a>
                </div>
                  <?if(!empty($row_pr2['id'])){?>
            		<?$o=0;?>
        	 <?do{?>
        	 <?$o++;?>

				<div class="item">
                    <a class="horizontal-thumb active" data-target="#owl-single-product" data-slide="<?=$o?>" href="#slide<?=$o?>">
                        <img itemprop="image" class="img-responsive" width="85" alt="" src="assets/images/blank.gif" data-echo="/uploads/<?=$row_pr2['name']?>" />
                    </a>
                </div>


        	 
        		<?} while ($row_pr2 = mysql_fetch_array($result_pr2));}?>
                
                 
                
            </div><!-- /#owl-single-product-thumbnails -->

            

        
         <div class="nav-holder left">
                <a class="prev-btn slider-prev" data-target="#owl-single-product2-thumbnails" href="#prev"></a>
            </div><!-- /.nav-holder -->
             <div class="nav-holder right">
                <a class="next-btn slider-next" data-target="#owl-single-product2-thumbnails" href="#next"></a>
            </div><!-- /.nav-holder -->
            </div><!-- /.gallery-thumbs -->

    </div><!-- /.single-product-gallery -->
</div><!-- /.gallery-holder -->	        			
						<div class='col-sm-6 col-md-5 product-info-block' id="serialize">
							<div itemscope itemtype="http://schema.org/Product" class="product-info">
								<h1 itemprop="name" class="name"><?=$row['name']?></h1>
								
							
								<div class="price-container info-container m-t-20">
								<div class="row">
									

									<div class="col-sm-6">
										<div itemprop="offers" itemscope itemtype="http://schema.org/Offer" class="price-box">
											<span itemprop="priceCurrency" content="USD"><span itemprop="price" class="price" id="original_price"><?if($row['price']!=='0.00'){?>
												<?echo number_format($row['price'],2);}else{?> <span style="font-size: 14px;">Call For Special Pricing</span><?}?>
											</span>
											</span>
											<?if($row['old_price']!=='0.00' && $row['price']!=='0.00'){?>
										     <span class="price-strike" id="old_price"> <?=number_format($row['old_price'],2)?>	</span><?}?> 


										     <? if( $row['id'] === '12'){ ?><h3><em>FREE SHIPPING</em></h3> <?}?>


										     <? if($row['id'] === '85' || $row['id'] === '472' || $row['id'] === '22' || $row['id'] === '110' || $row['id'] === '170' || $row['id'] === '159' || $row['id'] === '158' || $row['id'] === '274' || $row['id'] === '95'){if (isset($_POST["send"])) { $to = 'mike@panhandlerestaurantservices.com'; //email recipient
																	  $subject = 'Email me My Price Quote!'; //email subject
																	  $message = 'Email: ' . $_POST['email']; //gathers the input email to display for reply
																	  $message .= 'Product ID: ' . $_SERVER['QUERY_STRING'];
																	  $headers = "From: quotes@southeasternrestaurantsupply.com";
																	  $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
																	  	
																	  $success = mail($to, $subject, $message, $headers);}?> 

																	  
																	  <form class="form" method="post">
											<label for="email"><style type="text/css"> #h4 {color: #D33433; font-size: 1.6rem;} </style><em><h4 id="h4">Email me my price!</h4></em></label>
											<input class="form" type="email" name="email" id="priceEmail" placeholder="john@smith.com"> <br>
											<input data-toggle="tooltip" data-placement="right" title="Thank you! We will send you the price shortly. If you would rather call us at (888) 308-4885 Monday - Friday, from 8 a.m. to 5 p.m. EST we will be happy to help you with any questions you have regarding this or any of our products." class="btn-primary" id="sendButton" type="submit" name="send" value="SEND">
										</form> <?}?>
										
										</div>
									</div> 

								</div><!-- /.row -->
							</div><!-- /.price-container -->
                            
								<?$q=0;?>
								<?if(!empty($row_various['id'])){?>

								<?do{?>
								<?$v_id=$row_various['various_id'];?>
								<?$result_v          = mysql_query("SELECT * FROM  various WHERE id = '$v_id'", $db);
								$row_v            = mysql_fetch_array($result_v); 
								do{?>
								 <?$q++;?>
								<div class="attributes-list outer-top-vs for-array" data-id="sel<?=$q?>">
									<fieldset class="attribute_fieldset">
										<div class="row">
											<label for="group_1" class="col-md-6  attribute_label attribute-key"><?=$row_v['name']?>:</label>
											<div class="col-md-6 attribute_list"> 
												<select class="form-control   attribute_select no-print various"  id="group_1" name="group_1"> 
													 <option title="Choose.." value="0">Choose...</option>
													<?$result_options          = mysql_query("SELECT * FROM  various_options WHERE various_id = '$v_id'", $db);
													$row_options            = mysql_fetch_array($result_options); 

													 do{ ?>
													<?if($row_options['action']==0){?>
													<option title="<?=$row_options['name']?>" value="<?=$row_options['id']?>" act="<?=$row_options['action']?>" price="<?=$row_options['price']?>" old_price="<?=$row_options['old_price']?>"><?=$row_options['name']?></option>
													<?}elseif($row_options['action']==1){?>
													<option title="<?=$row_options['name']?>" value="<?=$row_options['id']?>" act="<?=$row_options['action']?>" price="<?=$row_options['price']?>" old_price="<?=$row_options['old_price']?>"><?=$row_options['name']?> +$<?=number_format($row_options['price'],2)?> </option>
													<?} else{?>
													<option title="<?=$row_options['name']?>" value="<?=$row_options['id']?>" act="<?=$row_options['action']?>" price="<?=$row_options['price']?>" old_price="<?=$row_options['old_price']?>"><?=$row_options['name']?> -$<?=number_format($row_options['price'],2)?> </option>
													<?}} while ($row_options = mysql_fetch_array($result_options));?>
												</select>
											</div> <!-- /.attribute_list -->
										</div> 
									</fieldset>
								</div>
								<?}while ($row_v = mysql_fetch_array($result_v));?>
								 
								
								<?} while ($row_various = mysql_fetch_array($result_various));?>


								<?}?>
                                
                                <?if($row['quantity']<=0){?>
                            <div class="stock-container info-container m-t-10">
        							<div class="row">
										<div class="col-sm-3">
											<div class="stock-box">
												<span class="label">Availability :</span>
											</div>	
										</div>
										<div class="col-sm-9">
											<div class="stock-box">
												<span class="value">Sold out!</span>
											</div>	
										</div>
									</div><!-- /.row -->	
								</div>
                                <?}else{?>
                                	<div class="stock-container info-container m-t-10">
                                		<div class="row">
                                			<div class="col-sm-3">
                                				<div class="stock-box">
                                					<span class="label">Availability :</span>
                                				</div>
                                			</div>
                                			<div class="col-sm-9">
                                				<div class="stock-box">
                                					<link itemprop="availability" href="http://schema.org/InStock" content="InStock" class="value"/><em>In Stock!</em>
                                				</div>
                                			</div>
                                		</div>
                                	</div>

							 <?if($row['price']!=='0.00'){?>
								<div class="row outer-top-vs">
									<div class="col-sm-2 col-lg-2 col-md-4">
										<span class="label">Quantity :</span>
									</div>
									<div class="col-sm-3 col-lg-3 col-md-4"> 
                                    <input name="id" value="<?=$row['id']?>" style="display:none;">
										<input type="number"  min="1" max="<?=$row['quantity']?>" step="1" value="1" id="quantity" name="quantity" class="txt txt-qty">
									</div>

									<div class="cart col-md-12 col-lg-6 clearfix animate-effect">
										<div class="action">
														
											<button type="button" class="btn btn-primary" id="add_to_cart" data-id="<?=$row['id']?>">Add to cart</button>
											 					

								                
											
										</div><!-- /.action -->
									</div>
								</div>
								<?}}?>
								<div class="description-container m-t-20">
									<span itemprop="description"><?=$row['description']?></span>
								</div><!-- /.description-container -->
								<?if(!empty($row['file_name'])){?>
								<div class="col-sm-24 text-center">
										 
											<a class="btn btn-primary" href="/uploads/<?=$row['file_name']?>" style="width:100%;color:white;background:#D33433;border:none;" data-toggle="tooltip" data-placement="right" title="" href="#" data-original-title="Additional material">
											    <i class="fa fa-cogs"></i> <?=$row['file_title']?>
											</a>
											 
										 
									</div> 
									<?}?>
								<div class="row product-social-link outer-top-vs">

									 
									<div class=" col-md-9 col-sm-9">
                                    <ul class="share-buttons">
                                          <li><a href="https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Fwww.southeasternrestaurantsupply.com%2Fproduct.php%3Fid%3D<?=$row['id']?>&t=" title="Share on Facebook" target="_blank" onclick="window.open('https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(document.URL) + '&t=' + encodeURIComponent(document.URL)); return false;"><img src="/assets/images/color/Facebook.png"></a></li>
                                          <li><a href="https://twitter.com/intent/tweet?source=http%3A%2F%2Fwww.southeasternrestaurantsupply.com%2Fproduct.php%3Fid%3D<?=$row['id']?>&text=:%20http%3A%2F%2Fwww.southeasternrestaurantsupply.com%2Fproduct.php%3Fid%3D502" target="_blank" title="Tweet" onclick="window.open('https://twitter.com/intent/tweet?text=' + encodeURIComponent(document.title) + ':%20'  + encodeURIComponent(document.URL)); return false;"><img src="/assets/images/color/Twitter.png"></a></li>
                                          <li><a href="https://plus.google.com/share?url=http%3A%2F%2Fwww.southeasternrestaurantsupply.com%2Fproduct.php%3Fid%3D<?=$row['id']?>" target="_blank" title="Share on Google+" onclick="window.open('https://plus.google.com/share?url=' + encodeURIComponent(document.URL)); return false;"><img src="/assets/images/color/Google+.png"></a></li>
                                            <li><a href="http://pinterest.com/pin/create/button/?url=http%3A%2F%2Fwww.southeasternrestaurantsupply.com%2Fproduct.php%3Fid%3D<?=$row['id']?>&media=http://www.southeasternrestaurantsupply.com/assets/images/logo.png&description=Restaurant%20equipment%20and%20refrigeration%20supplies" target="_blank" title="Pin it"><img src="http://www.southeasternrestaurantsupply.com/assets/images/color/Pinterest.png"></a></li>
                                          <li><a href="http://www.linkedin.com/shareArticle?mini=true&url=http%3A%2F%2Fwww.southeasternrestaurantsupply.com%2Fproduct.php%3Fid%3D<?=$row['id']?>&title=&summary=&source=http%3A%2F%2Fwww.southeasternrestaurantsupply.com%2Fproduct.php%3Fid%3D502" target="_blank" title="Share on LinkedIn" onclick="window.open('http://www.linkedin.com/shareArticle?mini=true&url=' + encodeURIComponent(document.URL) + '&title=' +  encodeURIComponent(document.title)); return false;"><img src="/assets/images/color/LinkedIn.png"></a></li>
                                          <li><a href="mailto:?subject=&body=:%20http%3A%2F%2Fwww.southeasternrestaurantsupply.com%2Fproduct.php%3Fid%3D<?=$row['id']?>" target="_blank" title="Email" onclick="window.open('mailto:?subject=' + encodeURIComponent(document.title) + '&body=' +  encodeURIComponent(document.URL)); return false;"><img src="/assets/images/color/Email.png"></a></li>
                                        </ul>
							           
							        </div>
								<style>
                                ul.share-buttons{
  list-style: none;
  padding: 0;
}

ul.share-buttons li{
  display: inline;
}
                                </style>
								</div>
								
							</div><!-- /.product-info -->
						</div><!-- /.col-sm-5 -->
					</div><!-- /.row -->
					 
					</div><!-- /.col -->
				</div><!-- /.row -->

					



						<!-- ============================================== RELATED PRODUCTS ============================================== -->
<div class="sidebar-widget hot-deals wow fadeInUp">
	<h3 class="section-title">hot deals</h3>
	<div class="owl-carousel related-product sidebar-carousel custom-carousel owl-theme outer-top-xs">
		
		<?do{?>												       
			<div class="item">
					<div class="products">
						<div class="hot-deal-wrapper">
							<div class="image">
								<a href="/product.php?id=<?=$row_3['id']?>">
								<img src="/uploads/t.php?src=/uploads/<?=$row_3['image']?>&amp;h=270&amp;w=270&amp;q=100&amp;zc=1" alt="">
							</a>
							</div>
							<!-- <div class="tag hot"><span>hot</span></div> -->
							
						</div><!-- /.hot-deal-wrapper -->

						<div class="product-info text-left m-t-20">
							<h3 class="name"><a href="/product.php?id=<?=$row_3['id']?>"><?=$row_3['name']?></a></h3> 
							<div class="description"><?=substr(strip_tags($row_3['description']), 0, 120);?>...</div>
								<div class="product-price">	
									<span class="price"><?if($row_3['price']!=='0.00'){?>
										$<?echo number_format($row_3['price'],2);}?>
									</span>
										<?if($row_3['old_price']!=='0.00' && $row_3['price']!=='0.00'){?>
										<span class="price-before-discount">$<?=number_format($row_3['old_price'],2)?>	
										</span>
										<?}?>					
								</div>
							 
							
						</div><!-- /.product-info -->

					 
					</div>	
					</div>		        
			<?} while ($row_3 = mysql_fetch_array($result_3));?>									 	        
						
	    
    </div><!-- /.sidebar-widget -->
</div>
<!-- ============================================== RELATED PRODUCTS: END ============================================== -->



			

		<!-- ============================================== FEATURED PRODUCT ============================================== -->

			<section class="section featured-product outer-top-small wow fadeInUp">
				<h3 class="section-title">similar products</h3>
				<div class="owl-carousel home-owl-carousel  custom-carousel owl-theme outer-top-xs" >
				    <?do{?>	
		<div class="item item-carousel">
			<div class="products">
				
	<div class="product">		
		<div class="product-image">
			<div class="image">
				<a href="/product.php?id=<?=$row_2['id']?>"><img  src="assets/images/blank.gif" data-echo="/uploads/t.php?src=/uploads/<?=$row_2['image']?>&amp;w=270&amp;h=270&amp;q=100&amp;zc=1" alt=""></a>
			</div><!-- /.image -->			

			                        <!-- <div class="tag hot"><span>hot</span></div>		 -->   
		</div><!-- /.product-image -->
			
		
		<div class="product-info text-left">
			<h3 class="name"><a href="/product.php?id=<?=$row_2['id']?>"><?=$row_2['name']?></a></h3>
			 
				<div class="description"><?=substr(strip_tags($row_2['description']), 0, 120);?>...</div>
 
			

			<div class="product-price">	
				<span class="price"><?if($row_2['price']!=='0.00'){?>
					$<?echo number_format($row_2['price'],2);}?>
				</span>
					<?if($row_2['old_price']!=='0.00' && $row_2['price']!=='0.00'){?>
					<span class="price-before-discount">$<?=number_format($row_2['old_price'],2)?>	
					</span>
					<?}?>					
			</div>
		</div><!-- /.product-info -->
					 
			</div><!-- /.product -->
      
			</div><!-- /.products -->
		</div><!-- /.item -->
	
		 
	<?} while ($row_2 = mysql_fetch_array($result_2));  ?>	
		 
	 
	 
	 
						</div><!-- /.home-owl-carousel -->
			</section><!-- /.section -->
		<!-- ============================================== FEATURED PRODUCT : END ============================================== -->


				
				
				<div class="clearfix"></div>
			
			<!-- ============================================== BRANDS CAROUSEL ============================================== -->
<? require "brands.php"; ?> 
<!-- ============================================== BRANDS CAROUSEL : END ============================================== -->		</div><!-- /.homepage-container -->
	</div><!-- /.container -->
</div><!-- /.body-content -->

<!-- ============================================================= FOOTER ============================================================= -->
<? require "footer.php"; ?>
<script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/1.4.5/numeral.min.js"></script>
<script type="text/javascript">

	$('#add_to_cart').click(function() {
		//var product_id = $(this).attr("data-id");
		var price =  numeral().unformat($("#original_price").text());
		var i=0;
		var options = [];
		$(".various").each(function(){ 
			if($(this).find("option[value='0']").length>0){
				i++;
				$(this).css("border-color", "red");
			}else{
				options.push($(this).val());
			} 
		     
		});
            
		 if(i==0){
		 var quantity = parseInt($("#quantity").val());
		 if(quantity >= parseInt($("#quantity").attr("min")) && quantity <= parseInt($("#quantity").attr("max")) && quantity>0){
		 var serialize = $('#serialize :input').serialize(); 
             
             $.ajax({
				url: '/add_to_cart.php',
				method: 'POST',
				data: {	
                serialize:serialize,
///					price: price,
				options: options
///					quantity:quantity,
///		product_id: product_id
				},
				success: function(data) { 
					  window.location.replace("/cart.php");
				}
			});
		 } 
			
		 } 
	});
	if ($(".various").length > 1) {
		var common_array = [];
		var original_price = parseFloat(<?=$row['price']?>);
		var count = $(".various").length + 1;
		$(".various").change(function() {
			$(this).css("border-color", "");
			var final_price = 0;
			$(this).find("option[value='0']").remove();
			var id = $(this).parents().eq(3).attr("data-id");
			var array = [];
			var action = parseInt($('option:selected', this).attr("act"));
			var price = parseFloat($('option:selected', this).attr("price")); 
			var old_price = parseFloat($('option:selected', this).attr("old_price"));
			if (action == 0) {
				various_price = 0;
				common_array[id] = 0;
				common_array[id] = various_price;
			} else if (action == 1) {
				various_price = parseFloat(price);
				common_array[id] = 0;
				common_array[id] = various_price;
			} else {
				various_price = parseFloat(-price);
				common_array[id] = 0;
				common_array[id] = various_price;
			}
			for (var i = 1; i < count; i++) {
				var ar = common_array['sel' + i];
				var p = parseInt(ar);
				if (isNaN(p)) {
					final_price += 0;
				} else {
					final_price += parseFloat(p);
				}
			}
			$("#original_price").text(numeral(original_price + final_price).format('$0,0.00'));

			if(old_price=="0.00"){

				$("#old_price").text(numeral(old_price).format('$0,0.00'));
			}
			
		});
	} else {
		$(".various").change(function() {
			$(this).css("border-color", "");
			$(this).find("option[value='0']").remove();
			var original_price = parseFloat(<?=$row['price']?>);
			var action = parseInt($('option:selected', this).attr("act"));
			var price = parseFloat($('option:selected', this).attr("price"));
			var old_price = parseFloat($('option:selected', this).attr("old_price")); 
			if(old_price>0){
				$("#old_price").text(numeral(old_price).format('$0,0.00'));
			}
			if (action == 0) {
				$("#original_price").text(numeral(original_price).format('$0,0.00'));
			} else if (action == 1) {
				$("#original_price").text(numeral(original_price + price).format('$0,0.00'));
			} else {
				$("#original_price").text(numeral(original_price - price).format('$0,0.00'));
			}
		});
	}
</script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css" />

