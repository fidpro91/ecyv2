<div class="col-md-12">
  	<?=form_open("group_access/save",["method"=>"post","id"=>"form-menu"])?>
  	<?=form_hidden("group_id",$group_id)?>
		<div id="tree-menu"></div>
	<?=form_close()?>
  <div class="box-footer">
  		<button class="btn btn-primary" onclick="$('#form-menu').submit()">Save</button>
  		<button class="btn btn-warning" data-dismiss="modal" id="btn-cancel">Cancel</button>
  </div>
</div>
<script type="text/javascript">
	$("#btn-cancel").click( () => {
		$("#form_group_access").hide();
		$("#form_group_access").html('');
	});
	$("#form-menu").on("submit",function(){
		var checked_ids = []; 
    $("#tree-menu").jstree("get_checked",null,true).each 
    (function () { 
        checked_ids.push(this.id); 
    });
		$data = $(this).serialize()+"&menu_id="+checked_ids;
		$.ajax({
            'async': false,
            'type': "POST",
            'data':$data,
            'dataType': 'json',
            'url': "ms_group/set_access",
            'success': function (data) {
                alert(data.message);
                location.reload();
            }
        });

        return false;

	});
	$(document).ready(function() {
		$("#tree-menu").jstree({
            "plugins" : [
              "wholerow","themes","json_data", "ui", "checkbox",
            ],
            "json_data" : {
              "ajax" : {
                "url" : "<?=base_url()?>ms_group/get_menu_access",
                "data" : function (n) {
                  return { id : n.attr ? n.attr("menu_id") : 0,group_id : $("#group_id").val() };
                }
              }
            },
            "checkbox" : {
				// real_checkboxes: true,
	            two_state: true,
	            // checked_parent_open: true,
			},
            "themes" : {
              "theme" : "classic", //apple,default,if in ie6 recommented you use classic
              "dots" : true,
              "icons" : false
            }
          }).bind("loaded.jstree",function(event,data){
            $(this).jstree("open_all");
          }).bind("select_node.jstree",function(event,data){
            var id   = data.rslt.obj.attr("menu_id");
            var name = data.rslt.obj.attr("menu_name");
            $("#menu_parent_id").val(id);
          }).delegate("a", "click", function (event, data) { event.preventDefault(); });

	})
</script>