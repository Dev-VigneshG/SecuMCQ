<?php
include('../../db.php');
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST["add"])) {
    $quizid = $_GET["id"];
    $question = $_POST["newQuestion"];
    $option1 = $_POST["option1"];
    $option2 = $_POST["option2"];
    $option3 = $_POST["option3"];
    $option4 = $_POST["option4"];
    $score1 = $_POST["score1"];
    $score2 = $_POST["score2"];
    $score3 = $_POST["score3"];
    $score4 = $_POST["score4"];
    if (mysqli_query($db, "INSERT INTO question(QUIZ_ID,QUESTION,OPTION1,OPTION2,OPTION3,OPTION4,VALUE1,VALUE2,VALUE3,VALUE4) VALUES('$quizid','$question','$option1','$option2','$option3','$option4','$score1','$score2','$score3','$score4')")) {
        echo "Added";
    } else {
        echo "Something Wrong";
    }
}

// Delete question
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST["delete"])) {
    $questionId = $_POST["question_id"];
    mysqli_query($db, "DELETE FROM question WHERE QNO='$questionId'");
}

?>

<html>
<head>
    <style>
        h2 {
            text-align: center;
            color: green;
            font-size: 26px;
        }

        .add {
            margin-left: 70%;
            margin-bottom: 1%;
            width: 10%;
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
            height: 10%;
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
            height: 90%;
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
            position: relative;
            top: 20px;
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

        .delete-question {
            background-color: #f44336;
            color: white;
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-right: 10px;
        }

        .delete-question:hover {
            background-color: #d32f2f;
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
            echo "<form name='quiz' method='post'>
                    <div class='questions-container'>
                        <div class='question'>
                            <label class='question-label'>Question " . $c . ". " . $row['QUESTION'] . "</label><br>
                            <input type='hidden' name='question_id' value='" . $row['QNO'] . "' />
                            <input type='submit' class='edit-question' value='Edit Question' />
                            <input type='submit' class='delete-question' name='delete' value='Delete Question' />
                        </div>
                    </div>";
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

        function closeModal(modalId) {
            document.getElementById(modalId).style.display = "none";
        }
    </script>
</body>
</html>
