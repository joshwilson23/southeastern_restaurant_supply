<? @require "config.php";  
$result_menu          = mysql_query("SELECT * FROM  categories where sub_category='0' AND id!='50' AND id!='51'", $db);
$row_menu             = mysql_fetch_array($result_menu);
// $result_2         = mysql_query("SELECT * FROM  products order by rand()", $db);
// $row_2           = mysql_fetch_array($result_2);
 
?> 

	<!-- ============================================== NAVBAR ============================================== -->
<div class="header-nav animate-dropdown">
    <div class="container">
        <div class="yamm navbar navbar-default" role="navigation">
            <div class="navbar-header">
                <button data-target="#mc-horizontal-menu-collapse" data-toggle="collapse" class="navbar-toggle collapsed" type="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <div class="nav-bg-class">
                <div class="navbar-collapse collapse" id="mc-horizontal-menu-collapse">
	<div class="nav-outer">
		<ul class="nav navbar-nav" style="width: 1166px;">
        <li class="dropdown">
                <a href="/">Home</a>
        </li>
        <?do{?>
			<li class="dropdown yamm-fw">
				<a href="/" data-hover="dropdown" class="dropdown-toggle" data-toggle="dropdown"><?=$row_menu['name']?></a>
				<ul class="dropdown-menu">
					<li>
						<div class="yamm-content">
    
            <div class="row">
                <div class='col-md-12'>
                <?
                $xx = 0;
                $sub_category = $row_menu['id'];
                $result_sub_menu          = mysql_query("SELECT * FROM  categories where sub_category='$sub_category'", $db);
                $row_sub_menu             = mysql_fetch_array($result_sub_menu);
                $menu_count      = mysql_query("SELECT COUNT(*) as `count` FROM categories where sub_category='$sub_category'");
                $count_menu          = mysql_result($menu_count, 0, 'count');

                ?>
  


                            <?$x=0;$xx=0;?>
                            <?do{ 
                            $x++;
                            $xx++;
                            if ($x == 1){
                                echo '<div class="col-xs-12 col-sm-6 col-md-3">
                                        <ul class="links">';
                            }?>

                            <li><a href="/category.php?id=<?=$row_sub_menu['id']?>"><img src="/uploads/<?=$row_sub_menu['image']?>" width="70" style="display:inline-block;"> <?=$row_sub_menu['name']?></a></li> 
                             <?if ($x == 2 || $xx==$count_menu){ 
                                $x=0;
                                echo '</ul> </div> ';
                            }?>


                            <?} while ($row_sub_menu = mysql_fetch_array($result_sub_menu)); ?>
                        


                        
               
                     

                     

                    

                    </div>
                
             
    </div> 
 
</div> 				</li>
				</ul>
			</li>

            <?} while ($row_menu = mysql_fetch_array($result_menu)); ?>
			
            <li class="dropdown">
                <a href="/category.php?id=57">Janitorial</a>
            </li>
            <li class="dropdown">
                <a href="/category.php?id=51">Clearance</a>
            </li>

            <li class="dropdown">
                <a href="/category.php?id=50">Parts</a>
            </li>
			
		</ul><!-- /.navbar-nav -->
		<div class="clearfix"></div>				
	</div><!-- /.nav-outer -->
</div><!-- /.navbar-collapse -->


            </div><!-- /.nav-bg-class -->
        </div><!-- /.navbar-default -->
    </div><!-- /.container-class -->

</div><!-- /.header-nav -->
 