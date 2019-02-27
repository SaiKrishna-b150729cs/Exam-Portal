<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Tests List</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
    <?php
        include('user.php');
        include('../dbConnection.php');
        if(isset($_POST['start_test'])){
            // $url = 'http://localhost:8080/portal/user/take_test.php?test_id=' . $test_id .'&' . 'sess_id=' . $sess_id  ;
            // echo "<script>console.log('".$url."')</script>";
            if(isset($_SESSION['test_id']) && isset($_SESSION['sess_id'])){
                echo "<script>alert('A test is already running redirecting to it');
                    location.href='take_test.php';
                </script>";
                // header('location: take_test.php');
            }   
            else{   
                $test_id = $_POST['start_test'];
                $sess_id = bin2hex(random_bytes(12));
                $_SESSION['test_id'] = $test_id;
                $_SESSION['sess_id'] = $sess_id;
                header('location: instructions.php');
                // exit();
            }
        }
    ?>
    <div class="body mr-4 mt-4">
    <?php
        $sql = "SELECT * FROM test";
        $result=$conn->query($sql);
        if($result->num_rows>0){
    ?>
        <form action="" method="post" name="start_test_form">
        <table class='table table-bordered table-hover'>
            <tr>
            <th>Test name</th>
            <th>Duration</th>
            <th>Questions</th>
            <th>Marks</th>
            <th>Test Added</th>
            <th></th>
            </tr>
        <?php
        while($test=$result->fetch_assoc())
        { 
        ?>
            <tr>
            <td><?= $test['test_name'] ?></td>
            <td><?= $test['duration'] ?></td>
            <td><?= $test['ques_count'] ?></td>
            <td><?= $test['marks'] ?></td>
            <td><?= date("Y/m/d", strtotime($test['date_added'])) ?></td>
            <td>
                <button type="submit" class='btn btn-warning mr-3 text-white' name="start_test"  value=<?= $test['test_id'] ?>>
                    Start<i class='far fa-share-square'></i>
                </button>
            </td>
            </tr>
        <?php
            }            
        }
        ?>
        </table>
        </form>
    </div>
</body>
</html>