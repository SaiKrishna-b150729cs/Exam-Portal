<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Home Page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="scripts.js"></script>
    <link rel="stylesheet" type="text/css" media="screen" href="styles.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" 
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" 
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" 
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" 
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</head>

<body>
    <?php
        session_start();
        if(isset($_SESSION['email'])){
            header("location: user/user.php");
        }
        if(isset($_SESSION['admin'])){
            header("location: admin/admin.php");
        }
        $name = '';
        $email = '';
        $college = '';
        $mobile = '';
        $loginErr = '';
        if(isset($_POST['reg'])){
            include("dbConnection.php");
            //echo "testing";
            $name = $_POST['name'];
            $email = $_POST['email'];
            $college = $_POST['college'];
            $mobile = $_POST['mobile'];
            $pass = md5($_POST['password']);
            $sql = "INSERT INTO user (name, email, password, mobile, college) VALUES('".$name."', '".$email."', '".$pass."', '".$mobile."', '".$college."' )";
            $return=$conn->query($sql);
            if ($return) {
                $_SESSION['email'] = $email;
                $_SESSION['name']= $name;
                header("location: user/user.php");
            }
            else{
                echo "<script type='text/javascript'>alert('Email already registered');</script>";
            }
        }
        if(isset($_POST['login'])){
            include("dbConnection.php");
            $email = $_POST['login_email'];
            $pass = md5($_POST['login_pass']);



            if(isset($_POST['admin_chk'])){
                $sql = "SELECT * FROM admin WHERE email='$email' AND password='$pass'";
                $result=$conn->query($sql);
                // echo $result;
                if($result->num_rows >= 1){
                    $row = $result->fetch_assoc();
                    $_SESSION["admin"] = $email;
                   
                    echo "<script> console.log('Logged in as admin)  </script>";            
                    header("location: admin/admin.php");
                }
                else{
                    echo "<script>alert('You don\'t have admin access'); </script>";
                }
            }
            else{
                $sql = "SELECT name FROM user WHERE email='$email' AND password='$pass'";
                $result=$conn->query($sql);
                if($result->num_rows == 1){
                    $row = $result->fetch_assoc();
                    $_SESSION["email"] = $email;
                    $_SESSION['name'] = $row['name'];
                    header("location: user/user.php");
                }
                else{
                    echo "<script>alert('Wrong Password or email'); </script>";
                }
            }
        }
    ?>
    <div class="header">
        <div class="row">
        <div class="col-lg-11">
            <h3>NITC Exam Portal</h3>
        </div>
        <div class="col-lg-1">
            <button class="btn btn-primary" id="signin_btn" data-toggle="modal" data-target="#signinmodal">
                <span class="glyphicon glyphicon-log-in" aria-hidden="true"></span>&nbsp;
                Signin
            </button>
        </div>
        <div class="modal fade" id="signinmodal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Signin</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" name="login_form" onSubmit="return validatesigninForm()">
                            <div class="form-group">
                                <label for="login_email">Email:</label>
                                <input type="email" id="login_email" name="login_email" class="form-control" placeholder="Enter Email id" autofocus>
                            </div>
                            <div class="form-group">
                                <label for="login_pass">Password:</label>
                                <input type="password" id="login_pass" name="login_pass" class="form-control" placeholder="Password">
                            </div>
                            <div class="form-group form-check">
                                <input type="checkbox" id="admin_chk" name="admin_chk" class="form-check-input" value="admin">
                                <label for="admin_chk" class="form-check-label"> Login as admin</label>
                            </div>
                            <span class="text-danger" id=""><?= $loginErr; ?> </span>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" name="login" class="btn btn-primary">Log in</button>
                    </div>
                        </form>
                        
                    
                </div>
            </div>
        </div>
        </div>
    </div>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" onSubmit="return validatesignupForm()" method="POST" name="register_form">
        <div class="form-group">
            <label for="name">Full Name: </label>
            <input type="text"  id="name" name="name" placeholder="Enter Name" class="form-control" value="<?= $name; ?>" autofocus>
        </div>
        <div class="form-group">
                <label for="email">Email:</label>
                <input type="email"  id="email" name="email" placeholder="Email-id" class="form-control" value="<?= $email ?>">
        </div>
        <div class="form-group">
                <label for="college">College:</label>
                <input type="text"  id="college" name="college" placeholder="College" class="form-control" value="<?= $college ?>">    
        </div>
        <div class="form-group">
                <label for="mobile">Mobile:</label>
                <input type="text"  id="mobile" name="mobile" placeholder="Phone Number" class="form-control" maxlength="10" value="<?= $mobile ?>">    
        </div>
        <div class="form-group">
                <label for="password">Password:</label>
                <input type="password"  id="password" name="password" placeholder="Password" class="form-control">    
        </div>
        <div class="form-group">
                <label for="cpassword">Confirm Password:</label>
                <input type="password"  id="cpassword" name="cpassword" placeholder="Confirm Password" class="form-control">    
        </div>
        <button type="submit" name ="reg"  class="btn btn-primary">Register</button>

    </form>
</body>

</html>