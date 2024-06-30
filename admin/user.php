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
    <h1>USER DETAILS</h1>
    <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Search..">
    <?php
    include("../db.php");
    
    $sql = "SELECT * FROM register WHERE ROLE='USER'";
    $result = mysqli_query($db, $sql);

    if (mysqli_num_rows($result) > 0) {
        echo '<table id="myTable"> 
                <tr> 
                    <th>USER ID</th> 
                    <th>NAME</th> 
                    <th>MAIL</th> 
                    
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

    
    mysqli_close($db);
    ?>

    <script>
        function deleteUser(userId) {
            
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'delete_user.php?role=user&id=' + userId, true);
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
 
 