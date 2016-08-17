 <? @require "config.php";  
$result_footer          = mysql_query("SELECT * FROM  categories where sub_category!='0' ORDER BY RAND() limit 5", $db);
$row_footer           = mysql_fetch_array($result_footer);

$result_footer_product          = mysql_query("SELECT * FROM  products  ORDER BY RAND() limit 5", $db);
$row_footer_product           = mysql_fetch_array($result_footer_product);

$result_footer_brand          = mysql_query("SELECT * FROM  manufacturers  ORDER BY RAND() limit 5", $db);
$row_footer_brand          = mysql_fetch_array($result_footer_brand);
?> 
 <!-- ============================================================= FOOTER ============================================================= -->
<footer id="footer" class="footer color-bg">
	  <div class="links-social inner-top-sm">
        <div class="container">
            <div class="row">
            	<div class="col-xs-12 col-sm-6 col-md-3">
            		 <!-- ============================================================= CONTACT INFO ============================================================= -->
<div class="contact-info">
    <div class="footer-logo">
        <div class="logo">
            <a href="/">
                
                <img src="assets/images/logo.png" alt="">

            </a>
        </div><!-- /.logo -->
    
    </div><!-- /.footer-logo -->

     <div class="module-body m-t-20">
        <p class="about-us"> WELCOME TO SOUTHEASTERN RESTAURANT SUPPLY!</p>
    
        
    </div><!-- /.module-body -->

</div><!-- /.contact-info -->
<!-- ============================================================= CONTACT INFO : END ============================================================= -->            	</div><!-- /.col -->

            	<div class="col-xs-12 col-sm-6 col-md-3">
            		 <!-- ============================================================= CONTACT TIMING============================================================= -->
<div class="contact-timing" style="display:none;">
	<div class="module-heading">
		<h4 class="module-title">opening time</h4>
	</div><!-- /.module-heading -->

	<div class="module-body outer-top-xs">
		<div class="table-responsive">
			<p class='contact-number' style="text-align:center;">1.855.835.5777</p>
		</div><!-- /.table-responsive -->
		
	</div><!-- /.module-body -->
</div><!-- /.contact-timing -->
<!-- ============================================================= CONTACT TIMING : END ============================================================= -->            	</div><!-- /.col -->

            	<div class="col-xs-12 col-sm-6 col-md-3">
            		 <!-- ============================================================= LATEST TWEET============================================================= -->
<div class="latest-tweet">
	<div class="module-heading">
		<h4 class="module-title">latest tweet</h4>
	</div><!-- /.module-heading -->

	<div class="module-body outer-top-xs">
       <div class="re-twitter">
            <div class="comment media">
                <div class='pull-left'>
                    <span class="icon fa-stack fa-lg">
                      <i class="fa fa-circle fa-stack-2x"></i>
                      <i class="fa fa-twitter fa-stack-1x fa-inverse"></i>
                    </span>
                </div>
                <div class="media-body">
                    <a href="#">@laurakalbag</a> As a result of your previous recommendation :) 
                    <span class="time">
                        12 hours ago
                    </span>
                </div>
            </div>
           
        </div>
        <div class="re-twitter">
            <div class="comment media">
                <div class='pull-left'>
                    <span class="icon fa-stack fa-lg">
                      <i class="fa fa-circle fa-stack-2x"></i>
                      <i class="fa fa-twitter fa-stack-1x fa-inverse"></i>
                    </span>
                </div>
                <div class="media-body">
                    <a href="#">@laurakalbag</a> As a result of your previous recommendation :) 
                    <span class="time">
                        12 hours ago
                    </span>
                </div>
            </div>
        </div>
    </div><!-- /.module-body -->
</div><!-- /.contact-timing -->
<!-- ============================================================= LATEST TWEET : END ============================================================= -->            	</div><!-- /.col -->

            	<div class="col-xs-12 col-sm-6 col-md-3">
            		 <!-- ============================================================= INFORMATION============================================================= -->
<div class="contact-information" style="display:none;">
	<div class="module-heading">
		<h4 class="module-title">information</h4>
	</div><!-- /.module-heading -->

	<div class="module-body outer-top-xs" style="display:none;">
        <ul class="toggle-footer" style="">
            <li class="media">
                <div class="pull-left">
                     <span class="icon fa-stack fa-lg">
                      <i class="fa fa-circle fa-stack-2x"></i>
                      <i class="fa fa-map-marker fa-stack-1x fa-inverse"></i>
                    </span>
                </div>
                <div class="media-body">
                    <p>445 Corday St #2, Pensacola, FL 32503</p>
                </div>
            </li>

              <li class="media">
                <div class="pull-left">
                     <span class="icon fa-stack fa-lg">
                      <i class="fa fa-circle fa-stack-2x"></i>
                      <i class="fa fa-mobile fa-stack-1x fa-inverse"></i>
                    </span>
                </div>
                <div class="media-body">
                    <p> (888) 308-4885 </p>
                </div>
            </li>

              <li class="media">
                <div class="pull-left">
                     <span class="icon fa-stack fa-lg">
                      <i class="fa fa-circle fa-stack-2x"></i>
                      <i class="fa fa-envelope fa-stack-1x fa-inverse"></i>
                    </span>
                </div>
                <div class="media-body">
                    <span><a href="#">sales@southeasternrestaurantsupply.com</a></span>  
                </div>
            </li>
              
            </ul>
    </div><!-- /.module-body -->
</div><!-- /.contact-timing -->
<!-- ============================================================= INFORMATION : END ============================================================= -->            	</div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container -->
    </div><!-- /.links-social -->

     
 <div class="footer-bottom inner-bottom-sm">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-3">
                    <div class="module-heading outer-bottom-xs">
                        <h4 class="module-title">categories</h4>
                    </div><!-- /.module-heading -->

                    <div class="module-body">
                        <ul class='list-unstyled'> 
                            <?do{?>
                            <li><a href="/category.php?id=<?=$row_footer['id']?>"><?=$row_footer['name']?></a></li>
                            <?} while ($row_footer = mysql_fetch_array($result_footer))?> 
                        </ul>
                    </div><!-- /.module-body -->
                </div><!-- /.col -->

                <div class="col-xs-12 col-sm-6 col-md-3">
                    <div class="module-heading outer-bottom-xs">
                        <h4 class="module-title">Products</h4>
                    </div><!-- /.module-heading -->

                    <div class="module-body">
                        <ul class='list-unstyled'>
                            <?do{?>
                            <li><a href="/product.php?id=<?=$row_footer_product['id']?>"><?=$row_footer_product['name']?></a></li>
                            <?} while ($row_footer_product = mysql_fetch_array($result_footer_product))?> 
                        </ul>
                    </div><!-- /.module-body -->
                </div><!-- /.col -->

                <div class="col-xs-12 col-sm-6 col-md-3">
                    <div class="module-heading outer-bottom-xs">
                        <h4 class="module-title">Manufacturers</h4>
                    </div><!-- /.module-heading -->

                    <div class="module-body">
                        <ul class='list-unstyled'>
                            <?do{?>
                            <li><a href="#"><?=$row_footer_brand['name']?></a></li>
                            <?} while ($row_footer_brand = mysql_fetch_array($result_footer_brand))?> 
                        </ul>
                    </div><!-- /.module-body -->
                </div><!-- /.col -->

                <div class="col-xs-12 col-sm-6 col-md-3">
                    <div class="module-heading outer-bottom-xs">
                        <h4 class="module-title">SUpport    </h4>
                    </div><!-- /.module-heading -->

                    <div class="module-body">
                        <ul class='list-unstyled'>
                        <li><a href="/blog.php">Blog</a></li>
                            <li><a href="#">FAQ</a></li>
                            <li><a href="/terms.php">Terms &amp; Conditions</a></li>
                            <li><a href="#">Contacts</a></li> 
                            <li><a href="#">About Us</a></li>
                        </ul>
                    </div><!-- /.module-body -->
                </div>
            </div>
        </div>
    </div>
    <div class="copyright-bar">
        <div class="container">
            <div class="col-xs-12 col-sm-6 no-padding">
                <div class="copyright">
                   Copyright © 2016
                    - All rights Reserved
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 no-padding">
                <div class="clearfix payment-methods">
                    <ul> 
                        <li><img src="assets/images/payments/mastercard.png" alt=""></li>
                        <li><img src="assets/images/payments/amex.png" alt=""></li>
                        <li><img src="assets/images/payments/diners.png" alt=""></li>
                        <li><img src="assets/images/payments/visa.png" alt=""></li>
                        <li><img src="assets/images/payments/discover.png" alt=""></li>
                    </ul>
                </div><!-- /.payment-methods -->
            </div>
        </div>
    </div>
</footer>
<!-- ============================================================= FOOTER : END============================================================= -->



	<script src="assets/js/jquery-1.11.1.min.js"></script>
	    <script src="/assets/js/jquery.number.js"></script>
	<script src="assets/js/bootstrap.min.js"></script>
	
	<script src="assets/js/bootstrap-hover-dropdown.min.js"></script>
	<script src="assets/js/owl.carousel.min.js"></script>
	
	<script src="assets/js/echo.min.js"></script>
	<script src="assets/js/jquery.easing-1.3.min.js"></script>
	<script src="assets/js/bootstrap-slider.min.js"></script>
    <script src="assets/js/jquery.rateit.min.js"></script>
    <script type="text/javascript" src="assets/js/lightbox.min.js"></script>
    <script src="assets/js/bootstrap-select.min.js"></script>
    <script src="assets/js/wow.min.js"></script>
	<script src="assets/js/scripts.js"></script>

	<script src="switchstylesheet/switchstylesheet.js"></script>
	
	<script>
	   
$('#search_it').click(function() {
    if($.trim($("input[name=query]").val()).length<=2){
        $("input[name=query]").css("border","1px solid red");
    }else{
        $("#search_form").submit();
    }
});
$('#search_form').on('keyup keypress', function(e) {
  var keyCode = e.keyCode || e.which;
  if (keyCode === 13) { 
    e.preventDefault(); 
     if($.trim($("input[name=query]").val()).length<=2){
        $("input[name=query]").css("border","1px solid red");
    }else{
        $("#search_form").submit();
    }
  }
});
//	$(window).bind("load", function() {
//		   $('.show-theme-options').delay(2000).trigger('click');
//		});
	</script>
 
	
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-78809970-1', 'auto');
  ga('send', 'pageview');

</script>
</body>
</html> 
<?if(isset($_SESSION['f_p'])) {unset($_SESSION['f_p']);}
if(isset($_SESSION['s_p'])) {unset($_SESSION['s_p']);} 
if(isset($_SESSION['f_p1'])) {unset($_SESSION['f_p1']);} 
if(isset($_SESSION['s_p1'])) {unset($_SESSION['s_p1']);} 
 ?> 