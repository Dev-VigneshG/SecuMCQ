<?php
include('../../db.php');

if($_SERVER["REQUEST_METHOD"]=="POST"&&isset($_POST['question_id']))
    {
        $question = $_POST['question'];
        $option1 = $_POST['option1'];
        $option2 = $_POST['option2'];
        $option3 = $_POST['option3'];
        $option4 = $_POST['option4'];
        $ans=$_POST["answer"];
        $exp=$_POST["exp"];
        $questionId = $_POST['question_id'];
        
        $sql = "UPDATE QUESTION SET QUESTION='$question', OPTION1='$option1', OPTION2='$option2', OPTION3='$option3', OPTION4='$option4',ANSWER='$ans',EXP='$exp' WHERE ID='$questionId'";
        mysqli_query($db,$sql);
        header("Location: " . $_SERVER['PHP_SELF']."?id=".$_GET['id']);
    }
if($_SERVER['REQUEST_METHOD']=="POST"&isset($_POST["add"]))
{

$quizid=$_GET["id"];
$question=$_POST["newQuestion"];
$option1=$_POST["option1"];
$option2=$_POST["option2"];
$option3=$_POST["option3"];
$option4=$_POST["option4"];
$answer=$_POST["answer"];
$exp=$_POST["exp"];
if(strlen($exp)==0)
{
    $exp="None";
}
if(mysqli_query($db,"INSERT INTO question(QUIZ_ID,QUESTION,OPTION1,OPTION2,OPTION3,OPTION4,ANSWER,EXP) VALUES('$quizid','$question','$option1','$option2','$option3','$option4','$answer','$exp')"))
{
echo "Added";

header("Location: " . $_SERVER['PHP_SELF']."?id=".$_GET['id']);
}
else
{
echo "Something Wrong";
}
}
?>

<html>
<head>
    <style>
h2
{
text-align:center;
color:green;
font-size:26px;
}
        .add {
            margin-left: 70%;
            margin-bottom: 1%;
            width: 10%;
        }
.add{
            padding: 10px 20px;
            font-size: 18px;
            background-color: #4CAF50;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            color: white;
            text-decoration: none;
            transition: background-color 0.3s ease;
}
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
            height:10%;
            border: 1px solid #ccc;
            padding: 15px;
            border-radius: 8px;
            background-color: #f0f8ff; 
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
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 1% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 70%;
            max-height: 40%;
            height:100%;
            border-radius: 8px;
            overflow: auto;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }


        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
   .modal-content form label {
            display: block;
            margin-bottom: 10px;
        }

        .modal-content form input[type="text"] {
            width: calc(100% - 22px);
            padding: 8px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .modal-content form input[type="submit"] {
            padding: 8px 15px;
            background-color: #4caf50;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .modal-content form input[type="submit"]:hover {
            background-color: #45a049;
        }
        
        .edit-question {
            position:relative;
            top:20px;
            background-color: #4caf50;
            color: white;
                       padding: 8px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .edit-question:hover {
            background-color: #45a049;
        }

    </style>
</head>

<body>
    <button class="add" onclick="openAddModal()">+ Add</button>
    <div id="addModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('addModal')">&times;</span>
            <h2>Add Question</h2>
            <form id="addForm" method="post">
                <label>Question</label>
                <br>
                <input type="text" id="newQuizName" name="newQuestion" placeholder="Question" required />
                <br><br>
                <label>Option 1</label>
                <input type="text" id="newQuizName" name="option1" placeholder="Option 1" required />
                <label>Option 2</label>
                <input type="text" id="newQuizName" name="option2" placeholder="Option 1" required />
                
                <label>Option 3</label>
                <input type="text" id="newQuizName" name="option3" placeholder="Option 1" required />
              
                <label>Option 4</label>
                <input type="text" id="newQuizName" name="option4" placeholder="Option 1" required />
                <label >Answer</label>
                <input type="radio" name="answer" value="1" />
                A
                <input type="radio" name="answer" value="2" />
                B
                <input type="radio" name="answer" value="3" />
                C
                <input type="radio" name="answer" value="4" />
                D
                <br>
                <br>
                <br>
                <label>Explanation</label>
                <input type="text" name="exp" />
                
                <input type="submit" name="add" value="Submit">
            </form>
        </div>
    </div>
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('addModal')">&times;</span>
            <!--
            <h2>Add Question</h2>
            <form id="addForm" method="post">
                <label>Question</label>
                <br>
                <input type="text" id="newQuizName" name="newQuestion" placeholder="Question" required />
                <br><br>
                <label>Option 1</label>
                <input type="text" id="newQuizName" name="option1" placeholder="Option 1" required />
                <input type="text" id="newQuizName" name="score1" placeholder="Score" required />
                <label>Option 2</label>
                <input type="text" id="newQuizName" name="option2" placeholder="Option 1" required />
                <input type="text" id="newQuizName" name="score2" placeholder="Score" required />
                <label>Option 3</label>
                <input type="text" id="newQuizName" name="option3" placeholder="Option 1" required />
                <input type="text" id="newQuizName" name="score3" placeholder="Score" required />
                <label>Option 4</label>
                <input type="text" id="newQuizName" name="option4" placeholder="Option 1" required />
                <input type="text" id="newQuizName" name="score4" placeholder="Score" required />
                <input type="submit" name="add" value="Submit">
            </form>
    -->
        </div>
    </div>



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
            echo  "<form name='quiz' method='post'>
        <div class='questions-container'>";
            echo "<div class='question'>";
            echo "<label class='question-label'>Question " . $c . ". " . $row['QUESTION'] . "</label><br>";
            echo "<a class='edit-question' onclick='openEditModal(this)' data-question-id='" . $row['ID'] . "'>Edit Question</a>";
            echo "<input type='hidden' name='question_id' value='" . $row['ID'] . "' />";
            echo "</div>";
        }
        echo "</div>";
        
        echo "</form>";
    } else {
        echo "No Question";
    }
    ?>

<script>
        function openAddModal() {
            document.getElementById('addModal').style.display = "block";
        }
        /*
        function openEditModal()
{
 document.getElementById('editModal').style.display = "block";
}
*/
function openEditModal(button) {
        var questionId = button.getAttribute('data-question-id');
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                console.log(xhr.responseText);

                //document.getElementById('editModal').innerHTML = "h";
                //document.getElementById('editModal').style.display = "block";
                document.write(xhr.responseText);
            }
        };
        xhr.open("GET", "get_question.php?id=" + questionId, true);
        xhr.send();
    }   
    function closeModal(modalId) {
        document.getElementById(modalId).style.display = "none";
    }

</script>
</body>
</html>
