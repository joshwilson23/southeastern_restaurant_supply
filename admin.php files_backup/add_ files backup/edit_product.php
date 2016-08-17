<?@session_start();
if(!isset($_SESSION['type'])){
    header('Location: /admin/index.php'); 
    exit(); 
}else{?>
<? require "menu.php"; ?>
<? require "sidebar.php"; ?>
<? require "../config.php"; ?>
<?$m=$_GET['id'];
$result          = mysql_query("SELECT * FROM  products WHERE id = '$m'", $db);
$row             = mysql_fetch_array($result);?>
<?
$result_categories             = mysql_query("SELECT * FROM  categories WHERE sub_category = '0'", $db);
$row_categories             = mysql_fetch_array($result_categories);

$result_manufacturer             = mysql_query("SELECT * FROM  manufacturers", $db);
$row_manufacturer             = mysql_fetch_array($result_manufacturer);

$result_pr          = mysql_query("SELECT * FROM  images WHERE product_id = '$m' order by position asc", $db);
$row_pr            = mysql_fetch_array($result_pr);

$result_various          = mysql_query("SELECT * FROM  various_to_product WHERE product_id = '$m'", $db);
$row_various            = mysql_fetch_array($result_various);
?>
<!--
    Content Wrapper. Contains page content
-->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Products
            <small>
                Add new
            </small>
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="#">
                    <i class="fa fa-dashboard">
                    </i>
                    Home
                </a>
            </li>
            <li class="active">
                Add product
            </li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">

            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        General
                    </h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <form role="form" enctype="multipart/form-data"  action="/admin/system.php?action=edit_product" method="post">
                         <input type="text" style="display:none;" class="form-control" name="id" value="<?=$row['id']?>"/>
                        <!-- text input -->
                        <div class="form-group">
                            <label>
                                Name
                            </label>
                            <input type="text" class="form-control" name="name" placeholder="Type name" value="<?=$row['name']?>"/>
                        </div>
                           <div class="form-group">
                            <label>
                                Origin zipcode
                            </label>
                            <input type="text" class="form-control" name="zipcode" placeholder="Type zipcode"  value="<?=$row['zipcode']?>"/>
                        </div>
                          <div class="form-group">
                      <label>Origin location type</label>
                      <select class="form-control" name="location_type"> 
                                
                                <option <?if($row['location_type']==0){echo "selected";}?> value="0">Residential</option> 
        						<option <?if($row['location_type']==1){echo "selected";}?> value="1">Business With Dock Or Forklift</option> 
								<option <?if($row['location_type']==2){echo "selected";}?> value="2">Business Without Dock Or Forklift</option> 
								<option <?if($row['location_type']==3){echo "selected";}?> value="3">Terminal</option> 
								<option <?if($row['location_type']==4){echo "selected";}?> value="4">Construction Site</option> 
								<option <?if($row['location_type']==5){echo "selected";}?> value="5">Convention Center Or Tradeshow</option>  
                                
                                 
                            </select>
                    </div>
                        <div class="form-group">
                            <label>
                                Carrier
                            </label>
                            <div class="checkbox">
                            <?$Dmethod = explode(",",$row['delivery']);?>
                                
                                <label>
                                    <input type="checkbox" value="1" <?if (in_array(1, $Dmethod)) {echo "checked";}?> name="delivery[]"/>
                                    UPS
                                </label>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" value="0" <?if (in_array(0, $Dmethod)) {echo "checked";}?> name="delivery[]"/>
                                    USPS
                                </label>
                            </div>  
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" value="2" <?if (in_array(2, $Dmethod)) {echo "checked";}?> name="delivery[]"/>
                                    Freight
                                </label>
                            </div>                                                      
                        </div>
                                            <div class="form-group">
                            <label>
                                Free Shipping States(use comma to separate)
                            </label> 
                                <input type="text" class="form-control" name="free_states" value="<?=$row['free_states']?>"/>
                             
                        </div>
                        <div class="form-group">
                      <label>Category</label>
                      <select class="form-control" name="category"> 
                                <?do{?>
                                <option <?if( $row['category_id'] ==  $row_categories['id']){echo "selected='selected'";}?> value="<?=$row_categories['id']?>">
                                    <?=$row_categories['name']?>
                                </option>
                                <?$id = $row_categories['id'];
                                $result_sub_categories = mysql_query("SELECT * FROM  categories WHERE sub_category = '$id'", $db);
                                $row_sub_categories = mysql_fetch_array($result_sub_categories);
                                ?>
                                <?if($row_sub_categories){?>
                                <?do{?>
                                <option <?if( $row['category_id'] ==  $row_sub_categories['id']){echo "selected='selected'";}?> value="<?=$row_sub_categories['id'] ?>">
                                    &nbsp;----
                                    <?= $row_sub_categories['name']?>
                                </option>
                                <?} while ($row_sub_categories = mysql_fetch_array($result_sub_categories));}?>
                                <?} while ($row_categories = mysql_fetch_array($result_categories));?>
                            </select>
                    </div>

                       <div class="form-group">
                      <label>Manufacturer</label>
                      <select class="form-control" name="manufacturer"> 
                                <?do{?>
                                <option <?if( $row['manufacturer_id'] ==  $row_manufacturer['id']){echo "selected='selected'";}?> value="<?=$row_manufacturer['id']?>">
                                    <?=$row_manufacturer['name']?>
                                </option>
                                
                                <?} while ($row_manufacturer = mysql_fetch_array($result_manufacturer));?>
                            </select>
                    </div>
                     <div class="form-group">
                            <label>
                                Quantity
                            </label> 
                                <input type="text" class="form-control" name="quantity" value="<?=$row['quantity']?>"/>
                             
                        </div>
                        <div class="form-group">
                            <label>
                                Price
                            </label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    $
                                </span>
                                <input type="text" class="form-control" name="price" value="<?=$row['price']?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>
                                Old price
                            </label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    $
                                </span>
                                <input type="text" class="form-control" name="old_price" value="<?=$row['old_price']?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>
                                SKU
                            </label>
                            <input type="text" class="form-control" placeholder="ST-180Z" name="sku" value="<?=$row['sku']?>"/>
                        </div>
                        <div class="form-group">
                            <label>
                                MSRP
                            </label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    $
                                </span>
                                <input type="text" class="form-control" name="msrp" value="<?=$row['msrp']?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>
                                Dimensions
                            </label>
                            <div class="row">
                                <div class="col-xs-3">
                                    <input type="text" class="form-control" placeholder="Width" name="width" value="<?=$row['w']?>"/>
                                </div>
                                <div class="col-xs-3">
                                    <input type="text" class="form-control" placeholder="Height" name="height" value="<?=$row['h']?>"/>
                                </div>
                                <div class="col-xs-3">
                                    <input type="text" class="form-control" placeholder="Depth" name="depth" value="<?=$row['d']?>"/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>
                                Weight
                            </label>
                            <input type="text" class="form-control" placeholder="540" name="weight" value="<?=$row['weight']?>"/>
                        </div>
                        <div class="form-group">
                            <label>
                                Various
                            </label>
                            <hr>
                            <div class="row">
                                <div class="col-xs-3">
                                    <label>
                                        Name
                                    </label>
                                    <input type="text" class="form-control" id="various_name" placeholder="Color"/>
                                </div>
                                <!-- <div class="col-xs-1">
                                    <label>
                                        Multiple select
                                    </label><br>
                                     <input type="radio" name="optionsRadios" id="optionsRadios1" value="1" checked> Multiple<br>
                                     <input type="radio" name="optionsRadios" id="optionsRadios1" value="0" > Single select
                                </div> -->
                                <div class="col-xs-3">
                                    <br> 
                                    <input type="button"  class="btn btn-primary" id="add_various" value="Create"> 
                                </div>
                            </div>
                        </div>
                         <div class="form-group" id="show_various">
                           
                        </div>
                        
                      <?if(!empty($row_various['id'])){?>
 <?
 $i =0;
 do{?>

<?
$i++;
$id =$row_various['various_id'];
$result_various2          = mysql_query("SELECT * FROM  various WHERE id = '$id'", $db);
$row_various2            = mysql_fetch_array($result_various2);

$result_various_options          = mysql_query("SELECT * FROM  various_options WHERE various_id = '$id'", $db);
$row_various_options            = mysql_fetch_array($result_various_options);?>

<div class="form-group" id="show_various">
    <div class="row" style="padding-left: 100px;">
        <hr>
        <div class="col-xs-3">
            <label>Various name</label><input type="text" class="form-control" name="various_name[<?=$i?>]" style="display:none;" value="<?=$row_various2['name']?>"><br>
            <div style="cursor:pointer; display:inline;" class="remove_various" data-id="<?=$i?>">[x]</div>
            <?=$row_various2['name']?>
        </div>
        <div class="col-xs-1"><label>Multiple select</label><br><input type="radio" name="select<?=$i?>" id="optionsRadios1" value="1" <?if( $row_various2['type']==1){echo 'checked=""';}?>> Multiple<br><input type="radio" name="select<?=$i?>" id="optionsRadios1" value="0" <?if( $row_various2['type']==0){echo 'checked=""';}?>> Single select</div>
        <div class="col-xs-3"><br><input type="button" class="btn btn-primary add_various" data-id="<?=$i?>" value="Add option"></div>
    </div>
    <div class="form-group" id="<?=$i?>">
        <?
        $o=0;
        do{

           $o++; ?>


          <div class="row" style="padding-left: 120px;">
    <hr>
    <div class="col-xs-3">
        <label>Option name</label>
        <div style="cursor:pointer; display:inline;" class="remove_option" data-id="<?=$o?>">[x]</div>
        <input type="text" class="form-control" name="option_name<?=$i?>[]" placeholder="Grey color" value="<?=$row_various_options['name']?>">
    </div>
    <div class="col-xs-3"><label>Picture</label><br><input type="file" name="option_picture_<?=$i?>[<?=$o?>]" id="exampleInputFile"></div>
    <div class="col-xs-3 text-center">
        <label>Price</label><br> <input type="radio" class="price_checkbox" name="option_price_<?=$i?>[<?=$o?>]" id="optionsRadios1" value="0" <?if( $row_various_options['action']==0){echo 'checked=""';}?>> Same | <input type="radio" class="price_checkbox" name="option_price_<?=$i?>[<?=$o?>]" id="optionsRadios1" value="1"  <?if( $row_various_options['action']==1){echo 'checked=""';}?>> Plus+ | <input type="radio" class="price_checkbox" name="option_price_<?=$i?>[<?=$o?>]" value="2"  <?if( $row_various_options['action']==2){echo 'checked=""';}?>> Minus-<input type="text" class="form-control" name="price_<?=$i?>[<?=$o?>]" placeholder="Price" <?if( $row_various_options['action']==0){echo 'readonly="readonly"';}?> value="<?=$row_various_options['price']?>">
        <div class="row">
            <div class="col-xs-3"><label>Width</label><input type="text" class="form-control" name="w_<?=$i?>[<?=$o?>]" placeholder="Price" value="<?=$row_various_options['w']?>" /></div>
            <div class="col-xs-3"><label>Height</label><input type="text" class="form-control" name="h_<?=$i?>[<?=$o?>]" placeholder="Price" value="<?=$row_various_options['h']?>" /></div>
            <div class="col-xs-3"><label>Depth</label><input type="text" class="form-control" name="d_<?=$i?>[<?=$o?>]" placeholder="Price" value="<?=$row_various_options['d']?>" /></div>
            <div class="col-xs-3"><label>Weight</label><input type="text" class="form-control" name="weight_<?=$i?>[<?=$o?>]" placeholder="Price" value="<?=$row_various_options['weight']?>" /></div>
            <label>Old price</label><input type="text" class="form-control" name="old_price_<?=$i?>[<?=$o?>]" placeholder="Price" value="<?=$row_various_options['old_price']?>"  />
        </div>
    </div>
</div>






       
        <?} while ($row_various_options = mysql_fetch_array($result_various_options));?>  
    </div>
</div>
<?} while ($row_various = mysql_fetch_array($result_various));?> 
<?}else{$i=0; $o = 0;}?>
                        <div class="form-group">
                            <label>
                                Description
                            </label>
                            <textarea class="form-control" id="editor1" name="description" rows="7" placeholder="About ..."><?=$row['description']?></textarea>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputFile">
                               Attachments
                            </label>
                            <input type="file" name="attachment" id="exampleInputFile"/>
                            <p class="help-block">
                                You can attach any file here
                            </p>
                             <input type="text" class="form-control" name="file_title" placeholder="Attachments title" value="<?=$row['file_title']?>"/>

                        </div> 
                        <div class="form-group">
                            <label for="exampleInputFile">
                                Feautured Image
                            </label>
                            <img class="img-responsive pad" src="/uploads/<?=$row['image']?>" alt="Photo" width="100" height="100">
                            <input type="file" name="image" id="exampleInputFile"/>
                            <p class="help-block">
                                This is preview image
                            </p>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputFile">
                                Gallery
                            </label>
                            <input type="file" name="uploadfile[]" multiple="true" />
                            <p class="help-block">
                                You can attach multiple images
                            </p>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">
                                Edit
                            </button>
                        </div>
                    </form>
                </div>
                <!-- /.box-body -->
                 <?if($row_pr){?>
                <div class="box-body">
                  <table  class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>Image</th>
                        <th>Position</th>  
                        <th>Delete</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?do{?>
                      <tr>
                        <td><img src="/uploads/<?=$row_pr['name'] ?>" width="60" height="60 "></td>
                        <td><input type="text" class="position" data-id='<?=$row_pr['id'] ?>' value="<?=$row_pr['position'] ?>"></td>  
                         
                        <td><a class="del" style="cursor:pointer;" data-id='<?=$row_pr['id'] ?>'>Delete<a/></td>
                      </tr>
                     <?} while ($row_pr = mysql_fetch_array($result_pr));?> 
                    </tbody>
                    
                  </table>
                </div><!-- /.box-body -->
                 <?}?>
                                 <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<script>


$(function() {
  $('.position').keyup(function() {
   var mess = $(this).val();
 var id=$(this).attr('data-id');
 
            $.ajax({
                type: "POST",
                url: "/admin/system.php?action=change_position",
                data:{"mess":mess, "id":id},
                // Выводим то что вернул PHP
                success: function(html)
                {   
                    
                }
        });
  });
  
   $('.desc').keyup(function() {
   var mess = $(this).val();
 var id=$(this).attr('data-id-desc');
 
            $.ajax({
                type: "POST",
                url: "/admin/system.php?action=change_desc",
                data:{"mess":mess, "id":id},
                // Выводим то что вернул PHP
                success: function(html)
                {   
                    
                }
        });
  });
  
     $('.del').click(function() { 
 var id=$(this).attr('data-id');
 $(this).parent().parent().fadeOut();
            $.ajax({
                type: "POST",
                url: "/admin/system.php?action=delete_product",
                data:{"id":id},
                // Выводим то что вернул PHP
                success: function(html)
                {   
                    
                }
        });
  });
  
   
  
  
});
  

 
</script>  
                <!-- /.box-body -->
            </div>
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
<!--
    /.content-wrapper
-->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script>
            $(document).ready(function() {

                var i = <?=$i?>;
                 $('#add_various').click(function() { 
                     i++;
                     var name = $('#various_name').val();
                     $('#various_name').val("");
                     var html = '<div class="row" style="padding-left: 100px;"><hr><div class="col-xs-3"><label>Various name</label><input type="text" class="form-control" name="various_name['+i+']" style="display:none;" value="'+name+'"/><br><div style="cursor:pointer; display:inline;" class="remove_various" data-id="'+i+'">[x]</div> '+name+'</div><div class="col-xs-1"><label>Multiple select</label><br><input type="radio" name="select'+i+'" id="optionsRadios1" value="1" checked> Multiple<br><input type="radio" name="select'+i+'" id="optionsRadios1" value="0" > Single select</div><div class="col-xs-3"><br><input type="button"  class="btn btn-primary add_various" data-id="'+i+'" value="Add option"></div></div> <div   class="form-group" id="'+i+'"></div>';
                               $("#show_various").prepend(html);
                    });
                 var o = <?=$o?> ;
                 $('body').on('click', '.add_various', function(){ 
                    o++;
                     var html = '<div class="row" style="padding-left: 120px;"><hr><div class="col-xs-3"><label>Option name</label><div style="cursor:pointer; display:inline;" class="remove_option" data-id="'+o+'">[x]</div> <input type="text" class="form-control" name="option_name'+i+'[]" placeholder="Grey color"/></div><div class="col-xs-3"><label>Picture</label><br><input type="file" name="option_picture_'+i+'['+o+']" id="exampleInputFile"/></div><div class="col-xs-3 text-center"><label>Price</label><br><input type="radio" class="price_checkbox" name="option_price_'+i+'['+o+']" id="optionsRadios1" value="0" checked> Same | <input type="radio"  class="price_checkbox" name="option_price_'+i+'['+o+']" id="optionsRadios1" value="1"> Plus+ | <input type="radio" class="price_checkbox" name="option_price_'+i+'['+o+']" value="2"> Minus- <input type="text" class="form-control" name="price_'+i+'['+o+']" placeholder="Price" value="0" readonly="readonly"/><div class="row"><div class="col-xs-3"><label>Width</label><input type="text" class="form-control" name="w_'+i+'['+o+']" placeholder="Price" value="0" /></div><div class="col-xs-3"><label>Height</label><input type="text" class="form-control" name="h_'+i+'['+o+']" placeholder="Price" value="0" /></div><div class="col-xs-3"><label>Depth</label><input type="text" class="form-control" name="d_'+i+'['+o+']" placeholder="Price" value="0" /></div><div class="col-xs-3"><label>Weight</label><input type="text" class="form-control" name="weight_'+i+'['+o+']" placeholder="Price" value="0" /></div><label>Old price</label><input type="text" class="form-control" name="old_price_'+i+'['+o+']" placeholder="Price" value="0"  /></div></div> </div>';
                    var id = $(this).attr("data-id");
                               $("#"+id+"").prepend(html);
                    });

                  $('body').on('change', '.price_checkbox', function(){ 
                     var value = $(this).val();
                    if(value==0){ 
                        $(this).parent().find("input[name^=price_]").val("");
                        $(this).parent().find("input[name^=price_]").attr("readonly", "readonly");
                    }else{
                        $(this).parent().find("input[name^=price_]").removeAttr("readonly");
                    }
                                
                    });

                   $('body').on('click', '.remove_option', function(){ 
                     
                    var value = $(this).attr("data-id");
                     $(this).parent().parent().remove();
                                
                    });
                   $('body').on('click', '.remove_various', function(){ 
                     
                   var id = $(this).attr("data-id");
                      $(this).parent().parent().remove(); 

                       $("#"+id+"").remove();         
                    });
              

            });
            </script>
<? require "footer.php"; ?>
 <script>
     $(function () {
        //Replace the <textarea id="editor1"> with a CKEditor
        // instance, using default configuration.
        CKEDITOR.replace('editor1');
        //bootstrap WYSIHTML5 - text editor
       $(".textarea").wysihtml5();
      });
    </script>
    <?}?>