<!DOCTYPE html>
<html>
  <?php
  include 'header.php';
  ?>
  <body class="skin-blue sidebar-mini <?php print $posisi?>"><!--sidebar-collapse -->
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
          <?php print $template['body']?>
        </section>
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