<?php
require_once "db.php";

$db = new mysqli('localhost', 'cs143', '', 'class_db');
                if ($db->connect_errno > 0) { 
                    die('Unable to connect to database [' . $db->connect_error . ']'); 
                } 


if ( isset($_GET['id']) )
{
    $id = $_GET['id'];
    $moviesql = "SELECT title, year, company, rating, genre FROM Movie M, MovieGenre MG WHERE M.id=MG.mid AND M.id = $id";
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
if ( isset($_GET['id']) )
{
    $id = $_GET['id'];
    $actorsql = "SELECT CONCAT(first,' ',last) as Name, role as Role, aid FROM MovieActor MA, Actor A WHERE A.id=MA.aid AND MA.mid = $id";
    // echo $actorsql."<br>";

    $result = mysqli_query($link, $actorsql);
    
    $datas = array();
    if ($result) {
    if (mysqli_num_rows($result)>0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $datas[] = $row;
        }
    }
    mysqli_free_result($result);
    
    // print_r($datas);
    
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <title>CS143 Project 2</title>

  <!-- Bootstrap -->
  <link href="./bootstrap.min.css" rel="stylesheet">
  <link href="./project1c.css" rel="stylesheet">
</head>

<body>
  <div class="container">
    <div class="row">
      <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
        <h3><b> Movie Information Page :</b></h3>
        <hr>
        <h4><b> Movie Information is:</b></h4>
        <p>
          Title is:
          <?php echo $title.'('.$year.')'; ?><br>
          Producer:
          <?php echo $company; ?><br>
          MPAA Rating:
          <?php echo $rating; ?><br>
          Genre:
          <?php echo $genre; ?><br>
        </p>
        <hr>
        <h4><b> Actors in this Movie:</b></h4>
        <div align="left">
          <table style="border:3px #cccccc solid;" cellpadding="10" border='1'>
            <thead>
              <tr>
                <th>Name</th>
                <th>Role</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <?php if (isset($id)) {?>
                <td><?php $item = count($datas);
                  for ($i = 0 ; $i < $item; $i++){
                  echo '<a href="./actor.php?id='.$datas[$i]['aid'].'">'.$datas[$i]['Name']."<br>";
                  } ?></td>
                <td><?php $item = count($datas);
                  for ($i = 0 ; $i < $item; $i++){
                  echo '"'.$datas[$i]['Role'].'"'."<br>";
                  } ?></td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
        <hr>
        <h4><b>User Review :</b></h4>
        <p>
        <ul>
          <?php if(isset($_GET['id']) && isset($title)){
                $id_searched = $_GET['id'];
                $reviewq = "SELECT AVG(rating) AS a FROM Review WHERE mid = $id_searched";
                $reviews = $db->query($reviewq);
        
                    while($row = $reviews->fetch_assoc()){
                        $avg = $row['a'];
                        echo "---[Reviews of &lt; $title &gt; | Average Rating $avg]---";
                    }
            } 
            ?>

        </ul>
        </p>
        </p>
        <p>
          <?php if(isset($_GET['id']))
        {
            $id = $_GET['id'];
            echo "<a href = \"review.php?id=$id\">add comment to this movie<a>";
        } 
        ?>
          <hr>
        <h4><b>Comment detials shown below :</b></h4>
        <p>
          <?php
            if(isset($_GET['id'])){
                $id_searched = $_GET['id'];
                $reviewq = "SELECT * FROM Review WHERE mid = $id_searched";
                $reviews = $db->query($reviewq);
                if( mysqli_num_rows($reviews) == 0){
                    echo "No current reviews";
                }
                else{
                    while($row = $reviews->fetch_assoc()){
                        $reviewername = $row['name'];
                        $reviewertime = $row['time'];
                        $reviewerrating = $row['rating'];
                        $reviewercomment = $row['comment'];
                        echo "<li><p> Reviewer \"$reviewername\" rated $reviewerrating <$reviewertime> </p>
                             <div> <p> $reviewercomment</p> </div></li>
                             ";
                    }
                }
            }
            ?>
        </p>


</body>