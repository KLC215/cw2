<!-- Default open sidebar -->

<!-- Nav menu -->
<nav class="navbar navbar-inverse pmd-navbar navbar-fixed-top pmd-z-depth">
	<div class="container-fluid">
		<!-- Sidebar Toggle Button-->
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
			<a href="javascript:void(0);" class="btn btn-sm pmd-btn-fab pmd-btn-flat pmd-ripple-effect btn-primary pull-left margin-r8 pmd-sidebar-toggle"><i class="material-icons">menu</i></a>
			<a class="navbar-brand" href="/">Electric Vehicle Charging Stations Finder</a>
		</div>
		<!-- Navbar Right icon -->
		<div class="pmd-navbar-right-icon pull-right">
			<button type="button" class="btn btn-primary pmd-ripple-effect">Total <span class="badge" id="amount"></span></button>
			<a href="javascript:void(0);" class="btn btn-sm pmd-btn-fab pmd-btn-flat pmd-ripple-effect btn-primary topbar-toggle visible-xs-inline-block" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"><i class="material-icons pmd-sm">more_vert</i></a>
			<a href="javascript:void(0);" class="btn btn-sm pmd-btn-fab pmd-btn-flat pmd-ripple-effect btn-primary pmd-sidebar-toggle-right"><i class="material-icons">more_horiz</i></a>
		</div>
	</div>
</nav>

<!-- Open sidebar -->
<section id="pmd-main">
	<!-- Left sidebar -->
	<aside class="pmd-sidebar sidebar-custom sidebar-default pmd-sidebar-slide-push pmd-sidebar-left pmd-z-depth sidebar-hide-custom" role="navigation" style="position: absolute;">
		<ul class="nav pmd-sidebar-nav">
			<li class="dropdown pmd-dropdown pmd-user-info">
				<a aria-expanded="false" data-sidebar="true" data-toggle="dropdown" class="btn-user dropdown-toggle media" href="javascript:void(0);">
					<div class="media-left">

						<img width="40" height="40" alt="avatar" src="http://propeller.in/assets/images/avatar-icon-40x40.png">
					</div>
					<div class="media-body media-middle">D,Material Admin</div>
					<div class="media-right media-middle"><i class="material-icons pmd-sm">more_vert</i></div>
				</a>
				<ul class="dropdown-menu">
					<li> <a class="pmd-ripple-effect" href="javascript:void(0);" tabindex="-1"><i class="material-icons media-left media-middle">person</i> <span class="media-body">View Profile</span></a></li>
					<li> <a class="pmd-ripple-effect" href="javascript:void(0);" tabindex="-1"><i class="material-icons media-left media-middle">settings</i> <span class="media-body">Settings</span></a></li>
					<li> <a class="pmd-ripple-effect" href="javascript:void(0);" tabindex="-1"><i class="material-icons media-left media-middle">history</i> <span class="media-body">Logout</span></a></li>
					<li class="divider"></li>
				</ul>
			</li>
			<li> <a class="pmd-ripple-effect" href="javascript:void(0);"><i class="material-icons media-left media-middle">delete</i> <span class="media-body">Trash</span></a> </li>
			<li> <a class="pmd-ripple-effect" href="javascript:void(0);"><i class="material-icons media-left media-middle">notifications</i> <span class="media-body">Spam</span></a> </li>
			<li> <a class="pmd-ripple-effect" href="javascript:void(0);"><i class="material-icons media-left media-middle">notifications</i> <span class="media-body">Follow Up</span></a> </li>
		</ul>
	</aside>

	<!-- Content -->
	<div class="pmd-content" id="content">

		<?php require_once 'content.php'?>

	</div>

	<!-- Right sidebar -->
	<aside class="pmd-sidebar sidebar-custom sidebar-default pmd-sidebar-right-fixed pmd-z-depth" role="navigation" style="position: absolute;">
		<!-- Sidebar navigation -->
		<ul class="nav pmd-sidebar-nav">
			<li> <a class="pmd-ripple-effect" href="javascript:void(0);"> Trash</a> </li>
			<li> <a class="pmd-ripple-effect" href="javascript:void(0);"> Spam</a> </li>
			<li> <a class="pmd-ripple-effect" href="javascript:void(0);"> Follow Up</a> </li>
		</ul>
	</aside>
	<div class="pmd-sidebar-overlay"></div>
</section>