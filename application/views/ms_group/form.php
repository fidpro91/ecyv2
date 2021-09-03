    
      			<?=form_open("ms_group/save",["method"=>"post","id"=>"form"],$model)?>
      	 <div class="row">
      	 <div class="col-md-9">
		<?=form_hidden("group_id")?>
			<?=create_input("group_code")?>
			<?=create_input("group_name")?>
			<?=create_select(["attr"=>["name"=>"group_active=Status","id"=>"group_active","class"=>"form-control"],
								"option"=>[["id"=>"t","text"=>"Aktif"],["id"=>"f","text"=>"Tidak Aktif"]]
							])?>
		</div>
		</div>
<?=form_close()?>
      <div class="box-footer">
      		<button class="btn btn-primary" onclick="$('form').submit()">Save</button>
      		<button class="btn btn-warning" id="btn-cancel">Cancel</button>
      </div>
    </div>
<script type="text/javascript">
	$("#btn-cancel").click( () => {
		$("#form_ms_group").hide();
		$("#form_ms_group").html('');
	});
	<?= $this->config->item('footerJS') ?>
</script>