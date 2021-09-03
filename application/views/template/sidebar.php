<script type="text/javascript">
  $(function(){
          var current_page_URL = location.href;
          $(".sidebar").find( "a" ).each(function() {
              if ($(this).attr("href") !== "#") {
                  var target_URL = $(this).prop("href");
                      if (target_URL == current_page_URL) {
                          $('nav a').parents('li, ul').removeClass('active');
                          $(this).parent('li').addClass('active');
                          var x = $(this).parents('li').find('a').attr("href");
                          if (x === '#') {
                            $(this).parents('li').not(':first').addClass('active menu-open');
                          }
                          return false;
                      }
              }
          }); 
      });
</script>
  <!-- Left side column. contains the sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?=base_url()?>assets/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?=$this->session->person_name?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MAIN NAVIGATION</li>
            <?=$menu?>
          </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- =============================================== -->
