<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Instructions</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
    <?php
        include('user.php');
        include('../dbConnection.php');
        
    ?>
    <script> document.getElementById('sidenav').style.display = "none" </script>
    <div class="body mr-4 mt-4 align-middle">
        <h2 class="align-middle">Instructions</h2>
        <h6>1. Donot reload page in middle of test</h6>
        <h6>2. Mobile phones and calculators are strictly prohibited</h6>

        <button onclick="start()" class="btn btn-primary"> Start Test</button>
    </div>

    <script>
        function start() {
            window.location.href="take_test.php";
        }
    </script>
</body>
</html>