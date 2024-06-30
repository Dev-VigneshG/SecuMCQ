<?php
$db = new mysqli("localhost", "root", "", "wellmind");
if ($db->connect_error) {
    echo "not connected";
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

        .launch {
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
    </style>
</head>

<body>
    <h1>Quiz List</h1>
    <div class="quiz">
        <?php
        $list = "";
        $result = mysqli_query($db, "SELECT * FROM QUIZ_LIST");
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $list .= "<div class='quiz-list'>";
                $list .= "<p class='name'>" . $row['NAME'] . "</p>";
                $list .= "<p class='noOfQuestion'>No Of Questions: " . $row['NO_OF_QUESTION'] . "</p>";
                $list .= "<a href='question.php?id=" . $row['ID'] . "' class='launch'>Launch</a>";
                $list .= "</div>";
            }
        } else {
            echo "No quizzes available.";
        }
        echo $list;
        ?>
    </div>
</body>
</html>
