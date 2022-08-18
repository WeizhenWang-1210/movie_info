<?php
require_once "db.php";

$db = new mysqli('localhost', 'cs143', '', 'class_db');
             if ($db->connect_errno > 0) { 
                 die('Unable to connect to database [' . $db->connect_error . ']'); 
             }

if ( isset($_GET['id']) )
{
    $id = $_GET['id'];
    $moviesql = "SELECT title, year, company, rating, genre FROM Movie M, MovieGenre MG WHERE M.id=MG.mid AND M.id = ".$id;
    // echo $moviesql."<br>";

    $resultm = mysqli_query($link, $moviesql);
    
    $datasmovie = array();
    if ($resultm) {
    if (mysqli_num_rows($resultm)>0) {
        while ($row = mysqli_fetch_assoc($resultm)) {
            $datasmovie[] = $row;
        }
    }
    mysqli_free_result($resultm);
    
    // print_r($datasmovie);
    
    if (sizeof($datasmovie) > 0) 
    {
        $title = $datasmovie[0]['title'];
        $year = $datasmovie[0]['year'];
        $company = $datasmovie[0]['company'];
        $rating = $datasmovie[0]['rating'];
        $genre = $datasmovie[0]['genre'];
    }
    }
}


?>

<!DOCTYPE html>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>CS143 Project 2</title>

  <link href="./bootstrap.min.css" rel="stylesheet">
  <link href="./project1c.css" rel="stylesheet">
</head>

<body align="center">
  <p>
    <?php
             $db = new mysqli('localhost', 'cs143', '', 'class_db');
             if ($db->connect_errno > 0) { 
                 die('Unable to connect to database [' . $db->connect_error . ']'); 
             }

             if (!isset($_GET['id']) && !isset($_GET['name']) && !isset($_GET['rating']) && !isset($_GET['comment'])){
                 echo "
                 <form action = \"review.php\" method = \"get\">
                    Your mid: <input type = \"text\" name = \"id\"><br>
                    <input type = \"submit\" value = \"select\">    
                </form>   
                 ";
             }
             elseif (isset($_GET['id']) && !isset($_GET['name']) && !isset($_GET['rating']) && !isset($_GET['comment'])){
                 $id = $_GET['id'];
                 echo"
                 <h2>Add new reviews here:</h2>
                 <hr>
                 <h3>Movie title is: <b>$title($year)</b></h3>
                 <form action = \"review.php\" method = \"get\">
                   <input type = \"hidden\" name = \"id\" value = $id ><br>
                   Your name: <input type = \"text\" name = \"name\"><br> 
                   <label for=\"rating\">Your rating: </label>
                    <select name=\"rating\" id=\"rating\">
                    <option value = 1>1</option>
                    <option value = 2>2</option>
                    <option value = 3>3</option>
                    <option value = 4>4</option>
                    <option value = 5>5</option>
                    </select>
                    <br>
                    Your comment: <textarea elastic rows = \"5\" cols = \"80\" name = 'comment' ></textarea><br>
                    <input type = \"submit\">    
                </form>            
                 ";
             }
             else {
                $mid = htmlspecialchars($_GET['id']);
                $name = htmlspecialchars($_GET['name']);
                $rating = htmlspecialchars($_GET['rating']);
                $comment = htmlspecialchars($_GET['comment']);
                $query = "INSERT INTO Review (name, time, mid, rating, comment) VALUES (\"$name\",NOW(),$mid,$rating,\"$comment\")";
                $rs = $db->query($query);
                if (!$rs) {
                    $errmsg = $db->error; 
                    print "Query failed: $errmsg <br>"; 
                    exit(1); 
                }else{
                    $db->commit();
                }
                echo "<p>You have submitted a form.Click to go back to the movie.</p>
                <a href = ./movie.php?id=$mid>click here <a>";
            }
            $db->close(); 
            ?>
  </P>
</body>

</html>