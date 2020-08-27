<?php
require_once('dependencies.php');

function getnewtoken(int $id, int $t=10)
{
	$max_time=3600*24*7;
	if($t>$max_time) $t=$max_time;
    if($t<=0)$time=10;
	
	$selector=bin2hex(random_bytes(9));
	$validator=bin2hex(random_bytes(32));
	$validatorhash=hash('sha256', $validator);
	$tokenval=$selector.':'.$validator;
	easyQuery("INSERT INTO authtokens (userid, selector, validatorhash, expires) VALUES (?, ?, ?, DATE_ADD(NOW(), INTERVAL ? SECOND))", "issi", $id, $selector, $validatorhash, $t);
	return $tokenval;
}

if(isset($_GET['logout']))
{
	$token=getToken();
	if(validatetokenoptional()>0)
	{
		deletetoken($token);
		respond();
	}else
	{
		if(isset($_SERVER['HTTP_TOKEN'])) respond('token invalid', 403);
		else respond('token required', 400);
	}
}

if(!isset($_POST['login'])||!isset($_POST['password']))
{
	$id=validatetokenoptional();
	if($id>0)
	{
		$time = isset($_POST['time']) ? intval($_POST['time']) : 10;
		$token=getnewtoken($id, $time);
		deletetoken($_SERVER['HTTP_TOKEN']);
		respond(getnewtoken($id, $time));
		
	}else
	{
		if(isset($_SERVER['HTTP_TOKEN'])) respond('token invalid', 403);
		else respond('wtf are you trying to do?', 400);
	}
}else
{
    
        
    $login=$_POST['login'];
    $password=$_POST['password'];

    $result=easyQuery("SELECT id, user_name, user_pass, activated FROM users WHERE user_name=?", "s", $login);

    if($result->num_rows>0)
    {

        $row=$result->fetch_assoc();

        if(password_verify($password, $row['user_pass']))
        {
            if($row['activated']==1)
            {
				$time = isset($_POST['time']) ? intval($_POST['time']) : 10;
                respond(getnewtoken($row['id'], $time));
            }else
            {
                respond('Użytkownik nie został aktywowany', 403);
            }
        }else
        {
            respond('Taka kombinacja danych logowania nie istnieje w bazie danych', 403);
        }

    }else
    {
        respond('Taka kombinacja danych logowania nie istnieje w bazie danych', 403);
    }
}

?>