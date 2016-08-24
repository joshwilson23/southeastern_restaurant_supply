<? require "config.php"; 
function no($str) {
				$str = stripslashes($str);
				$str = mysql_real_escape_string($str);
				$str = trim($str);
				$str = htmlspecialchars($str);
				return $str;
}
if(isset($_SESSION['user_id'])){
    
   @$u = $_SESSION['user_id']; 
}else{
  @$u = no($_COOKIE['user_id']);  
}

$result          = mysql_query("SELECT * FROM  cart where user_id='$u'", $db);
$row             = mysql_fetch_array($result);
// $result_2         = mysql_query("SELECT * FROM  products order by rand()", $db);
// $row_2           = mysql_fetch_array($result_2);
if (isset($_COOKIE['state_zipcode'])) { 
      $zip_to =  no($_COOKIE['state_zipcode']);
  }else{
  	$zip_to = "";
  }
if(!isset($u) || empty($row['id'])) {
header('Location: https://southeasternrestaurantsupply.com/'); 
}

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<!-- Meta -->
		<meta charset="utf-8">
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
		<meta name="description" content="Your cart">
		<meta name="author" content="">
	    <meta name="keywords" content="Cart">
	    <meta name="robots" content="all">

	    <title>Cart - Southeastern Restaurant Supply</title>

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
<div class="body-content"> 
<div class="container">
<div class="row inner-bottom-sm">
			<div class="shopping-cart">
				<div class="col-md-12 col-sm-12 shopping-cart-table ">
	<div class="table-responsive">
		<table class="table table-bordered">
			<thead>
				<tr>
					<th class="cart-romove item">Remove</th>
					<th class="cart-description item">Image</th>
					<th class="cart-product-name item">Product Name</th> 
					<th class="cart-qty item">Quantity</th>
					<th class="cart-sub-total item">Item price</th>
					<th class="cart-total last-item">Total</th>
				</tr>
			</thead><!-- /thead -->
			<!-- <tfoot>
				<tr>
					<td colspan="7">
						<div class="shopping-cart-btn">
							<span class="">
								<a href="#" class="btn btn-upper btn-primary outer-left-xs">Continue Shopping</a>
								<a href="#" class="btn btn-upper btn-primary pull-right outer-right-xs">Update shopping cart</a>
							</span>
						</div> 
					</td>
				</tr>
			</tfoot> -->
			<tbody>
                <?$sub_total = 0;?>
				<?do{?>
				<?
				$product_id = $row['product_id'];
				$result_2         = mysql_query("SELECT * FROM  products where id='$product_id'", $db);
				$row_2           = mysql_fetch_array($result_2);
				?>
				<tr>
					<td class="romove-item" data-id="<?=$row['id']?>"><a style="cursor:pointer;" title="cancel" class="icon"><i class="fa fa-trash-o"></i></a></td>
					<td class="cart-image">
						<a class="entry-thumbnail" href="/product.php?id=<?=$row_2['id']?>">
						    <img src="/uploads/t.php?src=/uploads/<?=$row_2['image']?>&amp;h=154&amp;w=154&amp;q=100&amp;zc=1" alt="">
						</a>
					</td>
					<td class="cart-product-name-info">
						<h4 class='cart-product-description'><a href="/product.php?id=<?=$row_2['id']?>"><?=$row_2['name']?></a></h4>
					 <?if(!empty($row['various'])){?>
						<div class="cart-product-info">
							<?foreach (explode('|||',$row['various']) as  $v) {?>
								<i class="fa fa-flag"></i> <span style="color:#D33433;"><?=$v?></span><br> 
							<?}?>
							
						</div>
						<?} ?>
					</td>
					 
					<td class="cart-product-quantity">
						<input type="number"  min="1" max="<?=$row_2['quantity']?>" step="1"  value="<?=$row['quantity']?>" style="width:69px;" data-id="<?=$row['id']?>" class="change_quantity">
						<!-- <div class="quant-input">
				                <div class="arrows">
				                  <div class="arrow plus gradient"><span class="ir"><i class="icon fa fa-sort-asc"></i></span></div>
				                  <div class="arrow minus gradient"><span class="ir"><i class="icon fa fa-sort-desc"></i></span></div>
				                </div>
				                
			              </div> -->
		            </td>
					<td class="cart-product-sub-total"><span class="cart-sub-total-price">$<?=number_format($row['price'],2)?></span></td>
					<td class="cart-product-grand-total"><span class="cart-grand-total-price">$<?=number_format($row['price']*$row['quantity'],2)?>			</span></td>
				</tr>
                <?$sub_total += $row['price']*$row['quantity'];?>
				<?} while ($row = mysql_fetch_array($result))?> 
			</tbody><!-- /tbody -->
		</table><!-- /table -->
	</div>
</div><!-- /.shopping-cart-table -->				
 

 <div class="col-md-4 col-sm-12 estimate-ship-tax">
 <table class="table table-bordered">
		<thead>
			<tr>
				<th>
					<span class="estimate-title" style="    margin-bottom: -1px;    font-size: 17px;">Discount</span> 
				</th>
			</tr>
		</thead>
		<tbody>
				<tr>
					<td>
                    <div class="form-group text-center" id="spinner_2" style="display:none;">
    					  <img src="/facebook.gif" height="112px">
						  </div>
						<div class="form-group coupon">
                            <label class="info-title control-label" id="coupon_respond"></label>
							<input type="text" class="form-control unicase-form-control text-input" id="code" value="<?if(isset($_SESSION['code'])){echo $_SESSION['code'];}?>" placeholder="Enter your coupon code">
						</div>
						<div class="clearfix pull-right coupon">
							<button type="submit" id="apply_coupon" class="btn-upper btn btn-primary">APPLY COUPON</button>
						</div>
					</td>
				</tr>
		</tbody> 
	</table>   
</div>    
<div class="col-md-4 col-sm-12 estimate-ship-tax">
	<table class="table table-bordered">
		<thead>
			<tr>
				<th>
					<span class="estimate-title"  style="    margin-bottom: -1px;    font-size: 17px;">Estimate shipping and tax</span> 
				</th>
			</tr>
		</thead> 

		<tbody>

				<tr>
					<td>  <div class="form-group text-center" id="spinner" style="display:none;">
						  <img src="/facebook.gif" height="112px">
						  </div>

						 <div class="form-group" id="spinner_remove1"> 
							<label class="info-title control-label">Option for shipping<span>*</span></label>
							<select id="ship_option" class="form-control unicase-form-control selectpicker"> 
								<option value="0">Residential</option> 
								<option value="1">Business With Dock Or Forklift</option> 
								<option value="2">Business Without Dock Or Forklift</option> 
								<option value="3">Terminal</option> 
								<option value="4">Construction Site</option> 
								<option value="5">Convention Center Or Tradeshow</option>  
							</select>
						</div>

						<div class="form-group" id="spinner_remove2"> 
							<input type="text" class="form-control unicase-form-control text-input" style="    width: 60%;" placeholder="Zip/Postal Code" value="<?=$zip_to?>" id="get_quote_input">
							<div class="pull-right" style="margin-top: -38px;">
							<button id="get_quote" type="submit" class="btn-upper btn btn-primary">GET A QUOTE</button>
						</div>
						</div>
						
					</td>
				</tr>
		</tbody>
	</table>
</div>   
<div class="col-md-4 col-sm-12 cart-shopping-total">
	<table class="table table-bordered">
		<thead>
			<tr>
				<th>
					  <div>
					  	<div style="float:left;">
						Subtotal
						</div>
						<span class="inner-left-md" id="sub_total">$<?=number_format($sub_total,2)?></span>
					</div>  <hr>
                    <div>
    				  	<div style="float:left;">
						Saving
						</div>
						<span class="inner-left-md" id="saving">$<?if(isset($_SESSION['code'])){echo number_format($sub_total/100*$_SESSION['discount'],2);}else{echo "0.00";}?></span>
					</div>  <hr>
					<div>
						<div style="float:left;">
						Shipping
						</div>
						<span class="inner-left-md" id="shipping">.........</span>
					</div> 
					<hr> 
					<div>
						<div style="float:left;">
						Tax
						</div>
						<span class="inner-left-md" id="tax">.........</span>
					</div>  
					<hr>
					<div class="cart-grand-total" >
						<div style="float:left;">Total
						</div><span class="inner-left-md" id="total">.........</span>
					</div>
				</th>
			</tr>
		</thead><!-- /thead -->
		<tbody>
				<tr>
					<td>
						<div class="cart-checkout-btn pull-right">
							<a href="/checkout.php">
							<button type="submit"   class="btn btn-primary">CHEKOUT</button>
						</a>
							 
						</div>
					</td>
				</tr>
		</tbody><!-- /tbody -->
	</table><!-- /table -->
</div><!-- /.cart-shopping-total -->			</div><!-- /.shopping-cart -->
		</div>
<!-- ============================================== BLOG SLIDER : END ============================================== -->

      <!-- ============================================== BRANDS CAROUSEL ============================================== -->
<? require "brands.php"; ?>
<!-- ============================================== BRANDS CAROUSEL : END ============================================== -->	
	

	</div><!-- /.container -->
</div><!-- /#top-banner-and-menu -->




<? require "footer.php"; ?>
 <script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/1.4.5/numeral.min.js"></script>

<script type="text/javascript">
	
	$(document).ready(function() {
    var discount = <? if(isset($_SESSION['discount'])){echo $_SESSION['discount']; }else{echo 0;} ?>;
		function total() {
		    var total = 0;
   			$( ".cart-grand-total-price" ).each(function() {
			  total += numeral().unformat($(this).text());
              //total = total - numeral().unformat($("#saving").text());
              
			});
   			 $("#sub_total").text(numeral(total).format('$0,0.00'));
                $("#saving").text(numeral(total/100*discount).format('$0,0.00'));
   			 //$("#total").text(numeral(total).format('$0,0.00'));
   			  $("#total_price_top").text(numeral(total).format('0,0.00'));
		}

		function reset_calculate(){
			$("#shipping").text(".........");
			$("#tax").text(".........");
			$("#total").text(".........");
		}
   			
		 total();
		$(".change_quantity").change(function() {
			var quantity = parseInt($(this).val());
			var max = parseInt($(this).attr("max")); 
			if(quantity>0 && quantity <= max){
			var sub =  numeral().unformat($(this).parent().parent().find(".cart-sub-total-price").text());
			var total_in_line =  $(this).parent().parent().find(".cart-grand-total-price").text(numeral(sub*quantity).format('$0,0.00'));

			total();
			reset_calculate();
			var id = parseInt($(this).attr("data-id")); 
			var quantity = parseInt($(this).val());
          	$.ajax({
				url: '/quantity.php',
				method: 'POST',
				data: {	
					quantity:quantity,
					id: id
				},
				success: function(data) {   
				}
			});
          }
		});

    $('body').on('click', '.romove-item', function(){ 
          $(this).parent().fadeOut("normal", function() {
				$(this).remove();
				total();
				$(".count").text($(".romove-item").length);

			});
           var id = parseInt($(this).attr("data-id")); 
          	$.ajax({
				url: '/remove_from_cart.php',
				method: 'POST',
				data: {	
					 
					id: id
				},
				success: function(data) { 
                if ($(".romove-item").length > 1) {
    			reset_calculate();
					  
				} else {
					 window.location.replace("/");
				}
				}
			});
          
         
		
                 
        });


        $('body').on('click', '#apply_coupon', function(){ 
           
           var code = $.trim($("#code").val());   
           if(code.length>0){
           	$( ".coupon" ).hide(); 
			$( "#spinner_2" ).show(); 
          	$("#code").css("border-color","");
          	$.ajax({
				url: '/do_coupon.php',
				method: 'POST',
				data: {	
					code:code
				},
				success: function(data) {   
				$( ".coupon" ).show(); 
				$( "#spinner_2" ).hide();   
				var json = $.parseJSON(data); 
                if (json.action){
                color = "green";
                $("#saving").text(json.saving);
                discount =  json.discount;
                }else{
                  color = "red";
                  $("#saving").text("$0.00");
                }
                
				 $("#coupon_respond").text(json.message).css("color", color);
             	
     		     
				}
			});
          }else{ 
          	$("#code").css("border-color","red");
          }

          
         
		
                 
        });
        
                $('body').on('click', '#get_quote', function(){ 
           
           var zip = $.trim($("#get_quote_input").val());  
           var ship_option = $( "#ship_option option:selected" ).val();
           if(zip.length==5){
               $( "#spinner_remove1" ).hide();
			$( "#spinner_remove2" ).hide(); 
			$( "#spinner" ).show(); 
          	$("#get_quote_input").css("border-color","");
          	$.ajax({
				url: '/get_quote.php',
				method: 'POST',
				data: {	
					ship_option:ship_option,
					zip: zip
				},
				success: function(data) { 
				$( "#spinner_remove1" ).show();
				$( "#spinner_remove2" ).show();
				$( "#spinner" ).hide();   
				var json = $.parseJSON(data); 
				if(json.FAILED=="ERROR"){
					alert("This zip code is not belong to U.S!")
				}else{ 
						$("#shipping").text(numeral(json.shipping).format('$0,0.00'));
						 
						var sub_total = numeral().unformat($("#sub_total").text());
						$("#tax").text(numeral(json.tax).format('$0,0.00'));
						$("#total").text(numeral(json.total).format('$0,0.00'));


				}
             	
     		     
				}
			});
          }else{ 
          	$("#get_quote_input").css("border-color","red");
          }

          
         
		
                 
        });

	});
 
 
</script>