<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Test Summary</title>
</head>
<body>
    <?php
        include('user.php');
        include('../dbConnection.php');

        $ques = [];
        $selected = [];
        $answered = $crt = $wrg = $score = $ques_count = 0;


        if(isset($_GET['sess_id'])){
            $sess_id = $_GET['sess_id'];
            $sql = "SELECT * FROM user_tests WHERE sess_id='$sess_id'";
            $result = $conn->query($sql);
            if($result->num_rows == 1)
                $sess = $result->fetch_assoc();
            else
                header('location: tests.php');
            // $sess = $result->fetch_assoc();
            $test_id = $sess['test_id'];

            $sql = "SELECT * FROM questions WHERE test_id='$test_id' ORDER BY que_id";
            $result = $conn->query($sql);
            while($que = $result->fetch_assoc()){
                array_push($ques, 
                    array($que['que'], $que['opt1'], $que['opt2'], $que['opt3'], $que['opt4'], $que['ans'], $que['mark']));
            }
            $ques_count = count($ques);

            $sql = "SELECT * FROM user_answers WHERE sess_id='$sess_id' AND test_id='$test_id' ORDER BY que_id";
            $result = $conn->query($sql);
            $i = 0;
            while($que = $result->fetch_assoc()){
                $ans = $que['ans_entered'];
                array_push($selected, $ans);
                if($ans != 0){
                    $answered++;
                    if($ans == $ques[$i][5]){
                        $crt++;
                        $score += $ques[$i][6];
                    }
                    else
                        $wrg++;
                }
                $i++;
            }

        }
        else{
            header('location: user.php');
        }
    ?>

    <div class="body mt-4">

        <p>Answered: <?= $answered ?> </p>
        <p>Correct: <?= $crt ?> </p>
        <p>Wrong: <?= $wrg ?> </p>
        <p>Score: <?= $score ?> </p>

        <button class="btn btn-primary" onclick="toggle()" id="btn_view">View Answers</button>
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

        dis = false;
        ans_ele = document.getElementById('answers');
        btn_ele = document.getElementById('btn_view');
        function toggle(){
            dis = !dis
            if(dis){
                ans_ele.style.display = "block"
                btn_ele.innerHTML = "Hide Answers"
            }
            else{
                ans_ele.style.display = "none"
                btn_ele.innerHTML = "View Answers"
            }
        }

        var len =  <?= $ques_count ?> ;
        var ques = <?= json_encode($ques) ?> ;
        var selected = <?= json_encode($selected) ?> ;
        
        right = document.createElement('i')
        right.className = "fas fa-check text-success"
        wrong = document.createElement('i')
        wrong.className = "fas fa-times text-danger"
        
        for(i=0;i<len;i++){
            ele = document.getElementById('que' + i + '_' + ques[i][5])
            ele.nextElementSibling.appendChild(right.cloneNode())
            if(selected[i] && selected[i] != "0"){
                if(selected[i] != ques[i][5]){
                    ele = document.getElementById('que' + i + '_' + selected[i])
                    ele.checked = true;
                    ele.nextElementSibling.appendChild(wrong.cloneNode())
                }else{
                    ele.checked = true
                }
            }
        }
    </script>
    
</body>
</html>