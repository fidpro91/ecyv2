<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?=ucwords('Ms Group')?>
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
          <h3 class="box-title">Form Ms Group</h3>
          <div class="box-tools pull-right">
            <button type="button" id="btn-add" class="btn btn-primary">
              <i class="fa fa-plus"></i> Add</button>
          </div>
        </div>
        <div class="box-body" id="form_ms_group" style="display: none;">
        </div>
        <div class="box-body" id="data_ms_group">
          <?=create_table("tb_ms_group","M_ms_group",["class"=>"table table-bordered" ,"style" => "width:100% !important;"])?>
        </div>
        <div class="box-footer">
          <button class="btn btn-danger" id="btn-deleteChecked"><i class="fa fa-trash"></i> Delete</button>
        </div>
        <!-- /.box-footer-->
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?=modal_open("md_group_access","Group Access")?>
<?=modal_close()?>
<script type="text/javascript">
    var table;
    $(document).ready(function() {
        table = $('#tb_ms_group').DataTable({ 
            "processing": true, 
            "serverSide": true, 
            "order": [], 
            "scrollX": true,
            "ajax": {
                "url": "<?php echo site_url('ms_group/get_data')?>",
                "type": "POST"
            },
            'columnDefs': [
            {
              'targets': [0,1,-1],
               'searchable': false,
               'orderable': false,
             },
            {
               'targets': 0,
               'className': 'dt-body-center',
               'render': function (data, type, full, meta){
                   return '<input type="checkbox" name="id[]" value="' + $('<div/>').text(data).html() + '">';
               }
            }], 
        });
    });
    $("#btn-add").click(function() {
      $("#form_ms_group").show();
      $("#form_ms_group").load("ms_group/show_form");
    });
    function set_val(id) {
      $("#form_ms_group").show();
      $.get('ms_group/find_one/'+id,(data)=>{
          $("#form_ms_group").load("ms_group/show_form",()=>{
            $.each(data,(ind,obj)=>{
                $("#"+ind).val(obj);
            });
          });
      },'json');
    }

    function deleteRow(id) {
      if (confirm("Anda yakin akan menghapus data ini?")) {
          $.get('ms_group/delete_row/'+id,(data)=>{
            alert(data.message);
            location.reload();
        },'json');
      }
    }

    function show_access(id) {
      $("#md_group_access").modal('show');
      $("#md_group_access").find(".modal-body").load("ms_group/show_tree_access/"+id);
    }

    $("#checkAll").click(()=>{
      if ($("#checkAll").is(':checked')) {
          $("#tb_ms_group input[type='checkbox']").attr("checked",true);
      }else{
          $("#tb_ms_group input[type='checkbox']").attr("checked",false);
      }
    });

    $("#btn-deleteChecked").click(function(event){
        event.preventDefault();
        var searchIDs = $("#tb_ms_cuti input:checkbox:checked").map(function(){
              return $(this).val();
          }).toArray();
        if (searchIDs.length == 0) {
          alert("Mohon cek list data yang akan dihapus");
          return false;
        }
        if (confirm("Anda yakin akan menghapus data ini?")) {
          $.post('ms_cuti/delete_multi',{data:searchIDs},(resp)=>{
            alert(resp.message);
            location.reload();
          },'json');
        }
    });
</script>