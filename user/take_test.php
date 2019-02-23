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
        
        if(isset($_GET['test_id'])){
            $test_id = $_GET['test_id'];
        }
        else{
            header("location: user.php");
        }
        $err= "";
        $ques = [];
        $ans = [];
        $sql = "SELECT * FROM test WHERE test_id='$test_id'";
        $result = $conn->query($sql);
        if($result){
            $test = $result->fetch_assoc();
            $test_name = $test['test_name'];
            $duration = $test['duration'];
            $ques_count = $test['ques_count'];
            $sql = "SELECT * FROM questions WHERE test_id='$test_id' ORDER BY que_id";
            $result = $conn->query($sql);
            while($que = $result->fetch_assoc()){
                array_push($ques, 
                    array($que['que'], $que['opt1'], $que['opt2'], $que['opt3'], $que['opt4'], $que['ans'], $que['mark']));
            }
            $ans = array_fill(0,$ques_count,0);
        }
        else{
            $err = "Couldn't Find test";
        }
    ?>
    <div class="body" style="margin-left:0">
        <script> document.getElementById('sidenav').style.display = "none" </script>
        <h1><?= $err ?></h1>

        <div class="container-fluid bg-dark">
            <span class="text-white"> <?= $test_name ?> </span>
            <span class="float-right text-white" id="time_rem"> </span>
            <span class="float-right text-white mr-2">Time Remaining: </span>
        </div>

        <form action="submit_test.php" method="post" name="submit_test_form">
        
            <input type="hidden" name="test_id" value="<?= $test_id ?>" >
            <input type="hidden" name="date" value="<?= date("dmY h:i:s A") ?>">
            <input type="hidden" name="time_rem" value=""> 

        <div id="ques">
            <?php
                $len = count($ques);
                for($i=0; $i<$len; $i++ ){
                    $name = "que_" . ($i + 1);
            ?>
            <div id="<?= $name ?>" style="display:none">
                <span> <?= $i + 1?>. </span>
                <span> <?= $ques[$i][0] ?> </span><br>
                
                <div class="form-check">
                    <input type="radio" class="form-check-input" name="<?= $name ?>" id="<?= $name.'_1' ?>" value="1">    
                    <label class="form-check-label" for="<?= $name.'_1' ?>">
                        <?= htmlspecialchars($ques[$i][1]) ?>
                    </label>
                </div>

                <div class="form-check">
                    <input type="radio" class="form-check-input" name="<?= $name ?>" id="<?= $name.'_2' ?>" value="2">    
                    <label class="form-check-label" for="<?= $name.'_2' ?>">
                        <?= htmlspecialchars($ques[$i][2]) ?>
                    </label>
                </div>

                <div class="form-check">
                    <input type="radio" class="form-check-input" name="<?= $name ?>" id="<?= $name.'_3' ?>" value="3">    
                    <label class="form-check-label" for="<?= $name.'_3' ?>">
                        <?= htmlspecialchars($ques[$i][3]) ?>
                    </label>
                </div>

                <div class="form-check">
                    <input type="radio" class="form-check-input" name="<?= $name ?>" id="<?= $name.'_4' ?>" value="4">    
                    <label class="form-check-label" for="<?= $name.'_4' ?>">
                        <?= htmlspecialchars($ques[$i][4]) ?>
                    </label>
                </div>
            </div>

            <?php
                }
            ?>
        </div>

        <button type="button" class="btn" id="pre_btn" onclick="prevque()">Previous</button>
        <button type="button" class="btn" id="nxt_btn" onclick="nextque()">Next</button>
        <button type="submit" name="submit_test" class="btn btn-success"> Submit</button>        
        </form>
    </div>

    <script>
        
        var que = 1;
        var ques_cnt = "<?= $ques_count ?>"
        document.getElementById("que_1").style.display="block"
        function timeConvert(d){
            d = Number(d)
            var h = Math.floor(d / 3600)
            var m = Math.floor(d % 3600 / 60)
            var s = Math.floor(d % 3600 % 60)

            var hDisplay = h > 0 ? (h >= 10 ? h : "0" + h ) + ":" : ""
            var mDisplay = (m >= 10 ? m : "0" + m ) + ":"
            var sDisplay = (s >= 10 ? s : "0" + s )
            return hDisplay + mDisplay + sDisplay; 
        }
        var duration = "<?= $duration ?>"
        secs_rem  = duration * 60
        var ele = document.getElementById('time_rem')
        var ele2 = document.getElementsByName('time_rem')[0]
        ele.innerHTML = timeConvert(secs_rem)
        var interval = setInterval(() => {
            secs_rem = secs_rem - 1;
            ele.innerHTML = timeConvert(secs_rem)
            ele2.value = secs_rem
            // if(secs_rem == secs_rem - 0.2){
            //     window.alert("Time remaining " + secs_rem)
            // }
        }, 1000);

        function nextque(){
            if(que >= ques_cnt){
                //document.getElementById('nxt_btn').disabled = true
                return
            }
            document.getElementById("que_" + que).style.display="none";
            que++
            document.getElementById("que_" + que).style.display="block";
        }

        function prevque(){
            if(que <= 1){
                // document.getElementById('nxt_btn').disabled = true
                return
            }
            document.getElementById("que_" + que).style.display="none";
            que--
            document.getElementById("que_" + que).style.display="block";
            
        }

    </script>
</body>
</html>