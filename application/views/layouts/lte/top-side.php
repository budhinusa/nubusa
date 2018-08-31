<header class="main-header">
  <!-- Logo -->
  <a href="<?php print site_url()?>" class="logo">
    <!-- mini logo for sidebar mini 50x50 pixels -->
    <span class="logo-mini"><img src="<?php print base_url()?>files/logo/logo.png" width="100%" /></span>
    <!-- logo for regular state and mobile devices -->
    <span class="logo-lg"><img src="<?php print base_url()?>files/logo/logo-panjang.png" width="100%" /></span>
  </a>
  <!-- Header Navbar: style can be found in header.less -->
  <?php
  $notifications = $this->m_notifications->notifications_users_get();
//  print_r($notifications);
  ?>
  <nav class="navbar navbar-static-top" role="navigation">
    <!-- Sidebar toggle button-->
    <a href="javascript:void(0)" class="sidebar-toggle" data-toggle="offcanvas" role="button">
      <span class="sr-only">Toggle navigation</span>
    </a>
    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">
        <!-- Messages: style can be found in dropdown.less-->
        <?php
        if($notifications['status'] == 2){
        ?>
        <li class="dropdown messages-menu">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <i class="fa fa-envelope-o"></i>
            <span class="label label-success"><?php print $notifications["data"]['count']?></span>
          </a>
          <ul class="dropdown-menu">
            <li class="header">You have <?php print $notifications["data"]['count']?> messages</li>
            <li>
              <ul class="menu">
                <?php
                foreach ($notifications['data']['list'] AS $not){
                  print ""
                  . "<li>"
                    . "<a href='".site_url($not['view'])."'>"
                      . "<h4 style='margin: 0 0 0 0 !important;'>"
                        . "{$not["title"]}"
                        . "<small><i class='fa fa-clock-o'></i> ".date("d-m-y H:i", strtotime($not['tanggal']))."</small>"
                      . "</h4>"
                      . "<p style='margin: 0 0 0 0 !important;'>"
                        . "{$not['note']}"
                      . "</p>"
                    . "</a>";
                  if($not['times'] AND $not['check']){
                    print "<div class='btn-group'>"
                      . "<a href='".site_url($not['check'])."' type='button' class='btn btn-info btn-xs'><i class='fa fa-check'></i></a>"
                      . "<a href='".site_url($not['times'])."' type='button' class='btn btn-danger btn-xs'><i class='fa fa-times'></i></a>"
                      . "<a href='".site_url($not['view'])."' type='button' class='btn btn-warning btn-xs'>".lang("View")."</a>"
                    . "</div>";
                  }
                  print "</li>"
                  . "";
                }
                ?>
<!--                <li>
                  <a href="#">
                    <div class="pull-left">
                      <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
                    </div>
                    <h4 style="margin: 0 0 0 0 !important;">
                      Support Team
                      <small><i class="fa fa-clock-o"></i> 5 mins</small>
                    </h4>
                    <p style="margin: 0 0 0 0 !important;">Why not buy a new awesome theme?</p>
                  </a>
                </li>-->
              </ul>
            </li>
            <!--<li class="footer"><a href="#">See All Messages</a></li>-->
          </ul>
        </li>
        <?php
        }
        ?>
        <!-- Notifications: style can be found in dropdown.less -->
<!--        <li class="dropdown notifications-menu">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <i class="fa fa-bell-o"></i>
            <span class="label label-warning">10</span>
          </a>
          <ul class="dropdown-menu">
            <li class="header">You have 10 notifications</li>
            <li>
               inner menu: contains the actual data 
              <ul class="menu">
                <li>
                  <a href="#">
                    <i class="fa fa-users text-aqua"></i> 5 new members joined today
                  </a>
                </li>
                <li>
                  <a href="#">
                    <i class="fa fa-warning text-yellow"></i> Very long description here that may not fit into the page and may cause design problems
                  </a>
                </li>
                <li>
                  <a href="#">
                    <i class="fa fa-users text-red"></i> 5 new members joined
                  </a>
                </li>

                <li>
                  <a href="#">
                    <i class="fa fa-shopping-cart text-green"></i> 25 sales made
                  </a>
                </li>
                <li>
                  <a href="#">
                    <i class="fa fa-user text-red"></i> You changed your username
                  </a>
                </li>
              </ul>
            </li>
            <li class="footer"><a href="#">View all</a></li>
          </ul>
        </li>-->
        <!-- Tasks: style can be found in dropdown.less -->
<!--        <li class="dropdown tasks-menu">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <i class="fa fa-flag-o"></i>
            <span class="label label-danger">9</span>
          </a>
          <ul class="dropdown-menu">
            <li class="header">You have 9 tasks</li>
            <li>
               inner menu: contains the actual data 
              <ul class="menu">
                <li> Task item 
                  <a href="#">
                    <h3>
                      Design some buttons
                      <small class="pull-right">20%</small>
                    </h3>
                    <div class="progress xs">
                      <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                        <span class="sr-only">20% Complete</span>
                      </div>
                    </div>
                  </a>
                </li> end task item 
                <li> Task item 
                  <a href="#">
                    <h3>
                      Create a nice theme
                      <small class="pull-right">40%</small>
                    </h3>
                    <div class="progress xs">
                      <div class="progress-bar progress-bar-green" style="width: 40%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                        <span class="sr-only">40% Complete</span>
                      </div>
                    </div>
                  </a>
                </li> end task item 
                <li> Task item 
                  <a href="#">
                    <h3>
                      Some task I need to do
                      <small class="pull-right">60%</small>
                    </h3>
                    <div class="progress xs">
                      <div class="progress-bar progress-bar-red" style="width: 60%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                        <span class="sr-only">60% Complete</span>
                      </div>
                    </div>
                  </a>
                </li> end task item 
                <li> Task item 
                  <a href="#">
                    <h3>
                      Make beautiful transitions
                      <small class="pull-right">80%</small>
                    </h3>
                    <div class="progress xs">
                      <div class="progress-bar progress-bar-yellow" style="width: 80%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                        <span class="sr-only">80% Complete</span>
                      </div>
                    </div>
                  </a>
                </li> end task item 
              </ul>
            </li>
            <li class="footer">
              <a href="#">View all tasks</a>
            </li>
          </ul>
        </li>-->
        <!-- User Account: style can be found in dropdown.less -->
        <li class="dropdown user user-menu">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <i class="glyphicon glyphicon-user"></i>
            <span class="hidden-xs"><?php print $this->session->userdata("name")?></span>
          </a>
          <ul class="dropdown-menu">
            <!-- User image -->
            <li class="user-header">
              <img src="<?php print site_url("file/index/hrmemployee-employee/{$this->session->userdata("hrm_biodata")}")?>" class="img-circle" alt="User Image" />
              <p>
                <?php print $this->session->userdata("name")?>
                <small><?php print $this->global_models->get_field("m_privilege", "name", array("id_privilege" => $this->session->userdata("id_privilege")))?></small>
              </p>
            </li>
            <!-- Menu Body -->
<!--            <li class="user-body">
              <div class="col-xs-4 text-center">
                <a href="#">Followers</a>
              </div>
              <div class="col-xs-4 text-center">
                <a href="#">Sales</a>
              </div>
              <div class="col-xs-4 text-center">
                <a href="#">Friends</a>
              </div>
            </li>-->
            <!-- Menu Footer-->
            <li class="user-footer">
              <div class="pull-left">
                <a href="<?php print site_url("users/edit-profile")?>" class="btn btn-default btn-flat">Profile</a>
              </div>
              <div class="pull-right">
                <a href="<?php print site_url("login")?>" class="btn btn-default btn-flat">Sign out</a>
              </div>
            </li>
          </ul>
        </li>
        <!-- Control Sidebar Toggle Button -->
<!--        <li>
          <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
        </li>-->
      </ul>
    </div>
  </nav>
</header>