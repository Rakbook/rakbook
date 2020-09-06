<?php

require_once('dbutils.php');

function printcat(string $cat){
		// tutaj coś jeśli data > niż $data, to wyświetl
    $result=easyQuery('SELECT content, link FROM zadania WHERE category=?', 's', $cat);

    while($row=$result->fetch_assoc()){
        echo '<a target="blank" href="'.$row['link'].'">• '.$row['content'].'</a>';
    }
}

function countcat(string $cat){
		// tutaj coś jeśli data > niż $data, to policz
    $result=easyQuery('SELECT COUNT(id) AS count FROM zadania WHERE category=?', 's', $cat);
    return $result->fetch_assoc()['count'];
}

if(isset($_POST['date'])){
	$date = $_POST['date'];
}
else{
	$date = strtotime("last monday", strtotime("tomorrow"));
}

?>

<script> var date = <?php echo $date; ?> </script>
<div class="navPanel"><div class="buttonBar">
  <div class="homeworkButton small" onclick="location.href='dodajZadanieDomowe.php'">+</div>
  <div class="homeworkButton small" id="info" style="font-family: serif;">i</div>
  <div class="homeworkButton big">
    <span id="previous">⮜</span>
    <span><?php echo '<script> console.log("wczytałem dla daty = '.date("d.m", $date).'");</script>'; echo date("d.m", $date); $date = strtotime("+4 days", $date); echo " / "; echo date("d.m", $date); ?> </span>
    <span id="next">⮞</span></div>
</div></div>

<div class="titlePanel">Zadania Domowe</div>
<div class="homeworkRow">
  <div class="dayPanel green"><div class="day">Dzisiaj</div><div class="number"><div class="numberBackground"><?php echo countcat('MatematykaAM'); ?></div></div></div>
  <div class="dayPanel blue"><div class="day">Jutro</div><div class="number"><div class="numberBackground"><?php echo countcat('MatematykaAM'); ?></div></div></div>
</div>
<div class="homeworkRow">
  <div class="dayPanel red"><div class="day">Ten Tydzień</div><div class="number"><div class="numberBackground"><?php echo countcat('MatematykaAM'); ?></div></div></div>
  <div class="dayPanel yellow"><div class="day">Zadania Długoterminowe</div><div class="number"><div class="numberBackground"><?php echo countcat('MatematykaAM'); ?></div></div></div>
</div>
<div id="dayPopup" class="green"><div class="dayPopupBackground"><div id="homeworkTitle"></div><div id="homeworkContent"><div id="homeworkContent"><?php printcat('MatematykaAM'); ?></div><div id="close">Zamknij mnie</div></div></div>
</div>

<script> onLoad(); </script>
