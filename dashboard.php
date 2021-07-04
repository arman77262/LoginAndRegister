<?php 
    include 'inc/header.php';
    include 'inc/navbar.php';

	if (!session_id()) {
	
	}

require_once 'lib/Session.php';
Session::checkSession();
?>

<div class="py-5">
	<div class="container">
		<div class="row">
			<div class="col-md-12 text-center">
				<div class="card">
					<div class="card-header">
						<h4>User Dashboard</h4>
					</div>
					<div class="card-body">
						<h2>Access When You Are Login</h2>
						<hr>
						<h3>Username: <?php echo Session::get('username')?></h3>
						<h3>Phone: <?php echo Session::get('phone')?></h3>
						<h3>Email: <?php echo Session::get('email')?></h3>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php include 'inc/footer.php'?>