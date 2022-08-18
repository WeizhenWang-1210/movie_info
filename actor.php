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

if ( isset($_GET['id']) )
{
   //  echo "Get ID: " . $_GET["id"] . "<br>";
    
    // sql語法存在變數中
    $id = $_GET['id'];
    $actorsql = "SELECT CONCAT(first,' ',last) as Name, sex as Sex, dob as 'Date of Birth', dod as 'Date of Death' FROM Actor WHERE id = ".$id;
    // echo $actorsql."<br>";

    // 用mysqli_query方法執行(sql語法)將結果存在變數中
    $result = mysqli_query($link, $actorsql);
    
    $datas = array();
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
    }
    // 釋放資料庫查到的記憶體
    mysqli_free_result($result);
    
   //  print_r($datas);
    
    if (sizeof($datas) > 0) 
    {
        $name = $datas[0]['Name'];
        // echo "<br>$name<br>";

        $sex = $datas[0]['Sex'];
      //   echo "<br>$sex<br>";

        $dob = $datas[0]['Date of Birth'];
      //   echo "<br>$dob<br>";

        $dod = $datas[0]['Date of Death'];
      //   echo "<br>$dod<br>";
    }
}
    
}

if ( isset($_GET['id']) )
{
   //  echo "Get ID: " . $_GET["id"] . "<br>";
    
    // sql語法存在變數中
    $id = $_GET['id'];
    $moviesql = "SELECT role, title as 'Movie Title',mid FROM MovieActor MA, Movie M WHERE MA.mid=M.id AND aid = ".$id;
    // echo $moviesql."<br>";


    // 用mysqli_query方法執行(sql語法)將結果存在變數中
    $resultm = mysqli_query($link, $moviesql);
    
    $datasmovie = array();
    if ($resultm) {
    // mysqli_num_rows方法可以回傳我們結果總共有幾筆資料
    if (mysqli_num_rows($resultm)>0) {
        // 取得大於0代表有資料
        // while迴圈會根據資料數量，決定跑的次數
        // mysqli_fetch_assoc方法可取得一筆值
        while ($row = mysqli_fetch_assoc($resultm)) {
            // 每跑一次迴圈就抓一筆值，最後放進data陣列中
            $datasmovie[] = $row;
        }
    }
    // 釋放資料庫查到的記憶體
    mysqli_free_result($resultm);
    
    // print_r($datasmovie);
    
    }
}
    

?>

  <div class="container">

    <!-- <div>
      <h1>Actor Information Page : <h1>
    </div>

    <div> -->
    <!-- <form action="/www/actor.php" method="get">
        ID:<br>
        <input type="text" name="id"><br>
        Name:<br> -->
    <!-- <input type="text" name="name"><br>
        Sex:<br>
        <input type="text" name="email"><br><br>
        <input value="Submit" type="submit"> -->
    </form>

    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
      <hr>
      <h2><b>Actor Information is:</b></h2>
      <div align="center">
        <table style="border:3px #cccccc solid;" cellpadding="10" border='1'>
          <thead>
            <tr>
              <th>Name</th>
              <th>Sex</th>
              <th>Date of Birth</th>
              <th>Date of Death</th>
            </tr>
          </thead>
          <tbody>
            <?php if (isset($name)) {?>
            <tr>
              <td><?php echo $name; ?></td>
              <td><?php echo $sex; ?></td>
              <td><?php echo $dob; ?></td>
              <td><?php echo empty($dod)? 'Still alive' : $dod; ?></td>
            </tr>
            <?php } ?>
          </tbody>

        </table>
      </div>
      <hr>
      <h2><b>Actor's Movies and Role:</b></h2>
      <div align="center">
        <table style="border:3px #cccccc solid;" cellpadding="10" border='1'>
          <thead>
            <tr>
              <th>Role</th>
              <th>Movie Title</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <?php if (isset($id)) {?>
              <td><?php $itemsm = count($datasmovie);
                  for ($i = 0 ; $i < $itemsm; $i++){
                  echo '"'.$datasmovie[$i]['role'].'"'."<br>";
                  } ?></td>
              <td><?php $items = count($datasmovie);
                  for ($i = 0 ; $i < $items; $i++){
                  echo '<a href="./movie.php?id='.$datasmovie[$i]['mid'].'">'.$datasmovie[$i]['Movie Title']."<br>";
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