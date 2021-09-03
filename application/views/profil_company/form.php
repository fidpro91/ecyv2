    <div class="col-md-12">
      			<?=form_open("profil_company/save",["method"=>"post","class"=>"form-horizontal","id"=>"fm_profil_company"],$model)?>
		<?=form_hidden("profil_id")?>
			<?=create_input("nama_profil")?>
			<?=create_input("email_profil")?>
			<?=create_input("fax_profil")?>
			<?=create_input("phone_profil")?>
			<?=create_input("alamat_profil")?>
			<?=create_input("logo_profil")?>
<?=form_close()?>
      <div class="box-footer">
      		<button class="btn btn-primary" type="button" onclick="$('#fm_profil_company').submit()">Save</button>
      		<button class="btn btn-warning" type="button" id="btn-cancel">Cancel</button>
      </div>
    </div>
<script type="text/javascript">
	$("#btn-cancel").click( () => {
		$("#form_profil_company").hide();
		$("#form_profil_company").html('');
	});

  <?=$this->config->item('footerJS')?>
</script>