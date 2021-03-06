<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Add Test</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="../scripts.js"></script>
</head>
<body>
    
    <?php
        include('admin.php');
        include('../dbConnection.php');
        $name = "";
        $count = 0;
        $i = 1;
        $ques = array();
        $test_id = "";
        if(isset($_SESSION['test_id'])){
           $test_id = $_SESSION['test_id'];
           echo "<script>console.log('".$test_id."')</script>";
           $sql = "SELECT * FROM test WHERE test_id='$test_id'";
           $result = $conn->query($sql);
           if($result->num_rows == 1){
                $row = $result->fetch_assoc();
                $name = $row['test_name'];
                $count = $row['ques_count'];
           }
           else{
                header("location: admin.php");
            }
        }
        else{
            echo "<script>console.log('No test_id')</script>";
            header("location: admin.php");
        }
        if(isset($_POST['add_questions'])){
            $marks = 0;
            while($i <= $count ){
                $que_id = 'question' . $i; 
                $que = $_POST[$que_id];
                $op1 = $_POST[$que_id . '_1'];
                $op2 = $_POST[$que_id . '_2'];
                $op3 = $_POST[$que_id . '_3'];
                $op4 = $_POST[$que_id . '_4'];
                $ans = (int)$_POST[$que_id . 'ans'];
                $mark = (int)$_POST[$que_id . 'mark'];
                $marks = $marks + $mark;
                $sql = "INSERT INTO questions (que_id, que, opt1, opt2, opt3, opt4, ans, test_id, mark ) VALUES (
                    '".$i."', '".$que."', '".$op1."' , '".$op2."', '".$op3."', '".$op4."', '".$ans."', '".$test_id."' , '".$mark."')";
                // $sql = "INSERT INTO questions (que_id, que, opt1, opt2, opt3, opt4, ans, test_id, mark ) VALUES (
                //     $i, $que, $op1 , $op2, $op3, $op4, $ans, $test_id , $mark)";
                $i++;
                $result=$conn->query($sql);
            }
            $sql = "UPDATE test SET marks='".$marks."' WHERE test_id = '".$test_id."' ";
            $result=$conn->query($sql);
            echo "<script>alert('Questions added to database')</script>";
            header("location: tests.php");
        }
        
    ?>
    <div class="body">
        <span class='font-weight-bold'>TestName: <?= $name ?></span><br><br>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" onSubmit="return validatequestionsForm(<?= $count ?>)" method="POST" name="questions_form">
            <?php
                while($i <= $count){
                    $que_id = 'question' . $i; 
                    echo "<div class='form-group'>";
                    echo "<label for=$que_id class='font-weight-bold'>Question $i: </label>";
                    echo "<input type='text'  id=$que_id name=$que_id class='form-control' autofocus>";
                    echo "</div>";

                    
                    $id = $que_id . '_1';
                    echo "<div class='input-group mb-3'>";
                    echo "<div class='input-group-prepend'>";
                    echo "<span class='input-group-text'>Option 1</span>";
                    echo "</div>";
                    echo "<input type='text'  id=$id name=$id class='form-control' autofocus>";
                    echo "</div>";
                    
                    $id = $que_id . '_2';
                    echo "<div class='input-group mb-3'>";
                    echo "<div class='input-group-prepend'>";
                    echo "<span class='input-group-text'>Option 2</span>";
                    echo "</div>";
                    echo "<input type='text'  id=$id name=$id class='form-control' autofocus>";
                    echo "</div>";

                    $id = $que_id . '_3';
                    echo "<div class='input-group mb-3'>";
                    echo "<div class='input-group-prepend'>";
                    echo "<span class='input-group-text'>Option 3</span>";
                    echo "</div>";
                    echo "<input type='text'  id=$id name=$id class='form-control' autofocus>";
                    echo "</div>";

                    $id = $que_id . '_4';
                    echo "<div class='input-group mb-3'>";
                    echo "<div class='input-group-prepend'>";
                    echo "<span class='input-group-text'>Option 4</span>";
                    echo "</div>";
                    echo "<input type='text'  id=$id name=$id class='form-control' autofocus>";
                    echo "</div>";

                    echo "<div class='row'>";

                    $id = $que_id . 'ans';
                    echo "<div class='input-group mb-3 col'>";
                    echo "<div class='input-group-prepend'>";
                    echo "<span class='input-group-text'>Answer</span>";
                    echo "</div>";
                    echo "<input type='number'  id=$id name=$id class='form-control' autofocus>";
                    echo "</div>";

                    $id = $que_id . 'mark';
                    echo "<div class='input-group mb-3 col'>";
                    echo "<div class='input-group-prepend'>";
                    echo "<span class='input-group-text'>Marks</span>";
                    echo "</div>";
                    echo "<input type='number'  id=$id name=$id class='form-control' autofocus>";
                    echo "</div>";

                    echo "</div>";

                    $i++;
                }
            ?>
            <button type="submit" name="add_questions" class="btn btn-success"> Add Test</button>
        </form>
    </div>
</body>
</html>