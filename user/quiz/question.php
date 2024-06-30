<?php
$db = new mysqli("localhost", "root", "", "wellmind");
if ($db->connect_error) {
    echo "not connected";
}

if($_SERVER['REQUEST_METHOD']=="POST")
{
$score=0;
foreach($_POST as $q=>$v)
{
$score+=$v;
}
header("Location: score.php?score=".$score."&id=".$_GET['id']);
}


?>

<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        h1 {
            text-align: center;
        }

        form {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .question {
            margin-bottom: 20px;
        }

        label.question-label {
            font-weight: bold;
            font-size: 16px;
            color: #555;
            margin-bottom: 8px;
        }

        label.option {
            display: block;
            margin-bottom: 8px;
        }

        input[type="radio"] {
            margin-right: 10px;
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>
    <h1>Questions</h1>
    <?php
    $no = $_GET['id'];

    $c = 0;
    $result = mysqli_query($db, "SELECT * FROM QUESTION WHERE QUIZ_ID='$no'");
    if ($result->num_rows > 0) {
        echo "<form name='quiz' method='post'>";
        echo "<div class='questions-container'>";
        while ($row = $result->fetch_assoc()) {
            $c = $c + 1;
            echo "<div class='question'>";
            echo "<label class='question-label'>" . $c . ". " . $row['QUESTION'] . "</label><br>";
            if($no==2)
            {
                echo "<label class='option'><input type='radio' value='0' name='q" . $c . "' >" ."Not Present". "</label>";
            }
            echo "<label class='option'><input type='radio' value=".$row['VALUE1']." name='q" . $c . "' >" . $row['OPTION1'] . "</label>";
            echo "<label class='option'><input type='radio'  name='q" . $c . "' value=".$row['VALUE2'].">" . $row['OPTION2'] . "</label>";
            echo "<label class='option'><input type='radio'  name='q" . $c . "' value=".$row['VALUE3'].">" . $row['OPTION3'] . "</label>";
            echo "<label class='option'><input type='radio'  name='q" . $c . "' value=".$row['VALUE4'].">" . $row['OPTION4'] . "</label>";
            echo "</div>";
        }
        echo "</div>";
        echo "<input type='submit' value='Submit'>";
        echo "</form>";
    } else {
        echo "No Question";
    }
    ?>
</body>
</html>
