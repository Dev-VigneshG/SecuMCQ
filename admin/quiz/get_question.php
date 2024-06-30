<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
            color: #333;
        }

        h1 {
            text-align: center;
            color: #4caf50;
        }

        .questions-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-top: 20px;
        }

        .question {
            margin-bottom: 20px;
            border: 1px solid #ccc;
            padding: 15px;
            border-radius: 8px;
            background-color: #f0f8ff; 
        }

        .question-label {
            font-weight: bold;
            font-size: 16px;
            margin-bottom: 8px;
            color: #333;
        }

        .option-label, .score-label {
            font-size: 14px;
            color: #555;
            display: inline-block;
            margin-bottom: 8px;
        }

        input[type="text"] {
            width: calc(100% - 20px);
            padding: 8px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            display: inline-block;
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            display: block; /* Make the button a block element */
            margin-top: 10px; /* Add some space at the top */
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        input[type="hidden"] {
            display: none;
        }
    </style>
</head>
<body>
    <h1>Question Details</h1>

    <?php
    include("../../db.php");
    $c = 1;
    if($_SERVER["REQUEST_METHOD"]=="POST")
    {
        $question = $_POST['question'];
        $option1 = $_POST['option1'];
        $option2 = $_POST['option2'];
        $option3 = $_POST['option3'];
        $option4 = $_POST['option4'];
        $answer = $_POST['answer'];
        $exp = $_POST['exp'];
        $questionId = $_POST['question_id'];

        $sql = "UPDATE QUESTION SET QUESTION='$question', OPTION1='$option1', OPTION2='$option2', OPTION3='$option3', OPTION4='$option4', VALUE1='$score1', VALUE2='$score2', VALUE3='$score3', VALUE4='$score4' WHERE ID='$questionId'";
     
    }
    if (isset($_GET['id'])) {
        $questionId = $_GET['id'];

        $result = mysqli_query($db, "SELECT * FROM QUESTION WHERE ID='$questionId'");
        if ($result->num_rows > 0) {
          
            echo "<form name='quiz' method='post'>";
            echo "<div class='questions-container'>";
            while ($row = $result->fetch_assoc()) {
                $answer=$row["ANSWER"];
                echo "<div class='question'>";
                echo "<label class='question-label'>Question " . $c . ": </label>";
                echo "<input type='text' name='question' value='" . $row['QUESTION'] . "' /><br>";
                echo "<label class='option-label'>Option 1: </label>";
                echo "<input type='text' name='option1' value='" . $row['OPTION1'] . "' />";
                
                echo "<label class='option-label'>Option 2: </label>";
                echo "<input type='text' name='option2' value='" . $row['OPTION2'] . "' />";
                
                echo "<label class='option-label'>Option 3: </label>";
                echo "<input type='text' name='option3' value='" . $row['OPTION3'] . "' />";
             
                echo "<label class='option-label'>Option 4: </label>";
                echo "<input type='text' name='option4' value='" . $row['OPTION4'] . "' />";
                echo "<label class='option-label'>Answer </label><br><br>";
                $opt=array("A","B","C","D");
                for($i=1;$i<=4;$i++)
                {
                    
                    if($answer==$i)
                    {
                        echo $opt[$i-1];
                        echo "<input type='radio' name='answer' value=".$i ." checked />";
                        echo " ";
                    }
                    else{
                        echo $opt[$i-1];
                    echo "<input type='radio' name='answer' value=".$i ."/>";
                    echo " ";
                    }
                    
                }
                echo "<br><br><label class='option-label'>Explanation </label><br><br>";
                echo "<input type='text' name='exp' value=". $row['EXP']. "></input><br>";
            
               
                echo "<input type='hidden' name='question_id' value='" . $row['ID'] . "' />";
                echo "</div>";
                $c = $c + 1;
            }
            echo "<input type='submit' value='Update'>";
            echo "</div>";
            echo "</form>";
        } else {
            echo "<p>No Question</p>";
        }
    }
    ?>
</body>
</html>
