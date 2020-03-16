<body>
	<?php require('./pages/components/offcanvas.php');?>
	<div class="container" id="mainContent">
		<div class="page-header">
			<h1><?php echo LA_CONTLIST_MAN;?><small>Control Panel</small></h1>
		</div>
		<p class="lead"><?php echo LA_CONTLIST_HELP?></p>
		<div class="list-group">
			<a href="./contest_add.php" class="list-group-item">
				<h4 class="list-group-item-heading"><i class="fa fa-plus-circle"></i> Add Contest</h4>
				<p class="list-group-item-text"><?php echo LA_CONTLIST_ADD?></p>
			</a>
			<a href="./contest_list.php" class="list-group-item">
				<h4 class="list-group-item-heading"><i class="fa fa-th-list"></i> Contest List</h4>
				<p class="list-group-item-text"><?php echo LA_CONTLIST_ADD?></p>
			</a>
		</div>
	</div>
</body>