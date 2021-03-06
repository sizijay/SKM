<!DOCTYPE html>
<?php
session_start();
require_once('sess.php');
require_once('../../php/dbcon.php');
$query="SELECT * FROM tire WHERE quantity<20 and status='Available';";
$result=mysqli_query($conn,$query);	
if($result){
$_SESSION['notificationcount']=mysqli_num_rows($result);
$_SESSION['lowstockitemscount']=mysqli_num_rows($result);
}
$query="SELECT * FROM order_item WHERE status='unavailable' ";
$result2=mysqli_query($conn,$query);
if($result2){
$_SESSION['notificationcount']+=mysqli_num_rows($result2);
$_SESSION['unavalableorderitemscount']=mysqli_num_rows($result2);	
}
?>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>SKMM| Dashboard</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="../../css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../fonts/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="../../icon/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="../../css/skins/_all-skins.min.css">
  <link rel="stylesheet" href="../../css/mystyle.css?v=1">
   <!-- tab icon-->
	<link rel="icon" href="../../images/skmlogo.jpg">	
    <!-- Google Font -->
 <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-purple sidebar-mini"> 
<div class="wrapper">

  <header class="main-header" id="mainhead">

    <!-- Logo -->
    <a href="index2.html" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><img src="../../images/skmlogo.jpg" style="height:50px;" alt="User Image"></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg" ><img src="../../images/skmlogo.jpg" style="height:50px;" alt="User Image"><b>Dunlop</b></span>
    </a>

    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Notifications: style can be found in dropdown.less -->
          <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o "></i>
              
					   <span class="label label-danger topnoti"></span>
				
             
            </a>
            <ul class="dropdown-menu">
              <li class="header" style="background-color: #DAE0FF">You have <?php
				  echo $_SESSION['notificationcount'];
				  ?> notifications</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
<!-- loading the main header notifications-->                
<?php 
					
				while($row=mysqli_fetch_array($result)){//show details about low stock item
				echo("
                  <li>
                    <a href=\"#\">
                      <i class=\"fa fa-exclamation-circle text-warning\"></i>".$row['tire_size']." of ".$row['brand_name']." ".$row['country']." is in low stock
                    </a>
                  </li>");
					  
				}
					//show details about out of stock order items
				while($row=mysqli_fetch_array($result2)){
					$query3="SELECT * FROM tire WHERE t_id=".$row['tire_t_id'];
					$resultinside=mysqli_query($conn,$query3);
					$rowinside=mysqli_fetch_array($resultinside);
				echo("
                  <li>
                    <a href=\"#\">
                      <i class=\"fa fa-exclamation-triangle text-danger\"></i>".$rowinside['tire_size']." of ".$rowinside['brand_name']." ".$rowinside['country']." is insufficient
                    </a>
                  </li>");
					  
				}	
?>                 
                </ul>
              </li>
              <li class="footer" ><a href="#" style="background-color: #DAE0FF">View all</a></li>
            </ul>
          </li>
             <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="../../images/user8-128x128.jpg" class="user-image" alt="User Image">
              <span class="hidden-xs"><?php
				  echo $_SESSION['currentuser'];
				  ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="../../images/user8-128x128.jpg" class="img-circle" alt="User Image">

                <p>
                  Sales-Executive
                 <small>S.K.Munasinghe Motors</small>
                </p>
              </li>
         
                     <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="#" class="btn btn-default btn-flat">Profile</a>
                </div>
				 
                <div class="pull-right">
                  <a href="../../php/logout.php" class="btn btn-default btn-flat">Sign out</a>
                </div>
				
				<div style="margin-left:77px;">
                  <a href="lockscreen.php" class="btn btn-default btn-flat">Lock Profile</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li>
        </ul>
      </div>

    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="../../images/user8-128x128.jpg" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php
				  echo $_SESSION['currentuser'];
				  ?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- search form -->
      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat">
                  <i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>
      <!-- /.search form  so-->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" id="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        <li  id="dd" class="active treeview menu-open">
          <a href="#">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li>
       
        <li class="treeview">
         	<a href="#">
            	<i class="fa fa-edit"></i> <span>Stock</span>
            	<span class="pull-right-container">
              	<i class="fa fa-angle-left pull-right"></i>
           	 	</span>
          </a>
          <ul class="treeview-menu">
            <li><a href="#" name="viewstock"><i class="fa fa-circle-o"></i>Manage Stock</a></li>
           </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-table"></i> <span>Notifications</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
              <small class="label pull-right bg-red lowstockitemscount"></small>
              <small class="label pull-right bg-green unavalableorderitemscount"></small>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="#" name="lowstock"><i class="fa fa-circle-o"></i>Low Stock Levels<span><label class="label label-danger pull-right lowstockitemscount"></label></span></a></li>
            <li><a href="#" name="outofstockorders"><i class="fa fa-circle-o"></i>Out Of Stock Orders<span><label class="label label-success pull-right unavalableorderitemscount"></label></span></a></li>
          </ul>
        </li>   
      </ul>
	  
	
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" id="content-wrapper" >
    
    <!-- content will be loaded here -->
    
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      Sole Agent of Dunlop tires in Srilanka
    </div>
    <strong>S.K.Muanasinge Motors </strong> 
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
      <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
      <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>
    <!-- Tab panes -->
  
  </aside>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>

</div>

<!-- jQuery 3.1.1 -->
<script src="../../js/jquery-3.1.1.min.js"></script>
<!-- Bootstrap no need 3.3.7 -->
<script src="../../js/bootstrap.min.js"></script>
<!-- FastClick no need -->
<script src="../../js/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="../../js/adminlte.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../js/demo.js"></script>
<script src="../../js/navigation_controler.js?v=2"></script>


</body>


</html>
<script>
function doSomething()
{
   $.ajax({//updating notification
			type:"post",
			url:"modal/notification.php",
			success:function(data){
				data=$.parseJSON(data);
				
				if(data['notificationcount']>0)
					$('.topnoti').html(data['notificationcount']);
				else
					$('.topnoti').html('');
				
				if(data['lowstockitemscount']>0)
					 $('.lowstockitemscount').html(data['lowstockitemscount']);
				else
					$('.lowstockitemscount').html('');
				
				if(data['unavalableorderitemscount']>0)
					 $('.unavalableorderitemscount').html(data['unavalableorderitemscount']);
				else
					$('.unavalableorderitemscount').html('');
					
				
			}
		});
}


setInterval(doSomething, 2*1000);	
</script>
