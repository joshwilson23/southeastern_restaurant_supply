<? @require "config.php";?>

<?php
if (isset($_SESSION['user_id']))
    {
	@$u = $_SESSION['user_id'];
	$u_n = mysql_query("SELECT firstname FROM users  WHERE   `id`='$u'");
	$n_u = mysql_fetch_array($u_n);
	}
  else
	{
	if (isset($_COOKIE['user_id']) && !is_numeric($_COOKIE['user_id']))
		{
		 
			@$u = $_COOKIE['user_id'];
		 
		}
	  else
		{
		$u = "";
		}
	}

$cart_count = mysql_query("SELECT COUNT(*) as `count` FROM `cart` WHERE   `user_id`='$u'");
$count_cart = mysql_result($cart_count, 0, 'count');

$result_ic          = mysql_query("SELECT * FROM  icons", $db);
$row_ic             = mysql_fetch_array($result_ic);

if ($count_cart > 0)
	{
	$result_cart = mysql_query("SELECT *  FROM cart where user_id='$u'", $db);
	$row_cart = mysql_fetch_array($result_cart);
	$a = 0;
	do
		{
		$a+= $row_cart['price'] * $row_cart['quantity'];
		}

	while ($row_cart = mysql_fetch_array($result_cart));
	}
  else
	{
	$a = 0;
	}

?>

<div class="top-bar animate-dropdown">
    <div class="container">
		<div class="header-top-inner">
			<div class="cnt-account">
				<ul class="list-unstyled">
					 
					
                    <?if (!isset($_SESSION['user_id'])){?>
                    <li><a href="/checkout.php"><i class="icon fa fa-shopping-cart"></i>Checkout</a></li>
                    <li><a href="/signup.php"><i class="icon fa fa-user"></i>Sign up</a></li>
                    
					<li><a href="/signin.php"><i class="icon fa fa-sign-in"></i>Login</a></li>
                    <?}else{?>
                      <li>Hello, <?=$n_u['firstname']?>!</li> 
                    <li><a href="/orders.php"><i class="icon fa fa-th-list"></i>Orders</a></li> 
                     <li><a href="/account.php"><i class="icon fa fa-user"></i>My Account</a></li> 
                     <li><a href="/checkout.php"><i class="icon fa fa-shopping-cart"></i>Checkout</a></li>
                     <li><a href="/logout.php"><i class="icon fa fa-sign-out"></i>Logout</a></li>
                     
                     <?}?>
				</ul>
			</div><!-- /.cnt-account -->

 <div class="cnt-block">
    	<ul class="share-buttons">
        
        <?if($row_ic['f_ch']==1){?>
<li><a href="<?=$row_ic['f']?>" title="We are on Facebook" target="_blank"><img src="https://southeasternrestaurantsupply.com/assets/images/color/Facebook.png"></a></li>

        <?}else{?>
  <li><a href="https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Fwww.southeasternrestaurantsupply.com%2F&t=Restaurant%20supply" title="Share on Facebook" target="_blank"><img src="https://southeasternrestaurantsupply.com/assets/images/color/Facebook.png"></a></li>
  <?}?>
  
  <?if($row_ic['t_ch']==1){?>
    <li><a href="<?=$row_ic['t']?>" target="_blank" title="We are on Twitter"><img src="https://southeasternrestaurantsupply.com/assets/images/color/Twitter.png"></a></li>

    <?}else{?>
  <li><a href="https://twitter.com/intent/tweet?source=http%3A%2F%2Fwww.southeasternrestaurantsupply.com%2F&text=Restaurant%20supply:%20http%3A%2F%2Fwww.southeasternrestaurantsupply.com%2F" target="_blank" title="Tweet"><img src="https://southeasternrestaurantsupply.com/assets/images/color/Twitter.png"></a></li>
 <?}?>
   <?if($row_ic['g_ch']==1){?>
    <li><a href="<?=$row_ic['g']?>" target="_blank" title="We are on Google+"><img src="https://southeasternrestaurantsupply.com/assets/images/color/Google+.png"></a></li>

   <?}else{?>
 <li><a href="https://plus.google.com/share?url=http%3A%2F%2Fwww.southeasternrestaurantsupply.com%2F" target="_blank" title="Share on Google+"><img src="https://southeasternrestaurantsupply.com/assets/images/color/Google+.png"></a></li>
 <?}?>
 
 <li><a href="http://pinterest.com/pin/create/button/?url=http%3A%2F%2Fwww.southeasternrestaurantsupply.com%2F&media=https://www.southeasternrestaurantsupply.com/assets/images/logo.png&description=Restaurant%20equipment%20and%20refrigeration%20supplies" target="_blank" title="Pin it"><img src="https://southeasternrestaurantsupply.com/assets/images/color/Pinterest.png"></a></li>
  
    <?if($row_ic['l_ch']==1){?>
      <li><a href="<?=$row_ic['l']?>" target="_blank" title="We are on LinkedIn"><img src="https://southeasternrestaurantsupply.com/assets/images/color/LinkedIn.png"></a></li>

     <?}else{?>
  <li><a href="http://www.linkedin.com/shareArticle?mini=true&url=http%3A%2F%2Fwww.southeasternrestaurantsupply.com%2F&title=Restaurant%20supply&summary=Restaurant%20equipment%20and%20refrigeration%20supplies&source=http%3A%2F%2Fwww.southeasternrestaurantsupply.com%2F" target="_blank" title="Share on LinkedIn"><img src="https://southeasternrestaurantsupply.com/assets/images/color/LinkedIn.png"></a></li>
   <?}?>
  
  <li><a href="https://pinboard.in/popup_login/?url=http%3A%2F%2Fwww.southeasternrestaurantsupply.com%2F&title=Restaurant%20supply&description=Restaurant%20equipment%20and%20refrigeration%20supplies" target="_blank" title="Save to Pinboard"><img src="https://southeasternrestaurantsupply.com/assets/images/color/Pinboard.png"></a></li>
</ul>
			</div>
			<div class="clearfix"></div><style>
                                ul.share-buttons{
  list-style: none;
  padding: 0;
}

ul.share-buttons li{
  display: inline;
}
                                </style>
		</div><!-- /.header-top-inner -->
	</div><!-- /.container -->
</div>
<!-- ============================================== TOP MENU : END ============================================== -->
    <div class="main-header">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-3 logo-holder">
                    <!-- ============================================================= LOGO ============================================================= -->
<div class="logo">
    <a href="/">
        
        <img src="/assets/images/logo.png" alt="">

    </a>
</div><!-- /.logo -->
<!-- ============================================================= LOGO : END ============================================================= -->             </div><!-- /.logo-holder -->

                <div class="col-xs-12 col-sm-12 col-md-6 top-search-holder">
                    <div class="contact-row">
    <div class="phone inline">
        <i class="icon fa fa-phone"></i> (888) 308-4885
    </div>
    <div class="contact inline">
        <i class="icon fa fa-envelope"></i> sales@southeasternrestaurantsupply.com
    </div>
</div><!-- /.contact-row -->
<!-- ============================================================= SEARCH AREA ============================================================= -->
<div class="search-area">
    <form action="/search.php" method="GET" id="search_form">
        <div class="control-group">
<!-- 
            <ul class="categories-filter animate-dropdown">
                <li class="dropdown">

                    <a class="dropdown-toggle"  data-toggle="dropdown" href="category.html">Categories <b class="caret"></b></a>

                    <ul class="dropdown-menu" role="menu" >
                        <li class="menu-header">Computer</li>
                        <li role="presentation"><a role="menuitem" tabindex="-1" href="category.html">- Laptops</a></li>
                        <li role="presentation"><a role="menuitem" tabindex="-1" href="category.html">- Tv & audio</a></li>
                        <li role="presentation"><a role="menuitem" tabindex="-1" href="category.html">- Gadgets</a></li>
                        <li role="presentation"><a role="menuitem" tabindex="-1" href="category.html">- Cameras</a></li>

                    </ul>
                </li>
            </ul> -->

            <input class="search-field" name="query" placeholder="Search here..." />

            <a class="search-button" id="search_it" href="#" ></a>    
 
        </div>
    </form>
</div><!-- /.search-area -->
<!-- ============================================================= SEARCH AREA : END ============================================================= -->              </div><!-- /.top-search-holder -->

<div class="col-xs-12 col-sm-12 col-md-3 animate-dropdown top-cart-row">
                    <!-- ============================================================= SHOPPING CART DROPDOWN ============================================================= -->

    <div class="dropdown dropdown-cart">
        <a href="/cart.php" class="dropdown-toggle lnk-cart" >
            <div class="items-cart-inner">
                <div class="total-price-basket">
                    <span class="lbl">cart -</span>
                    <span class="total-price">
                        <span class="sign">$</span>
                        <span class="value" id="total_price_top"><?=number_format($a,2)?></span>
                    </span>
                </div>
                <div class="basket">
                    <i class="glyphicon glyphicon-shopping-cart"></i>
                </div>
                <div class="basket-item-count"><span class="count"><?=$count_cart?></span></div>
            
            </div>
        </a>
         
    </div><!-- /.dropdown-cart -->

<!-- ============================================================= SHOPPING CART DROPDOWN : END============================================================= -->                </div><!-- /.top-cart-row -->
            </div><!-- /.row -->

        </div><!-- /.container -->

    </div><!-- /.main-header -->