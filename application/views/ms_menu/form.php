    <div class="col-md-12">
      			<?=form_open("ms_menu/save",["method"=>"post","id"=>"fm_ms_menu"])?>
		<?=form_hidden("menu_id")?>
			<?=create_input("menu_code=Kode")?>
			<?=create_input("menu_name=Nama Menu")?>
			<?=create_input("menu_url")?>
			<?=create_input("menu_parent_id")?>
			<?=create_select([
								"attr" 		=> ["name"=>"menu_status","id"=>"menu_status","class"=>"form-control"],
								"option"	=>[
												["id"=>"t","text"=>"Aktif"],["id"=>"f","text"=>"Non Aktif"]
											  ]
							])?>
			<?=create_input("menu_icon")?>
			<?=create_input("slug")?>
<?=form_close()?>
      <div class="box-footer">
      		<button class="btn btn-primary" onclick="$('#fm_ms_menu').submit()">Save</button>
      		<button class="btn btn-warning" id="btn-cancel">Cancel</button>
      </div>
    </div>
<script type="text/javascript">
	$("#btn-cancel").click( () => {
		$("#form_ms_menu").hide();
		$("#form_ms_menu").html('');
	});

  <?=$this->config->item('footerJS')?>
</script>