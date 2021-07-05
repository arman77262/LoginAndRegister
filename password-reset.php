<?php
include 'inc/header.php';
include 'inc/navbar.php';

if (!session_id()) {
    # code...
}
include_once 'classes/PasswordReset.php';
$pr = new PasswordReset();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];

    $pas = $pr->passwordReset($email);
}
?>
<br>
<div class="container">

    <div class="row d-flex justify-content-center">
        <div class="col-md-6">

            <span>
                <?php
                if (isset($pas)) {
                ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <?= $pas ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php
                }
                ?>
            </span>

            <div class="card shadow">
                <h5 class="card-header">Reset Passowrd</h5>
                <div class="card-body">

                    <form action="" method="POST">

                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Email Address</label>
                            <input type="email" name="email" class="form-control">
                        </div>


                        <button type="submit" name="login" class="btn btn-primary">Send Password Reset Link</button>

                    </form>
                </div>
            </div>
        </div>
    </div>

</div>

<?php include 'inc/footer.php' ?>