<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Users List</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
    
    <?php
        include('admin.php');
        include('../dbConnection.php');
    ?>
    <div class="body mr-4 mt-4">
    <div>
    <?php
        $sql = "SELECT * FROM user";
        $result=$conn->query($sql);
        if($result->num_rows>0){
            echo "<table class='table table-bordered table-hover'>";
            echo "<tr>";
            echo "<th>Name</th>".
                 "<th>Email</th>".
                 "<th>Mobile</th>".
                 "<th>College</th>".
                 "<th></th>";
            echo "</tr>";
            while($user=$result->fetch_assoc()){
                echo "<tr>";
                echo "<td>".$user['name']."</td>".
                     "<td>".$user['email']."</td>".
                     "<td>".$user['mobile']."</td>".
                     "<td>".$user['college']."</td>".
                     "<td><button class='btn btn-danger mr-2'> 
                     Delete <i class='far fa-trash-alt'></i>
                     </button>
                     <a href='user_stats.php?email=".$user['email']."' style='text-decoration:none; color: white;' class='btn btn-warning'>
                        Stats <i class='far fa-chart-bar'></i>
                     </a></td>
                     ";
                echo "</tr>";
            }
        }
    ?>
    </div>
    </div>
</body>
</html>