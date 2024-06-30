    <?php
session_start();


if (!isset($_SESSION['userid'])) {
    header("location: ../../login.php");
}

?>
<!DOCTYPE html>
<html>

<head>
    <title>Quiz Questions</title>
    <link rel="stylesheet" href="style.css">
    <style>
        
         </style>
    <script>
        var chance = 3;

        function showModal() {
            const overlay = document.getElementById('overlay');    
            overlay.style.display = 'block';
        }

        function hideModal() {
            const overlay = document.getElementById('overlay'); 
            overlay.style.display = 'none';
        }
        function checkFullscreen() {
            if (!document.fullscreenElement) {
                showModal();
                document.getElementById("content").innerText ="You are not allowed to exit full screen mode\n You Have "+chance+" chances only";
                chance--;
                if(chance==0)
                {
                    alert("You have been banned from the quiz!");
                    document.getElementById("quiz-form").submit();
                }
                
            }
            else
            {
                
                hideModal();
            }
        }

        document.addEventListener('DOMContentLoaded', checkFullscreen);
        
        function openFullscreen() {
            const docElem = document.documentElement;
            if (docElem.requestFullscreen) {
                docElem.requestFullscreen();
            } else if (docElem.mozRequestFullScreen) {
                docElem.mozRequestFullScreen();
            } else if (docElem.webkitRequestFullscreen) {
                docElem.webkitRequestFullscreen();
            } else if (docElem.msRequestFullscreen) {
                docElem.msRequestFullscreen();
            }
        }

        document.addEventListener('contextmenu', function(event) {

            event.preventDefault();

        });

    

        document.addEventListener('fullscreenchange', checkFullscreen);


        document.onkeydown = function(e) {
            alert("No Cheating Allowed! You have been reported! You will be banned from the quiz!");

            chance--;
            if (chance == 0) {
                alert("You have been banned from the quiz!");
                document.getElementById("quiz-form").submit();

            } else {
                alert("You have " + chance + " chances only");
            }

            return false;
        }
        document.onkeyup = function(e) {
            return false;
        };

        document.addEventListener('keydown', function(event) {
            if (event.target.classList.contains('protected')) {
                event.preventDefault();
            }
        });
    </script>

</head>

<body onclick="openFullscreen();" onload="openFullscreen();" onmouseover="openFullscreen();" oncontextmenu="openFullscreen()" ondrag="select()">
    <div id="overlay" class="overlay">
        <div id="modal" class="modal">
            <div class="modal-content">
                <p id="content"> </p>
                <button id="okButton">OK</button>
            </div>
        </div>
    </div>

    <script>
        var timerInterval;

        function updateTimer(minutes, seconds) {


            var timerDisplay = document.getElementById('timer');
            timerDisplay.innerHTML = 'Time Remaining: ' + minutes + ' minutes ' + seconds + ' seconds';
            timerInterval = setInterval(function() {
                if (seconds == 0) {
                    if (minutes == 0) {
                        clearInterval(timerInterval);
                        submitForm();
                        return;
                    } else {
                        minutes--;
                        seconds = 59;
                    }
                } else {
                    seconds--;
                }
                timerDisplay.innerHTML = 'Time Remaining: ' + minutes + ' minutes ' + seconds + ' seconds';
            }, 1000);
        }

        function submitForm() {

            clearInterval(timerInterval);
            document.getElementById("quiz-form").submit();

        }
    </script>

    <div id="quiz-container">
        <div id="timer"></div>
        <?php

        $submited = false;
        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "secumcq";

        $conn = new mysqli($servername, $username, $password, $database);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        if (isset($_GET["id"])) {
            $id = $_GET["id"];
        } else {
            echo "No quiz id found.";
            exit;
        }


        $timeLimit = 600;


        if (!isset($_SESSION['start_time'])) {
            $_SESSION['start_time'] = time();
        }


        $elapsedTime = time() - $_SESSION['start_time'];
        $timeLeft = $timeLimit - $elapsedTime;


        if ($timeLeft <= 0) {
            echo "Time Taken : 30 seconds";
            unset($_SESSION['start_time']);
        }


        $minutes = floor($timeLeft / 60);
        $seconds = $timeLeft % 60;
        if ($_SERVER["REQUEST_METHOD"] != "POST") {
            if ($timeLeft > 0) {
                echo "<script>updateTimer($minutes, $seconds);</script>";
            }
        } else {

            if ($timeLeft > 0) {
                $_SESSION["time_taken"]= time() - $_SESSION['start_time'] ;
                unset($_SESSION['start_time']);
            }
        }
        ?>


        <?php
         $skiped=0;

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $submited = true;

            $submitted_answers = isset($_POST['answer']) ? $_POST['answer'] : [];


            $sql = "SELECT ID, ANSWER, EXP FROM question WHERE quiz_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();

            $questions = array();

            while ($row = $result->fetch_assoc()) {
                $correct_answer = $row["ANSWER"];
                $explanation = $row["EXP"];
                if (!isset($submitted_answers[$row['ID']])) {
                    $submitted_answers[$row['ID']] = 0;
                    $skiped++;
                }
                if (isset($submitted_answers[$row['ID']]) && $submitted_answers[$row['ID']] == $correct_answer&&$submitted_answers[$row['ID']]!=0) {
                    $questions[$row['ID']] = "correct";
                } 
                else if($submitted_answers[$row['ID']]==0)
                {
                    $questions[$row['ID']] = "skiped";
                }
                else {
                    $questions[$row['ID']] = "incorrect";
                }
            }

            $user_score = array_filter($questions, function ($value) {
                return $value == "correct";
            });
            $in_score = array_filter($questions, function ($value) {
                return $value == "incorrect";
            });

            $quiz_score = count($user_score);
            $incorrect=count($in_score);
            $tot=$quiz_score+$skiped+$incorrect;
            $per=($quiz_score/$tot)*100;
            $user_id = $_SESSION['userid'];
         
            $_SESSION["quiz_score"]=$quiz_score;
            $_SESSION["skipped"]=$skiped;
            $_SESSION["incorrect"]=$incorrect;
            $_SESSION["tot"]=$tot;
            $_SESSION["per"]=$per;
            $_SESSION["submitted_answers"]=$submitted_answers;
            $_SESSION["question"]=$questions;
            $_SESSION["quizid"]=$id;

            $checkalreadyexist = "SELECT * FROM leader WHERE user_id='$user_id' AND quiz_id='$id'";
            // $r = mysqli_query($conn, $checkalreadyexist);
            // $already = "SELECT * FROM leaderboard WHERE user_id='$user_id' AND quiz_id='$id'";
            // $a = mysqli_num_rows(mysqli_query($conn, $already));
            // if ($a == 0) {
            //     $leader = "INSERT INTO leaderboard (quiz_id,user_id,name,score) VALUES('$id','$user_id','$name','$quiz_score')";
            //     mysqli_query($conn, $leader);
            // } else {
            //     $leader = "UPDATE leaderboard SET score='$quiz_score' WHERE user_id='$user_id' AND quiz_id='$id'";
            //     mysqli_query($conn, $leader);
            // }
            // if ($r->num_rows == 0) {
            //     $usern=$_SESSION["username"];
            //     $leader_overall = "INSERT INTO leader(quiz_id, name,user_id, score) VALUES ('$id', '$usern','$user_id', '$quiz_score')";
            //     mysqli_query($conn, $leader_overall);
            // }
            echo "<script>location.href='score.php'</script";
        }
            
            
        if ($_SERVER["REQUEST_METHOD"] != "POST") {
            $sql = "SELECT id, question, option1, option2, option3, option4 FROM question WHERE quiz_id = $id";
            $result = mysqli_query($conn, $sql);

            
            $questions = [];
            while ($row = $result->fetch_assoc()) {
                $questions[] = $row;
            }

           
            shuffle($questions);

            if (count($questions) > 0) {
                echo "<h2>Quiz Questions</h2>";
                echo "<form method='post' id=quiz-form>";
                foreach ($questions as $row) {
                    echo "<div class='question'>";
                    echo "<p><strong>Question:</strong> " . $row["question"] . "</p>";
                    echo "<div class='options'>";
                    for ($i = 1; $i <= 4; $i++) {
                        $option = $row["option$i"];
                        echo "<label><input type='radio' name='answer[" . $row['id'] . "]' value='$i'>$option</label>";
                    }
                    echo "</div>";
                    echo "</div>";
                }
                echo "<button type='submit' class='submit-btn' onclick=submitForm()>Submit Answers</button>";
                echo "</form>";
            } else {
                echo "No questions found for this quiz.";
            }
        }

        $conn->close();
        ?>

    </div>

 <center>
  <button onclick="goBack()" class="button">Go Back</button>
</center>
  <script>
    function goBack() {
      window.history.back();
    }
  </script>   
</body>

</html>