    <div class="col-md-12">
      		<?=form_open("ms_user/save",["method"=>"post","class"=>"form-horizontal","id"=>"form"])?>
			<?=form_hidden("user_id")?>
			<?=create_input("person_name")?>
			<?=create_input("user_name")?>
			<?=create_input("user_password")?>
			<?=create_select(["attr"=>["name"=>"user_group=Group User","id"=>"user_group","class"=>"form-control"],
								"model"=>["m_ms_group"=>"get_group","column"=>["group_id","group_name"]]
							])?>
			<?=create_select([
								"attr" 		=> ["name"=>"user_status","id"=>"user_status","class"=>"form-control"],
								"option"	=>[
												["id"=>"t","text"=>"Aktif"],["id"=>"f","text"=>"Non Aktif"]
											  ]
							])?>
			<?=form_close()?>
      <div class="box-footer">
      		<button class="btn btn-primary" onclick="$('form').submit()">Save</button>
      		<button class="btn btn-warning" id="btn-cancel">Cancel</button>
      </div>
    </div>
<script type="text/javascript">
	$("#btn-cancel").click( () => {
		$("#form_ms_user").hide();
		$("#form_ms_user").html('');
	});
</script>