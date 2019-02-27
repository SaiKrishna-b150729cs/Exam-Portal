<?php
    include("user.php");
    include('../dbConnection.php');

    if (isset($_POST['submit_test']) && isset($_SESSION['sess_id']) ) {
        $test_id = $_POST['test_id'];
        $date = $_POST['date'];
        $time_rem = $_POST['time_rem'];
        $sess_id = $_SESSION['sess_id'];
        $email = $_SESSION['email'];


        $ques = [];
        $sql = "SELECT * FROM questions WHERE test_id='$test_id' ORDER BY que_id";
        $result = $conn->query($sql);
        while($que = $result->fetch_assoc()){
            array_push($ques, 
                array($que['que'], $que['opt1'], $que['opt2'], $que['opt3'], $que['opt4'], $que['ans'], $que['mark']));
        }

        $ques_count = count($ques);
        $answered = $crt = $wrg = $score = 0;
        $selected = [];
        
        /* Inserting into user_tests new test */
        $sql = "SELECT user_id FROM user WHERE email='$email'";
        $result = $conn->query($sql);        
        $user_id = $result->fetch_assoc()['user_id'];
        $sql = "INSERT INTO user_tests (sess_id, user_id, test_id, score, correct, wrong, time_rem, date) VALUES 
                ('".$sess_id."', $user_id ,'".$test_id."','".$score."','".$crt."','".$wrg."','".$time_rem."', '".$date."')";
        $result = $conn->query($sql);
        // echo "<script> console.log(". json_encode($sql) .")</script>";
        // echo "<script> console.log(". json_encode($result) .")</script>";
        

        /* Inserting user entered answers into user_answers */
        for($i=1; $i <= $ques_count; $i++) {
            $ans = 0;
            if (isset($_POST['que_' . $i]))
                $ans = $_POST['que_' . $i];
            array_push($selected, $ans);
            if($ans != 0){
                $answered++;
                if($ans == $ques[$i -1 ][5]){
                    $crt++;
                    $score += $ques[$i -1 ][6];
                }
                else
                    $wrg++;
            }
            $sql = "INSERT INTO user_answers (sess_id, ans_entered, que_id, test_id) VALUES
                    ('".$sess_id."', '".$ans."', '".$i."', '".$test_id."')";
            $result = $conn->query($sql);
            // echo "<script> console.log(". json_encode($sql) .")</script>";
            // echo "<script> console.log(". json_encode($result) .")</script>";
        }
        
        $sql = "UPDATE user_tests SET score=$score, correct=$crt, wrong=$wrg WHERE sess_id='$sess_id' ";
        $result = $conn->query($sql);
        
        // echo "<script> console.log(". json_encode($sql) .")</script>";
        // echo "<script> console.log(". json_encode($result) .")</script>";

        unset($_SESSION['sess_id']);
        echo "<script>
            alert('Test Submitted Successfully');
            location.href='view_test.php?sess_id=" .$sess_id ."'
        </script>";
    } 
    else {
        header('location: tests.php');
    }

?>