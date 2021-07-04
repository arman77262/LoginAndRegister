<?php
include 'inc/header.php';
include 'inc/navbar.php';
include_once 'classes/Register.php';

$reg = new Register();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$name = $_POST['name'];
	$phone = $_POST['phone'];
	$email = $_POST['email'];
	$password = md5($_POST['password']);

	$insertReg = $reg->insertData($_POST);
}

?>
<br>
<div class="py-3">
	<div class="container">

		<div class="row d-flex justify-content-center">
			<div class="col-md-6">

				<span>
				<?php 
					if (isset($insertReg)) {
						?>
						<div class="alert alert-warning alert-dismissible fade show" role="alert">
						<?=$insertReg?>
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>
						<?php
					}
				?>
				</span>

				<div class="card shadow">
					<h5 class="card-header">Registration Form</h5>
					<div class="card-body">

						<form action="" method="POST">
							<form>
								<div class="mb-3">
									<label for="exampleInputEmail1" class="form-label">Name</label>
									<input type="text" name="name" class="form-control" required>
								</div>

								<div class="mb-3">
									<label for="exampleInputEmail1" class="form-label">Phone Number</label>
									<input type="text" name="phone" class="form-control" required>
								</div>

								<div class="mb-3">
									<label for="exampleInputEmail1" class="form-label">Email Address</label>
									<input type="email" name="email" class="form-control" required>
								</div>

								<div class="mb-3">
									<label for="exampleInputEmail1" class="form-label">Password</label>
									<input type="password" name="password" class="form-control" required>
								</div>

								<button type="submit" name="register" class="btn btn-primary">Register</button>
							</form>
						</form>
					</div>
				</div>
			</div>
		</div>

	</div>
</div>

<?php include 'inc/footer.php' ?>