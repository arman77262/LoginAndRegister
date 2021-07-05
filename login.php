<?php
include 'inc/header.php';
include 'inc/navbar.php';

if (!session_id()) {
	# code...
}
include_once 'classes/AdminLogin.php';
$al = new AdminLogin();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$email = $_POST['email'];
	$password = md5($_POST['password']);

	$loginChk = $al->adminLogin($email, $password);
}
?>
<br>
<div class="container">

	<div class="row d-flex justify-content-center">
		<div class="col-md-6">

			<span>
				<?php
				if (isset($_SESSION['status'])) {
				?>
					<div class="alert alert-warning alert-dismissible fade show" role="alert">
						<?= $_SESSION['status'] ?>
						<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
					</div>
				<?php
				}
				?>
			</span>

			<span>
				<?php
				if (isset($loginChk)) {
				?>
					<div class="alert alert-warning alert-dismissible fade show" role="alert">
						<?= $loginChk ?>
						<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
					</div>
				<?php
				}
				?>
			</span>

			<div class="card shadow">
				<h5 class="card-header">Login Form</h5>
				<div class="card-body">

					<form action="" method="POST">

						<div class="mb-3">
							<label for="exampleInputEmail1" class="form-label">Email Address</label>
							<input type="email" name="email" class="form-control">
						</div>

						<div class="mb-3">
							<label for="exampleInputEmail1" class="form-label">Password</label>
							<input type="text" name="password" class="form-control">
						</div>

						<button type="submit" name="login" class="btn btn-primary">Login</button>

						<a class="float-end" href="password-reset.php">Forget Your Password?</a>
					</form>
					<hr>
					<h5>Did not receive your varyfication email? <a href="resend-email.php">Resend</a></h5>
				</div>
			</div>
		</div>
	</div>

</div>

<?php include 'inc/footer.php' ?>