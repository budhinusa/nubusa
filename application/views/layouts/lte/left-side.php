<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
      <?php
      if($this->session->userdata("logo_perusahaan")){
      ?>
      <div style="text-align: center">
        <img src="<?php print base_url()."files/perusahaan/".$this->session->userdata("logo_perusahaan") ?>" class="img" alt="Perusahaan" style="width: 100%" />
      </div>
      <?php
      }
      ?>
    </div>
    <?php
    $edit = $this->nbscache->get_explode("menu", $this->session->userdata("id_privilege"));
    $menu_ca = unserialize($edit[1]);
//    if(!$menu_ca)
//      $menu_ca = unserialize($edit[0]);
//    print_r($edit[0]);
    ?>
    
    <ul id="treemenu2" class="treeview sidebar-menu">
    <?php
    foreach($menu_ca as $k_mc => $mc){
      print "<li class='treeview'>"
        . "<a href='javascript:void(0)'>"
          . "<i class='fa {$mc['icon']}'></i>"
          . "<span>".lang($mc['name'])."</span>"
          . "<i class='fa fa-angle-left pull-right'></i>"
      . "</a>";
      $ululnya = '<ul class="acitem treeview-menu">';
      $lilinya = "";
      foreach($mc['child'] as $k_child => $mchild){
        if(count($mchild['child']) > 0){
          if($mchild['icon'])
            $ii = $mchild['icon'];
          else
            $ii = 'fa-circle-o';
          $link_sub = "<a href='javascript:void(0)'><i class='fa {$ii}'></i> ".lang($mchild['name'])."</a>";
        }
        else{
          if($menu == $mchild['link']){
            $ululnya = "<ul class='acitem treeview-menu' rel='open'>";
          }
          if($mchild['icon'])
            $ii = $mchild['icon'];
          else
            $ii = 'fa-circle-o';
          $link_sub = "<a class='ya-ajax' href='".site_url($mchild['link'])."'><i class='fa {$ii}'></i> ".lang($mchild['name'])."</a>";
        }
        $lilinya .= "<li>{$link_sub}";
        if(count($mchild['child']) > 0){
          $ulnya = "<ul class='treeview-menu'>";
          $linya = "";
          foreach($mchild['child'] as $kmchild => $mcchild){
            if($menu == $mcchild['link']){
              $ulnya = "<ul class='treeview-menu' rel='open'>";
            }
            $link_sub_child = site_url($mcchild['link']);
            if($mcchild['icon'])
              $iii = $mcchild['icon'];
            else
              $iii = 'fa-circle-o';
            $linya .= "<li><a class='ya-ajax' href='{$link_sub_child}'><i class='fa {$iii}'></i>".lang($mcchild['name'])."</a>";
          }
          $lilinya .= $ulnya.$linya."</ul>";
        }
      }
      print $ululnya;
      print $lilinya;
      print "</ul>";
    }
    ?>
    </ul>
  </section>
  <!-- /.sidebar -->
</aside>