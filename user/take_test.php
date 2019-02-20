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
            <a class="mr-1" href='#'>&lt&ltPrevious</a>
            <a href="#">Next&gt&gt</a>
            <span class="float-right text-white" id="time_rem"> </span>
            <span class="float-right text-white mr-2">Time Remaining: </span>
            
            

        </div>


    </div>

    <script>
        function timeConvert(d){
            d = Number(d);
            var h = Math.floor(d / 3600);
            var m = Math.floor(d % 3600 / 60);
            var s = Math.floor(d % 3600 % 60);

            var hDisplay = h > 0 ? (h >= 10 ? h : "0" + h ) + ":" : "";
            var mDisplay = (m >= 10 ? m : "0" + m ) + ":"
            var sDisplay = (s >= 10 ? s : "0" + s )
            return hDisplay + mDisplay + sDisplay; 
        }
        var duration = "<?= $duration ?>"
        secs_rem  = duration * 60
        var ele = document.getElementById('time_rem')
        ele.innerHTML = timeConvert(secs_rem)
        var interval = setInterval(() => {
            secs_rem = secs_rem - 1;
            ele.innerHTML = timeConvert(secs_rem)
            // if(secs_rem == secs_rem - 0.2){
            //     window.alert("Time remaining " + secs_rem)
            // }
        }, 1000);

    </script>
</body>
</html>