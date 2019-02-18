<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>User page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="../styles.css">    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" 
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" 
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" 
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" 
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="../scripts.js"></script>
</head>
<body>
    <?php
        $name = "";
        session_start();
        if(isset($_SESSION['email'])){
            $name = $_SESSION['name'];
        }
        else{
            header('location: ../index.php');
        }
    ?>
    <div class="header">
        <div class="row">
            <div class="col-lg-10">
                <h3>NITC Exam Portal</h3>
            </div>
            <div class="col-lg-2">
                <div class="dropdown">
                    <span class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <?php echo $name; ?> 
                    </span>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="../logout.php"> Logout</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="sidenav">
        <a href="tests.php">View tests</a>
        <a href="history.php">History</a>
    </div>
    
</body>
</html>