
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 3.0
    </div>
    <strong>Copyright &copy; 2021 <a href="www.hosterweb.co.id">Hosterweb</a>.</strong> All rights
    reserved.
  </footer>
</div>
<!-- ./wrapper -->
</body>
</html>
<script src="<?=base_url()?>assets/dist/js/loading.js"></script>
<script type="text/javascript">
$('.breadcrumb').breadcrumbsGenerator({
  sitemaps  : '.sidebar-menu',
  index_type: 'index.html'
});

$("#checkAll").click(()=>{
  if ($("#checkAll").is(':checked')) {
      $("#tb_ms_jabatan input[type='checkbox']").attr("checked",true);
  }else{
      $("#tb_ms_jabatan input[type='checkbox']").attr("checked",false);
  }
});
</script>