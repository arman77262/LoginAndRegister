<?php 
    include_once 'lib/Session.php';
    Session::init();
    include_once 'lib/Database.php';
    $db = new Database();
    

    if (isset($_GET['token'])) {
        $token = $_GET['token'];
        $vQuery = "SELECT verify_tokern, v_status FROM tbl_user WHERE verify_tokern = '$token' LIMIT 1";
        $vresult = $db->select($vQuery);

        if ($vresult != false) {
            
            $row = mysqli_fetch_assoc($vresult);
            if ($row['v_status'] == 0) {
                
                $clicked_token = $row['verify_tokern'];
                $update_status = "UPDATE tbl_user SET v_status = '1' WHERE verify_tokern = '$clicked_token' LIMIT 1";
                $update_result = $db->update($update_status);

                if ($update_result) {
                    $_SESSION['status'] = "Your account hasbeen varified successfully";
                    header('Location:login.php');
                    exit(0);
                }else {
                    $_SESSION['status'] = "Varification Failed";
                    header('Location:login.php');
                }

            }else {
                $_SESSION['status'] = "Email already verifyed. Please Login";
                header('Location:login.php');
                exit(0);
            }
            
        }else {
            $_SESSION['status'] = "This Tokern Dose Not Exsist";
            header('Location:login.php');
        }

    }else {
        $_SESSION['status'] = "Not Allowed";
        header('Location:login.php');
    }

?>