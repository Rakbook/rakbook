<?php
  if(isset($_POST['value'])){
    if(isset($_POST['keyword'])){
      session_start();
      require_once("dbutils.php");
      include("requestuserdata.php");

      $value = $_POST['value'];

      if($value == "new"){
        $sortstyle = "id";
        $sortdirection = "DESC";
      }
      else if($value == "best"){
        $sortstyle = "likes";
        $sortdirection = "DESC";
      }
      else if($value == "old"){
        $sortstyle = "id";
        $sortdirection = "ASC";
      }
      else if($value == "worst"){
        $sortstyle = "likes";
        $sortdirection = "ASC";
      }
      else if($value == "author"){
        $sortstyle = "autor";
        $sortdirection = "ASC";
      }
      else{ // default
        $sortstyle = "id";
        $sortdirection = "DESC";
      }

      $keyword = $_POST['keyword'];
    }
  }
  else{
    $sortstyle = "id";
    $sortdirection = "DESC";
    $keyword = "";
  }

  $query = " SELECT cytaty.id, cytaty.autor, cytaty.cytat, cytaty.uploaderid, IFNULL(SUM(quotelikes.value), 0) AS likes,
             IFNULL((SELECT quotelikes.value FROM quotelikes WHERE quotelikes.personid=? AND quotelikes.quoteid=cytaty.id), 0) AS currentuserlikevalue
             FROM cytaty LEFT JOIN quotelikes ON cytaty.id = quotelikes.quoteid
             WHERE cytaty.autor LIKE '%{$keyword}%' OR cytaty.cytat LIKE '%{$keyword}%' GROUP BY cytaty.id ORDER BY ".$sortstyle." ".$sortdirection;
  $colors = [
    1 => "red",
    2 => "yellow",
    3 => "blue",
    4 => "green",

  ];

  require_once('generatelikebuttons.php');
  $result = easyQuery($query, "i", $_SESSION['userid']);

  if(($_SESSION['redaktor']==1)||($_SESSION['userisadmin']==1)){
    echo "<form method=\"post\" action=\"cytaty.php\" name=\"remove-form\">
    <input type=\"hidden\" name=\"postToRemove\" value=\"0\" id=\"remove\"/></form>";

    echo '<script>
      function popup(rowid){
        var r = confirm("usunąć cytat?");
        if(r == true){
          document.getElementById("remove").value = rowid;
          document.forms["remove-form"].submit();
        }
        else{
          document.getElementById("remove").value = 0;
        }
      }
    </script>';
  }

  if ($result->num_rows > 0){
    while($row = $result->fetch_assoc()){
      #$color = $colors[rand( 1 , 4)];

      if($row["likes"]>7)
      {
        $color = "green";
      }elseif ($row["likes"]>3) {
        $color = "blue";
      }elseif ($row["likes"]>0) {
        $color = "yellow";
      }else{
        $color = "red";
      }

      echo'
        <div class="mainPanel '.$color.' ">
          <div class="leftPanel '.$color.' " data-quoteid="'.$row['id'].'"><div class="scoreBackground">' .$row["likes"]. '</div>';
          if($row['uploaderid']!=$_SESSION['userid']){
            echo '<div class="votesBackground">';
            echo getlikebuttons($row['id'], $row['currentuserlikevalue']);
            echo '</div>';
          }
          echo '</div><div class="rightPanel '.$color.' "><div class="quoteContent">'.$row['cytat'].'</div><div class="authorBar">~ '.$row['autor'];
          if(($_SESSION['redaktor']==1)||($_SESSION['userisadmin']==1)){
            echo '<img src="images/bin.svg" class="bin" onclick="popup('.$row["id"].')" />';
          }
      echo '</div></div></div>';
  }
  echo '<script> callMe(); setMobileLayout(); </script>';
}
?>
