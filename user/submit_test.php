<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Test Completed</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>
    <?php
    include("user.php");
    include('../dbConnection.php');

    if (isset($_POST['submit_test'])) {
        $test_id = $_POST['test_id'];
        $date = $_POST['date'];
        $time_rem = $_POST['time_rem'];

        $ques = [];
        $sql = "SELECT * FROM questions WHERE test_id='$test_id' ORDER BY que_id";
        $result = $conn->query($sql);
        while($que = $result->fetch_assoc()){
            array_push($ques, 
                array($que['que'], $que['opt1'], $que['opt2'], $que['opt3'], $que['opt4'], $que['ans'], $que['mark']));
        }

        $ques_count = count($ques);
        $answered = 0;
        $crt = 0;
        $wrg = 0;
        $score = 0;

        $i = 1;
        $sess_id = bin2hex(random_bytes(12));
        $sql = "";
        $selected = [];
        while ($i <= $ques_count) {
            $ans = 0;
            if (isset($_POST['que_' . $i]))
            $ans = $_POST['que_' . $i];
            // echo "$ans";
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
            // $reult = $conn->query($sql);
            $i++;
        }
        $email = $_SESSION['email'];
        $sql = "SELECT user_id FROM user WHERE email='$email'";
        $result = $conn->query($sql);        
        $user = $result->fetch_assoc();
        $user = $user['user_id'];
        
        $sql = "INSERT INTO user_tests (sess_id, user_id, test_id, score, correct, wrong, time_rem, date) VALUES 
                ('".$sess_id."', $user ,'".$test_id."','".$score."','".$crt."','".$wrg."','".$time_rem."', '".$date."')";
        $result = $conn->query($sql);
        echo "<script> console.log(". json_encode($sql) .")</script>";
        echo "<script> console.log(". json_encode($result) .")</script>";


        // echo "$sql";
    } else {
        $err = "Page Not Found";
    }

    ?>
    <div class="body mt-4">
        <h3>Test Submitted successfully</h3>

        <p>Answered: <?= $answered ?> </p>
        <p>Correct: <?= $crt ?> </p>
        <p>Wrong: <?= $wrg ?> </p>
        <p>Score: <?= $score ?> </p>

        <button class="btn btn-primary" onclick="toggle()">View Answers</button>

        <div id="answers" style="display:none">
            <?php
                for($i=0; $i<$ques_count; $i++ ){
                    $id = "que" . ($i);
            ?>
            <div id="<?= $id ?>">
                <span> <?= $i + 1?>.  <?= htmlspecialchars($ques[$i][0]) ?></span><br>
                <input type="radio" id="<?= $id .'_1' ?>" > 
                    <span > <?= htmlspecialchars($ques[$i][1]) ?> </span><br>
                <input type="radio" id="<?= $id .'_2' ?>"> 
                    <span > <?= htmlspecialchars($ques[$i][2]) ?> </span><br>
                <input type="radio" id="<?= $id .'_3' ?>"> 
                    <span > <?= htmlspecialchars($ques[$i][3]) ?> </span><br>
                <input type="radio" id="<?= $id .'_4' ?>"> 
                    <span > <?= htmlspecialchars($ques[$i][4]) ?> </span>
            </div>
            <?php
                }
            ?>

        </div>
    </div>
    <script>
        
        dis = false
        function toggle(){
            dis = !dis
            if(dis){
                document.getElementById('answers').style.display = "block"
            }
            else{
                document.getElementById('answers').style.display = "none"
            }
        }

        var len =  <?= $ques_count ?>

        var ques = <?= json_encode($ques) ?>

        var selected = <?= json_encode($selected) ?>
        
        right = document.createElement('i')
        right.className = "fas fa-check text-success"
        wrong = document.createElement('i')
        wrong.className = "fas fa-times text-danger"
        // console.log(right)

        for(i=0;i<len;i++){
            ele = document.getElementById('que' + i + '_' + ques[i][5])
            ele.nextElementSibling.appendChild(right.cloneNode())
            // console.log(i,ele)
            if(selected[i] != "0"){
                if(selected[i] != ques[i][5]){
                    ele = document.getElementById('que' + i + '_' + selected[i])
                    ele.checked = true;
                    ele.nextElementSibling.appendChild(wrong.cloneNode())
                    // console.log(i,ele)
                }else{
                    ele.checked = true
                }
            }
        }


    </script>
</body>
</html>