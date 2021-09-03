    <div class="col-md-12">
      			<?=form_open("ms_item/save",["method"=>"post","class"=>"form-horizontal","id"=>"fm_ms_item"],$model)?>
		<?=form_hidden("item_id")?>
			<?=create_input("item_code")?>
			<?=create_input("item_name")?>
			<?=create_input("item_desc")?>
			<?=create_input("item_active")?>
			<?=create_input("comodity_id")?>
			<?=create_input("classification_id")?>
			<?=create_input("item_unitofitem")?>
			<?=create_input("item_package")?>
			<?=create_input("is_formularium")?>
			<?=create_input("is_generic")?>
			<?=create_input("jns")?>
			<?=create_input("item_name_generic")?>
			<?=create_input("qty_packtounit")?>
			<?=create_input("hna")?>
			<?=create_input("atc_ood")?>
<?=form_close()?>
      <div class="box-footer">
      		<button class="btn btn-primary" type="button" onclick="$('#fm_ms_item').submit()">Save</button>
      		<button class="btn btn-warning" type="button" id="btn-cancel">Cancel</button>
      </div>
    </div>
<script type="text/javascript">
	$("#btn-cancel").click( () => {
		$("#form_ms_item").hide();
		$("#form_ms_item").html('');
	});

  <?=$this->config->item('footerJS')?>
</script>