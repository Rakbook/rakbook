<?php
//file_get_contents('https://nodzu.herokuapp.com/');
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://nodzu.herokuapp.com/");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$output = curl_exec($ch);
curl_close($ch);
echo $output;
?>
