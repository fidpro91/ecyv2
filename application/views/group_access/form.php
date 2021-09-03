    <div class="col-md-12">
      			<?=form_open("group_access/save",["method"=>"post","class"=>"form-horizontal"])?>
			<?=create_input("group_id")?>
			<?=create_input("menu_id")?>
			<?=create_input("access_view")?>
			<?=create_input("access_write")?>
		<?=form_hidden("id")?>
<?=form_close()?>
      <div class="box-footer">
      		<button class="btn btn-primary" onclick="$('form').submit()">Save</button>
      		<button class="btn btn-warning" id="btn-cancel">Cancel</button>
      </div>
    </div>
<script type="text/javascript">
	$("#btn-cancel").click( () => {
		$("#form_group_access").hide();
		$("#form_group_access").html('');
	});
</script>