<?php
include 'inc/header.php';
include 'inc/navbar.php';
include_once 'classes/ChangePassword.php';

$cp = new ChangePassword();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    $c_password = md5($_POST['c_password']);

    $changeP = $cp->changePassword($_POST);
}

?>
<br>
<div class="py-3">
    <div class="container">

        <div class="row d-flex justify-content-center">
            <div class="col-md-6">

                <span>
                    <?php
                    if (isset($changeP)) {
                    ?>
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <?= $changeP ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php
                    }
                    ?>
                </span>

                <div class="card shadow">
                    <h5 class="card-header">Change Password</h5>
                    <div class="card-body">

                        <form action="" method="POST">
                            <form>

                                <input type="hidden" name="password_token" 
                               value=" <?php 
                                    if (isset($_GET['token'])){
                                        echo $_GET['token'];
                                    }
                                ?>"
                                >

                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Email Address</label>
                                    <input type="email" value="<?php if(isset($_GET['email'])){echo $_GET['email'];}?>" name="email" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">New Password</label>
                                    <input type="password" name="password" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Confirm Password</label>
                                    <input type="password" name="c_password" class="form-control" required>
                                </div>


                                <button type="submit" name="register" class="btn btn-success w-100">Update Password</button>
                            </form>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<?php include 'inc/footer.php' ?>