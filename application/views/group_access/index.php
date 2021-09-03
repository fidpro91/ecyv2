<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?=ucwords('Group Access')?>
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
        <?=$this->session->flashdata('message')?>
        <div class="box-header with-border">
          <h3 class="box-title">Form Group Access</h3>
          <div class="box-tools pull-right">
            <button type="button" id="btn-add" class="btn btn-primary">
              <i class="fa fa-plus"></i> Add</button>
          </div>
        </div>
        <div class="box-body" id="form_group_access" style="display: none;">
        </div>
        <div class="box-body" id="data_group_access">
          <?=create_table("tb_group_access","M_group_access",["class"=>"table table-bordered" ,"style" => "width:100% !important;"])?>
        </div>
        <!-- /.box-footer-->
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<script type="text/javascript">
    var table;
    $(document).ready(function() {
        table = $('#tb_group_access').DataTable({ 
            "processing": true, 
            "serverSide": true, 
            "order": [], 
            "scrollX": true,
            "ajax": {
                "url": "<?php echo site_url('group_access/get_data')?>",
                "type": "POST"
            },
            "columnDefs": [
              { 
                  "targets": [ 0,-1 ], 
                  "orderable": false, 
              },
            ],
 
        });
    });
    $("#btn-add").click(function() {
      $("#form_group_access").show();
      $("#form_group_access").load("group_access/show_form");
    });
    function set_val(id) {
      $("#form_group_access").show();
      $.get('group_access/find_one/'+id,(data)=>{
          $("#form_group_access").load("group_access/show_form",()=>{
            $.each(data,(ind,obj)=>{
                $("#"+ind).val(obj);
            });
          });
      },'json');
    }

    function deleteRow(id) {
      if (confirm("Anda yakin akan menghapus data ini?")) {
          $.get('group_access/delete_row/'+id,(data)=>{
            alert(data.message);
            location.reload();
        },'json');
      }
    }
</script>