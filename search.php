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

  <?php
require_once "db.php";

if ( isset($_GET['actor']) )
{
   //  echo "Get ID: " . $_GET["id"] . "<br>";
    
    // sql語法存在變數中
    $actor = $_GET['actor'];
    $parsed = explode(' ',$actor);//parse substrings seperated by ' ' into arrays

    $actorqueries = array();
    for($i = 0; $i < count($parsed); $i++){
      $substring = $parsed[$i];
      $actorqueries[] = "SELECT CONCAT(first,' ',last) AS Name, dob as 'Date of Birth', id FROM Actor WHERE first LIKE '%$substring%' OR last LIKE '%$substring%'";
    }
    //print_r($actorqueries);
    // $searchactor = preg_replace("#[^0-9a-z]#"," ",$actor);
    // echo $searchactor;
    
    
    //$actorsql = "SELECT CONCAT(first,' ',last) as Name, dob as 'Date of Birth', id FROM Actor WHERE first LIKE '%$actor%' OR last lIKE '%$actor%'";
    
    // $actorsql = "SELECT CONCAT(first,' ',last) as Name, dob as 'Date of Birth' FROM Actor WHERE first = ".$actor;
    // echo $actorsql."<br>";

    // 用mysqli_query方法執行(sql語法)將結果存在變數中

    //$result = mysqli_query($link, $actorsql);


    $datas = array();

    for($i = 0; $i < count($actorqueries); $i++)
    {
      $actorsql = $actorqueries[$i];
      $result = mysqli_query($link, $actorsql);
      if($result){
        if(mysqli_num_rows($result)>0){
          while ($row = mysqli_fetch_assoc($result)) {
            $datas[] = $row;
          }
        }
      }
      mysqli_free_result($result);
    }
    /*
    if ($result) {
    // mysqli_num_rows方法可以回傳我們結果總共有幾筆資料
    if (mysqli_num_rows($result)>0) {
        // 取得大於0代表有資料
        // while迴圈會根據資料數量，決定跑的次數
        // mysqli_fetch_assoc方法可取得一筆值
        while ($row = mysqli_fetch_assoc($result)) {
            // 每跑一次迴圈就抓一筆值，最後放進data陣列中
            $datas[] = $row;
        }
    }*/

    // 釋放資料庫查到的記憶體

    //mysqli_free_result($result);
    
    //print_r($datas);    
}

if ( isset($_GET['movie']) )
{
   //  echo "Get ID: " . $_GET["id"] . "<br>";
    
    // sql語法存在變數中
    $movie = $_GET['movie'];
    $parsed = explode(' ',$movie);
    $moviequeries = array();
    for($i = 0; $i < count($parsed); $i++){
      $substring = $parsed[$i];
      $moviequeries[] = "SELECT title,year,id FROM Movie WHERE title LIKE '%$substring%'";
    }
    // $searchmovie = preg_replace("#[^0-9a-z]#i","",$movie);
    // $moviesql = "SELECT title,year,id FROM Movie WHERE title LIKE '%$movie%'";
    // $actorsql = "SELECT CONCAT(first,' ',last) as Name, dob as 'Date of Birth' FROM Actor WHERE first = ".$actor;
    // echo $moviesql."<br>";

    // 用mysqli_query方法執行(sql語法)將結果存在變數中
    //$resultmovie = mysqli_query($link, $moviesql);

    $datasmovie = array();
    for($i = 0; $i < count($moviequeries); $i++){
      $moviesql = $moviequeries[$i];
      $resultmovie = mysqli_query($link, $moviesql);
      if($resultmovie){
        if(mysqli_num_rows($resultmovie)>0){
          while ($row = mysqli_fetch_assoc($resultmovie)) {
            $datasmovie[] = $row;
          }
        }
      }
      mysqli_free_result($resultmovie);
    }
    /*
    if ($resultmovie) {
    // mysqli_num_rows方法可以回傳我們結果總共有幾筆資料
    if (mysqli_num_rows($resultmovie)>0) {
        // 取得大於0代表有資料
        // while迴圈會根據資料數量，決定跑的次數
        // mysqli_fetch_assoc方法可取得一筆值
        while ($row = mysqli_fetch_assoc($resultmovie)) {
            // 每跑一次迴圈就抓一筆值，最後放進data陣列中
            $datasmovie[] = $row;
        }
    }*/
    // 釋放資料庫查到的記憶體
    //mysqli_free_result($resultmovie);
    
    // print_r($datasmovie);
    
    
    
}

?>

  <div class="container">

    <div align="center">
      <h1>Searching Page : <h1>
    </div>

    <div>
      <form action="./search.php" method="get">
        Actor name:
        <input type="text" name="actor" placeholder="Search Actor...">
        <input value="Submit Actor!" type="submit" style="margin-bottom:10px">
      </form>

      <form action="./search.php" method="get">
        Movie title:
        <input type="text" name="movie" placeholder="Search Movie...">
        <input value="Submit Movie!" type="submit">
      </form>
      <br>
      <?php if (isset($actor)) {?>
      <h2><b>matching Actors are: :</b></h2>
      <div>
        <hr>
        <div align="center">
          <table style="border:3px #cccccc solid;" cellpadding="10" border='1'>
            <thead>
              <tr>
                <th>Name</th>
                <th>Date of Birth</th>
              </tr>
            </thead>
            <tbody>

              <tr>
                <td><?php $items = count($datas);
                  for ($i = 0 ; $i < $items; $i++){
                  echo '<a href="./actor.php?id='.$datas[$i]['id'].'">'.$datas[$i]['Name']."<br>";
                  } ?></td>
                <td><?php $items = count($datas);
                  for ($i = 0 ; $i < $items; $i++){
                  echo '<a href=./actor.php?id='.$datas[$i]['id'].'">'.$datas[$i]['Date of Birth']."<br>";
                  } ?></td>
              </tr>
              <?php } ?>
            </tbody>

          </table>
        </div>
        <?php if (isset($movie)) {?>
        <hr>
        <h2><b>matching Movies are:</b></h2>
        <div align="center">
          <table style="border:3px #cccccc solid;" cellpadding="10" border='1'>
            <thead>
              <tr>
                <th>title</th>
                <th>year</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><?php $itemsm = count($datasmovie);
                  for ($i = 0 ; $i < $itemsm; $i++){
                  echo '<a href="./movie.php?id='.$datasmovie[$i]['id'].'">'.$datasmovie[$i]['title']."<br>";
                  } ?></td>
                <td><?php $items = count($datasmovie);
                  for ($i = 0 ; $i < $items; $i++){
                  echo '<a href="./movie.php?id='.$datasmovie[$i]['id'].'">'.$datasmovie[$i]['year']."<br>";
                  } ?></td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
        <hr>
      </div>

    </div>

</body>

</html>