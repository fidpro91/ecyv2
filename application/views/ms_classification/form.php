    <div class="col-md-12">
      			<?=form_open("ms_classification/save",["method"=>"post","class"=>"form-horizontal","id"=>"fm_ms_classification"],$model)?>
		<?=form_hidden("classification_id")?>
			<?=create_input("classification_code")?>
			<?=create_input("classification_name")?>
			<?=create_input("classification_active")?>
			<?=create_input("modul_id")?>
			<?=create_input("classification_level")?>
			<?=create_input("classification_parent")?>
			<?=create_input("classification_islast")?>
			<?=create_input("profit_margin")?>
<?=form_close()?>
      <div class="box-footer">
      		<button class="btn btn-primary" type="button" onclick="$('#fm_ms_classification').submit()">Save</button>
      		<button class="btn btn-warning" type="button" id="btn-cancel">Cancel</button>
      </div>
    </div>
<script type="text/javascript">
	$("#btn-cancel").click( () => {
		$("#form_ms_classification").hide();
		$("#form_ms_classification").html('');
	});

  <?=$this->config->item('footerJS')?>
</script>