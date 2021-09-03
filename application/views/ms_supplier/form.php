    <div class="col-md-12">
      			<?=form_open("ms_supplier/save",["method"=>"post","class"=>"form-horizontal","id"=>"fm_ms_supplier"],$model)?>
		<?=form_hidden("supplier_id")?>
			<?=create_input("supplier_code")?>
			<?=create_input("supplier_name")?>
			<?=create_input("supplier_address")?>
			<?=create_input("supplier_phone")?>
			<?=create_input("supplier_contact")?>
			<?=create_input("supplier_active")?>
			<?=create_input("jenis_supplier")?>
<?=form_close()?>
      <div class="box-footer">
      		<button class="btn btn-primary" type="button" onclick="$('#fm_ms_supplier').submit()">Save</button>
      		<button class="btn btn-warning" type="button" id="btn-cancel">Cancel</button>
      </div>
    </div>
<script type="text/javascript">
	$("#btn-cancel").click( () => {
		$("#form_ms_supplier").hide();
		$("#form_ms_supplier").html('');
	});

  <?=$this->config->item('footerJS')?>
</script>