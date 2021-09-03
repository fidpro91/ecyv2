<!-- Content Wrapper. Contains page content -->
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/themes/default/style.min.css" /> -->
<!-- <link href="<?=base_url()?>assets/plugins/jstree_ver1/themes/classic/style.css" rel="stylesheet" /> -->
<link href="<?php echo base_url(); ?>assets/plugins/jstree_ver1/themes/classic/style.css" rel="stylesheet" />
<script src="<?=base_url()?>assets/plugins/jstree_ver1/jquery.jstree.js" type="text/javascript"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/jstree.min.js"></script> -->

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        FORM GENERATOR
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Layout</a></li>
        <li class="active">Fixed</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Form Generator MVC</h3>
        </div>
        <div class="box-body">
            <form method="post" action="<?=base_url()?>builder/create_mvc">
                <div class="row">
                  <div class="col-md-4">
                    <div class="box box-success box-solid">
                      <div class="box-header with-border">
                        <h3 class="box-title">List Table</h3>

                        <div class="box-tools pull-right">
                          <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                        <!-- /.box-tools -->
                      </div>
                      <!-- /.box-header -->
                      <div class="box-body">
                        <div class="form-group">
                            <label>Nama Table</label>
                            <select name="list_table" id="list_table" class="form-control">
                                <?php
                                    foreach ($data as $key => $value) {
                                      echo "<option>$value</option>";
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                          <div class="checkbox">
                            <label>
                              <input type="checkbox" name="c_controller" value="t">
                              Controler
                            </label>
                          </div>

                          <div class="checkbox">
                            <label>
                              <input type="checkbox" name="c_model" value="t">
                              Model
                            </label>
                          </div>

                          <div class="checkbox">
                            <label>
                              <input type="checkbox" name="c_view" value="t">
                              View
                            </label>
                          </div>
                        </div>
                      </div>
                      <!-- /.box-body -->
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="box box-success box-solid">
                      <div class="box-header with-border">
                        <h3 class="box-title">Map Tree Menu</h3>

                        <div class="box-tools pull-right">
                          <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                        <!-- /.box-tools -->
                      </div>
                      <!-- /.box-header -->
                      <div class="box-body">
                        <div class="form-group">
                           <div id="jstree_demo_div">
                           </div>
                            <script type="text/javascript">
                              $("#jstree_demo_div").jstree({
                                "plugins" : [
                                  "themes","json_data", "ui"
                                ],
                                "json_data" : {
                                  "ajax" : {
                                    "url" : "<?=base_url()?>builder/get_menu2",
                                    "data" : function (n) {
                                      return { id : n.attr ? n.attr("menu_id") : 0 };
                                    }
                                  }
                                },
                                "themes" : {
                                  "theme" : "classic", //apple,default,if in ie6 recommented you use classic
                                  "dots" : true,
                                  "icons" : false
                                }
                              })
                              .bind("select_node.jstree",function(event,data){
                                var id   = data.rslt.obj.attr("menu_id");
                                var name = data.rslt.obj.attr("menu_name");
                                
                                $("#menu_parent_id").val(id);
                                
                              })
                              // prevent the default event of the link
                              .delegate("a", "click", function (event, data) { event.preventDefault(); });
                              
                            </script>
                        </div>
                      </div>
                      <!-- /.box-body -->
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="box box-success box-solid">
                      <div class="box-header with-border">
                        <h3 class="box-title">Buat Menu</h3>

                        <div class="box-tools pull-right">
                          <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                        <!-- /.box-tools -->
                      </div>
                      <!-- /.box-header -->
                      <div class="box-body">
                        <div class="form-group">
                            <label>Kode Menu</label>
                            <input type="text" name="menu_code" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Nama Menu</label>
                            <input type="text" name="menu_name" class="form-control">
                            <input type="hidden" name="menu_parent_id" id="menu_parent_id" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Icon Menu</label>
                            <input type="text" name="menu_icon" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>URL</label>
                            <div class="input-group">
                              <span class="input-group-addon">base_url()/</span>
                              <input type="text" class="form-control" name="menu_url">
                            </div>
                        </div>
                      </div>
                      <!-- /.box-body -->
                    </div>
                  </div>
                </div>
            <!-- </form> -->
        </div>
        <div class="box-footer"><button class="btn btn-primary" onclick="$('form').submit()">Build</button></div>
        <!-- /.box-footer-->
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>