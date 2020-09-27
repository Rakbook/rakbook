<?php
session_start();
if(!isset($_SESSION['loggedin'])&&$_SESSION['loggedin']!=true)
{
	
	header("Location: index.php");
	die();
	
}
if(!isset($_GET['mailuid'])||!isset($_GET['partno']))
{
	die("Nie podano potrzebnych informacji do pobrania pliku");
}

require_once("mailmanagement.php");
		

$mailuid='';
$partno='';

if(is_numeric($_GET['mailuid'])) {
    
	$inbox = getInbox();
	
	$mid=imap_msgno($inbox, (int)$_GET['mailuid']);
	$partno=$_GET['partno'];
	
	$p=imap_bodystruct($inbox, $mid, $partno);
	
	$data=imap_fetchbody($inbox, $mid, $partno);
	
	if ($p->encoding==4)
		$data = quoted_printable_decode($data);
	elseif ($p->encoding==3)
		$data = base64_decode($data);
	
	$params = array();
		if ($p->ifparameters)
			foreach ($p->parameters as $x)
				$params[strtolower($x->attribute)] = $x->value;
		if ($p->ifdparameters)
			foreach ($p->dparameters as $x)
				$params[strtolower($x->attribute)] = $x->value;
	
	$filename='';
	
	if($params['filename'] || $params['name'])
		{
			$filename = $params['filename'] ? $params['filename'] : $params['name'];
			$filename= iconv_mime_decode($filename);
		}elseif($params['filename*'] || $params['name*'])
		{
			$filename=$params['filename*']?$params['filename*']:$params['name*'];
			$explodedname=explode("'", $filename);
			$filename=rawurldecode($explodedname[2]);
			$filename=iconv($explodedname[0], 'UTF-8', $filename);
		}
	
	header('Content-Description: File Transfer');
	header('Content-Type: application/octet-stream');
	header('Content-Disposition: attachment; filename="'.$filename.'"');
	header('Expires: 0');
	header('Cache-Control: must-revalidate');
	header('Pragma: public');
	header('Content-Length: ' . strlen($data));
	echo $data;
	

} else {
    die('UID musi być liczbą');
}







?>
