<?php
session_start();
if(isset($_SESSION['name']))
{
  if($_SESSION['role']=="USER")
  {
    header("Location: ../user");
  }
  else if($_SESSION['role']=="ADMIN")
  {
    
  }
  else if($_SESSION['role']=="COUNSELOR")
  {
    header("Location: ../counselor");
  }
}
else
{
  header("Location: ../login.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Details</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        h1 {
            text-align: center;
            font-family: Arial, Helvetica, sans-serif;
            color: brown;
        }

        table {
            width: 70%;
            margin: auto;
            font-family: Arial, Helvetica, sans-serif;
        }

        table,
        tr,
        th,
        td {
            border: 1px solid #d4d4d4;
            border-collapse: collapse;
            padding: 12px;
        }

        th,
        td {
            text-align: left;
            vertical-align: top;
        }

        tr:nth-child(even) {
            background-color: #e7e9eb;
        }

        .delete-btn {
            background-color: #ff5757;
            color: #fff;
            padding: 8px;
            border: none;
            cursor: pointer;
        }

        .add-btn {
            background-color: #4caf50;
            color: #fff;
            padding: 10px;
            border: none;
            cursor: pointer;
            margin-bottom: 20px;
        }
        #searchInput {
            width: 50%;
            padding: 12px;
            margin: 20px auto;
            display: block;
        }
        
    </style>
     <script>
        function searchTable() {
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("searchInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("myTable");
    tr = table.getElementsByTagName("tr");
    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td");
        for (var j = 0; j < td.length; j++) {
            if (td[j]) {
                txtValue = td[j].textContent || td[j].innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                    break;
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }
}
    </script>
</head>

<body>
    <h1>MANAGE ADMINS</h1>
    <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Search..">
    <button class="add-btn" data-toggle="modal" data-target="#addAdminModal">Add Admin</button>

    <!-- Modal -->
    <div class="modal fade" id="addAdminModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add New Admin</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="adminForm" method="post">
                        <div class="form-group">
                            <label for="adminName">Name:</label>
                            <input type="text" class="form-control" id="adminName" name="adminName" required>
                        </div>
                        <div class="form-group">
                            <label for="adminEmail">Mail ID:</label>
                            <input type="email" class="form-control" id="adminEmail" name="adminEmail" required>
                        </div>
                        <div class="form-group">
                            <label for="adminPassword">Password:</label>
                            <input type="password" class="form-control" id="adminPassword" name="adminPassword" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Admin</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php
    include("../db.php");
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = $_POST['adminName'];
        $email = $_POST['adminEmail'];
        $password = $_POST['adminPassword'];
        $result = mysqli_query($db, "SELECT * FROM register WHERE MAIL='$email'");
        if ($result->num_rows > 0) {
            $r = $result->fetch_assoc();
            if ($r["ROLE"] == "ADMIN") {
                echo "<script>alert('Admin Already Exists')</script>";
            } else {
                mysqli_query($db, "UPDATE register SET ROLE='ADMIN',PASSWORD='$password' WHERE MAIL='$email'");
                echo "<script>alert('Admin Added Successfully')</script>";
            }
        } else {
            $sql = "INSERT INTO register (NAME,MAIL,PASSWORD,ROLE) VALUES ('$name','$email','$password','ADMIN')";
            $result = mysqli_query($db, $sql);
            if ($result) {
                echo "<script>alert('Admin Added Successfully')</script>";
            } else {
                echo "<script>alert('Admin Not Added')</script>";
            }
        }
        echo "<script>location.href='admin.php'</script>";
    }
    // Output Form Entries from the Database
    $sql = "SELECT * FROM register WHERE ROLE='ADMIN'";

    // Fire query
    $result = mysqli_query($db, $sql);

    if (mysqli_num_rows($result) > 0) {
        echo '<table id="myTable"> 
                <tr> 
                    <th>ADMIN ID</th> 
                    <th>NAME</th> 
                    <th>MAIL</th> 
                    <th>Action</th>
                </tr>';

        while ($row = mysqli_fetch_assoc($result)) {
            echo '<tr> 
                    <td>' . $row["ID"] . '</td>
                    <td>' . $row["NAME"] . '</td>
                    <td>' . $row["MAIL"] . '</td>
                    <td><button class="delete-btn" onclick="deleteUser(' . $row["ID"] . ')">Delete</button></td>
                  </tr>';
        }

        echo '</table>';
    } else {
        echo "0 results";
    }

    // Closing connection
    mysqli_close($db);
    ?>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        function deleteUser(userId) {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'delete_user.php?role=admin&id=' + userId, true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    console.log(xhr.responseText);
                    location.reload();
                }
            };
            xhr.send();
        }
    </script>
</body>

</html>
