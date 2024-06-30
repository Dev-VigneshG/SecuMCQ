<!DOCTYPE html>
<html>
<head>
    <title>Quiz List</title>
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

        .quiz {
            margin: 0 auto;
            width: 60%;
        }

        .quiz-list {
            margin-bottom: 20px;
            border: 2px solid #ccc;
            padding: 20px;
            border-radius: 8px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .name {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .noOfQuestion {
            font-size: 18px;
            color: #555;
            margin-bottom: 15px;
        }

        .launch, .add {
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

        .launch:hover {
            background-color: #45a049;
        }

        .add {
            margin-left: 70%;
            margin-bottom: 1%;
            width: 10%;
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
            margin: 10% auto;
            
            padding: 20px;
            max-height:70vh;
            border: 1px solid #888;
            width: 60%;
            overflow: auto;
            border-radius: 8px;
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
    </style>
</head>
<body>
<h1>Quiz List</h1>
    <button class="add" onclick="openAddModal()">+ Add</button>

    <div id="addModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('addModal')">&times;</span>
            <h2>Add Quiz</h2>
            <form id="addForm" method="post">
                <label>Name Of Quiz</label>
                <br>
                <input type="text" id="newQuizName" name="newQuizName" required />
                <br><br>
                <input type="submit" value="Submit">
            </form>
        </div>
    </div>

    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('editModal')">&times;</span>
            <h2>Edit Quiz </h2>
            <form id="editForm" method="post">
                <label>New Name Of Quiz</label>
                <br>
                <input type="text" id="editedQuizName" name="editedQuizName" required />
                <br><br>
                <input type="submit" value="Submit">
            </form>
        </div>
    </div>

<div id="deleteModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('deleteModal')">&times;</span>
        <h2>Delete Quiz</h2>
        <p>Are you sure you want to delete this quiz?</p>
        <form id="deleteForm" method="post">
            <input type="hidden" id="deleteQuizId" name="deleteQuizId">
            <input type="submit" value="Delete" onclick="deleteQuiz()">
            <button type="button" onclick="closeModal('deleteModal')">Cancel</button>
        </form>
    </div>
</div>


    <div class="quiz">
        <?php
        include('../../db.php');

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['newQuizName'])) {
            $name = $_POST["newQuizName"];
            mysqli_query($db,"INSERT INTO QUIZ_LIST(NAME) VALUES('$name')");

        }
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['deleteQuizId'])) {
            $Id = $_POST['deleteQuizId'];
            mysqli_query($db, "DELETE FROM QUIZ_LIST WHERE ID='$Id'");
           
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['editedQuizName'])) {
            $editedName = $_POST["editedQuizName"];
            $id=$_POST["quizId"];
            mysqli_query($db,"UPDATE QUIZ_LIST SET NAME='$editedName' WHERE ID='$id'");
        }

        $list = "";
        $result = mysqli_query($db, "SELECT * FROM QUIZ_LIST");
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $list .= "<div class='quiz-list'>";
                $list .= "<p class='name'>" . $row['NAME'] . "</p>";
                $list .= "<p class='noOfQuestion'>No Of Questions: " . $row['NO_OF_QUESTION'] . "</p>";
                $list .= "<a href='#' class=\"launch\" onclick='openEditModal(" . $row['ID'] . ")' class='edit'>Edit</a>";
                $list .= "<a href='#' style=\"margin-left:10px;\" class=\"launch\" onclick='openDeleteModal(" . $row['ID'] . ")' class='delete'>Remove</a>";

                $list .= "<a  style=\"margin-left:10px;\" class=\"launch\" href='question.php?id=" . $row['ID'] . "' class='delete'>View Questions</a>";
                $list .= "</div>";
            }
        } else {
            echo "<p>No quizzes available.</p>";
        }
        echo $list;
        ?>
    </div>

    <script>
        function openAddModal() {
            document.getElementById('addModal').style.display = "block";
        }

        function openEditModal(quizId) {
            document.getElementById('editModal').style.display = "block";
            document.getElementById('editForm').innerHTML += "<input type='hidden' name='quizId' value='" + quizId + "'>";
        }

        function closeModal(modalId) {
            document.getElementById(modalId).style.display = "none";
        }
function openDeleteModal(quizId) {
                document.getElementById('deleteQuizId').value = quizId;
                document.getElementById('deleteModal').style.display = "block";
            }
         function deleteQuiz() {
            var quizId = document.getElementById('deleteQuizId').value;
            closeModal('deleteModal');
        }
    </script>
</body>
</html>