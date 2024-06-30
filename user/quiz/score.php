<?php
include('../../db.php');
$f=false;
if(isset($_GET['score'])&&isset($_GET['id']))
{
    $score=$_GET['score'];
    $id=$_GET['id'];
    
}
else
{
    $score=0;
    $id=0;
}
$sql="SELECT * FROM score WHERE QUIZ_ID='$id'";
$result=mysqli_query($db,$sql);

$score_level="";
if(mysqli_num_rows($result)>0)
{   $row=$result->fetch_assoc();
    $total=$row['TOTAL']*4;
    $percentage=($score/$total)*100;
    if($percentage>=80)
    {
        $score_level="SEVERE";
    }
    else if($percentage>=60)
    {
        $score_level="MEDIUM";
    }
    
    
    else
    {
        $score_level="NORMAL";
    }
    
    $score_page="SELECT *  FROM score_page WHERE QUIZ_ID='$id'";
    $result_page=mysqli_query($db,$score_page);
    $f=true;
    
    
}
else{
    echo "0 results";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Emotional Assessment Results</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background: linear-gradient(to right, #00bcd4, #9c27b0);
            color: white;
        }
  
        #animated-text {
            position: fixed;
            bottom: 20px;
            right: 20px;
            padding: 10px;
            background-color: #3498db;
            color: #ffffff;
            border-radius: 5px;
            font-size: 16px;
            animation: slideIn 1s ease-out;
            opacity: 0;
            animation-fill-mode: forwards;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(100%);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
p{font-size:20px;}
h1{color:red;}
h2{color:black;}
p1{font-family: 'Pacifico', cursive, 'Arial', sans-serif;font-size:20px;}
        header {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        main {
            text-align: center;
        }

        .assessment-score {
            font-size: 36px;
            margin-bottom: 20px;
        }

        .tips-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #DDD0C8;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            color: #333;
            margin-top: 20px;
        }

        .tip {
            margin-bottom: 15px;
            text-align: left;
            font-size: 18px;
            line-height: 1.6;
        }

        .tip li {
            list-style-type: disc;
            margin-left: 20px;
        }
    </style>
</head>
<body>
    

    <main>

        <div class="assessment-score">
            <br>
            <?php echo $score_level;?>
            Your Anxiety Assessment Score: <?php echo $score." (".$score_level.")";?>
        </div>
        <?php 
        if($f)
        {
            $row_page=$result_page->fetch_assoc();
            echo "<div class='tips-container'>";
            echo "<h1>Here are some tips to help you manage your anxiety</h1>";
            echo "<ul class='tip'>";
            $sentences = explode('.', $row_page[$score_level]);
            foreach($sentences as $sentence) {
                echo "<li>".$sentence."</li>";
            }
            
            echo "</ul>";
            echo "</div>";
        }
        ?>
        
    </main>
</body>
</html>
