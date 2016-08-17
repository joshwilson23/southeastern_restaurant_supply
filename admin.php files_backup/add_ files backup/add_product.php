<?@session_start();
if(!isset($_SESSION['type'])){
    header('Location: /admin/index.php'); 
    exit(); 
}else{?>
<? require "menu.php"; ?>
<? require "sidebar.php"; ?>
<? require "../config.php"; ?>
<?
$result_categories             = mysql_query("SELECT * FROM  categories WHERE sub_category = '0'", $db);
$row_categories             = mysql_fetch_array($result_categories);

$result_manufacturer             = mysql_query("SELECT * FROM  manufacturers", $db);
$row_manufacturer             = mysql_fetch_array($result_manufacturer);
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
                    <form role="form" enctype="multipart/form-data"  action="/admin/system.php?action=product" method="post">
                        <!-- text input -->
                        <div class="form-group">
                            <label>
                                Name
                            </label>
                            <input type="text" class="form-control" name="name" placeholder="Type name"/>
                        </div>
                         <div class="form-group">
                            <label>
                                Origin zipcode
                            </label>
                            <input type="text" class="form-control" name="zipcode" placeholder="Type zipcode"/>
                        </div>
                          <div class="form-group">
                      <label>Origin location type</label>
                      <select class="form-control" name="location_type"> 
                                
                               <option value="0">Residential</option> 
    							<option value="1">Business With Dock Or Forklift</option> 
								<option value="2">Business Without Dock Or Forklift</option> 
								<option value="3">Terminal</option> 
								<option value="4">Construction Site</option> 
								<option value="5">Convention Center Or Tradeshow</option>  
                                
                                 
                            </select>
                    </div>
                        <div class="form-group">
                            <label>
                                Carrier
                            </label>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" value="1" name="delivery[]"/>
                                    UPS
                                </label>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" value="0" name="delivery[]"/>
                                    USPS
                                </label>
                            </div>  
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" value="2" name="delivery[]"/>
                                    Freight
                                </label>
                            </div>                                                        
                        </div>
                    <div class="form-group">
                            <label>
                                Free Shipping States(use comma to separate)
                            </label> 
                                <input type="text" class="form-control" name="free_states"/>
                             
                        </div>
                        <div class="form-group">
                      <label>Category</label>
                      <select class="form-control" name="category"> 
                                <?do{?>
                                <option value="<?=$row_categories['id']?>">
                                    <?=$row_categories['name']?>
                                </option>
                                <?$id = $row_categories['id'];
                                $result_sub_categories = mysql_query("SELECT * FROM  categories WHERE sub_category = '$id'", $db);
                                $row_sub_categories = mysql_fetch_array($result_sub_categories);
                                ?>
                                <?if($row_sub_categories){?>
                                <?do{?>
                                <option value="<?=$row_sub_categories['id'] ?>">
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
                                <option value="<?=$row_manufacturer['id']?>">
                                    <?=$row_manufacturer['name']?>
                                </option>
                                
                                <?} while ($row_manufacturer = mysql_fetch_array($result_manufacturer));?>
                            </select>
                    </div>
                     <div class="form-group">
                            <label>
                                Quantity
                            </label> 
                                <input type="text" class="form-control" name="quantity"/>
                             
                        </div>
                        <div class="form-group">
                            <label>
                                Price
                            </label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    $
                                </span>
                                <input type="text" class="form-control" name="price"/>
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
                                <input type="text" class="form-control" name="old_price"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>
                                SKU
                            </label>
                            <input type="text" class="form-control" placeholder="ST-180Z" name="sku"/>
                        </div>
                        <div class="form-group">
                            <label>
                                MSRP
                            </label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    $
                                </span>
                                <input type="text" class="form-control" name="msrp"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>
                                Dimensions
                            </label>
                            <div class="row">
                                <div class="col-xs-3">
                                    <input type="text" class="form-control" placeholder="Width" name="width"/>
                                </div>
                                <div class="col-xs-3">
                                    <input type="text" class="form-control" placeholder="Height" name="height"/>
                                </div>
                                <div class="col-xs-3">
                                    <input type="text" class="form-control" placeholder="Depth" name="depth"/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>
                                Weight
                            </label>
                            <input type="text" class="form-control" placeholder="540" name="weight"/>
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

                        <div class="form-group">
                            <label>
                                Description
                            </label>
                            <textarea class="form-control" id="editor1" name="description" rows="7" placeholder="About ..."></textarea>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputFile">
                               Attachments
                            </label>
                            <input type="file" name="attachment" id="exampleInputFile"/>
                            <p class="help-block">
                                You can attach any file here
                            </p>
                             <input type="text" class="form-control" name="file_title" placeholder="Attachments title"/>

                        </div> 
                        <div class="form-group">
                            <label for="exampleInputFile">
                                Feautured Image
                            </label>
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
                                Add
                            </button>
                        </div>
                    </form>
                </div>
                <!-- /.box-body -->
                
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

                var i = 0;
                 $('#add_various').click(function() { 
                     i++;
                     var name = $('#various_name').val();
                     if($.trim(name)==""){
                        $('#various_name').css("border-color","red");
                     }else{
                        $('#various_name').css("border-color","");
                        $('#various_name').val("");
                         var html = '<div class="row" style="padding-left: 100px;"><hr><div class="col-xs-3"><label>Various name</label><input type="text" class="form-control" name="various_name['+i+']" style="display:none;" value="'+name+'"/><br><div style="cursor:pointer; display:inline;" class="remove_various" data-id="'+i+'">[x]</div> '+name+'</div><div class="col-xs-1"><label>Multiple select</label><br><input type="radio" name="select'+i+'" id="optionsRadios1" value="1" checked> Multiple<br><input type="radio" name="select'+i+'" id="optionsRadios1" value="0" > Single select</div><div class="col-xs-3"><br><input type="button"  class="btn btn-primary add_various" data-id="'+i+'" value="Add option"></div></div> <div   class="form-group" id="'+i+'"></div>';
                                   $("#show_various").prepend(html);
                     }

                    });
                 var o = 0 ;
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