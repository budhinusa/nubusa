<!DOCTYPE html>
<html>
  <?php
  include 'header.php';
  ?>
  <body class="skin-blue sidebar-mini">
    <div class="wrapper">
      
      <?php include 'top-side.php';?>
      <!-- Left side column. contains the logo and sidebar -->
      <?php include 'left-side.php';?>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <?php include 'notice.php';?>
        <section class="content-header">
          <?php print_r($template['heads'])?>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="box box-info">
              <div class="box-header with-border" style="background-color: #00c0ef; padding: 0;">
                  <!--<h3 class="box-title">Data Table With Full Features</h3>-->
                  <?php
                  if($menutable){?>
                  <div class="widget-control pull-right">
                    <a href="#" data-toggle="dropdown" class="btn" style="color: black"><span class="glyphicon glyphicon-cog"></span> Menu</a>
                    <ul class="dropdown-menu">
                      <?php print $menutable?>
                    </ul>
                  </div>
                  <?php }
                  if(!$tableboxy){
                    $tableboxy = "tableboxy";
                  }
                  ?>
              </div><!-- /.box-header -->
              <div class="box-body table-responsive">
                  <table id="tableboxy" class="table table-bordered table-striped">
                      <?php print $template['body']?>
                  </table>
              </div>
          </div>
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
      <footer class="main-footer">
        <div class="pull-right hidden-xs">
          <b>Version</b> 1.0
        </div>
        <strong>Copyright &copy; 2016 <a href="#">Igniter Team</a>.</strong> All rights reserved.
      </footer>
      
      <div class='control-sidebar-bg'></div>
    </div><!-- ./wrapper -->

    <?php include 'bottom-side.php';?>
  </body>
</html>