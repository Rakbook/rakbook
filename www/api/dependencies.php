<?php
require_once('../dbutils.php');
function respond($resp='', $code=200)
{
	if($resp===''&&$code===200) $code=204;
	http_response_code($code);
	echo $resp;
	die();
}

function getToken()
{
	if(!isset($_SERVER['HTTP_TOKEN']))
    {
        return "";
    }
    return $_SERVER['HTTP_TOKEN'];
}

function deletetoken(string $token)
{
	$explodedtoken=explode(':', $token);
    $selector=$explodedtoken[0];
    $validator=$explodedtoken[1];
	
	easyQuery('DELETE FROM authtokens WHERE selector=?', 's', $selector);
}

function getuseridfromtoken(string $token)
{
    $explodedtoken=explode(':', $token);
    $selector=$explodedtoken[0];
    $validator=$explodedtoken[1];
    
    $result=easyQuery('SELECT * FROM authtokens WHERE selector=?  AND expires >= NOW()', "s", $selector);
		
    if($result->num_rows>0)
    {
        $row=$result->fetch_assoc();
        if(hash_equals($row['validatorhash'], hash('sha256', $validator)))
        {
            return $row['userid']; 
        }else
        {
            easyQuery('DELETE FROM authtokens WHERE id=?', "i", $row['id']);
        }
    }
    
    return 0;
}

function getuseridfromcredentials(string $login, string $pass)
{
	$result=easyQuery("SELECT id, user_name, user_pass, activated FROM users WHERE user_name=?", "s", $login);

    if($result->num_rows>0)
    {

        $row=$result->fetch_assoc();

        if(password_verify($pass, $row['user_pass']))
        {
            if($row['activated']==1)
            {
				$time = isset($_POST['time']) ? intval($_POST['time']) : 10;
                return $row['id'];
            }else
            {
                respond('Użytkownik nie został aktywowany', 403);
            }
		}
    }
	respond('Taka kombinacja danych logowania nie istnieje w bazie danych', 403);
    
}

function validatetokenoptional()
{
	if(!isset($_SERVER['HTTP_TOKEN']))
    {
        return 0;
    }
    $token=$_SERVER['HTTP_TOKEN'];
    
    $id=getuseridfromtoken($token);
    return $id;
}

function validatetoken()
{
	if(!isset($_SERVER['HTTP_TOKEN']))
    {
		if(isset($_SERVER['PHP_AUTH_USER'])&&isset($_SERVER['PHP_AUTH_PW']))
		{
			return getuseridfromcredentials($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']);
		}else respond('Authtoken required', 403);
    }
    $id=validatetokenoptional();
    if($id>0)
    {
        return $id;
    }else
    {
        respond('Authtoken invalid', 403);
    }
}

class User
{
    public $id;
    public $name;
    public $color;
    
    public $nr_dziennik;
    public $activated;
    public $isAdmin;
    public $isRedaktor;
    public $RakCoins;
    
    function __construct(int $id)
    {
        $this->id=$id;
    }
    
    function getId()
    {
        return $this->id;
    }
    
    function getInfo()
    {
        $fields='user_name, color, user_nrwdzienniku, activated, isadmin, redaktor, RakCoins';
        
        $query='SELECT '.$fields.' FROM users WHERE id=?';
        $result=easyQuery($query, 'i', $this->id);
        if($result->num_rows>0)
        {
            $row=$result->fetch_assoc();
            
            $this->name=$row['user_name'];
            $this->color=$row['color'];
			$this->nr_dziennik=$row['user_nrwdzienniku'];
            $this->activated=$row['activated'];
            $this->isAdmin=$row['isadmin'];
            $this->isRedaktor=$row['redaktor'];
            $this->RakCoins=$row['RakCoins'];
            return true;
        }else
        {
            return false;
        }
    }
	
	function update($obj)
	{
		$columns=array();
		$types=0;
		$properties=array();
		if(isset($obj->activated))
		{
			$this->activated=intval(boolval($obj->activated));
			$columns[]='activated=?';
			++$types;
			$properties[]=$this->activated;
		}
		if(isset($obj->isAdmin))
		{
			$this->isAdmin=intval(boolval($obj->isAdmin));
			$columns[]='isadmin=?';
			++$types;
			$properties[]=$this->isAdmin;
		}
		if(isset($obj->isRedaktor))
		{
			$this->isRedaktor=intval(boolval($obj->isRedaktor));
			$columns[]='redaktor=?';
			++$types;
			$properties[]=$this->isRedaktor;
		}
		$properties[]=$this->id;
		easyQuery('UPDATE users SET '.implode(',', $columns).' WHERE id=?', str_repeat('i', $types).'i', ...$properties);
	}
}

class BasicUser
{
    public $id;
    public $name;
    public $color;
    
    function __construct(User $usr)
    {
        $this->id=$usr->getId();
        $this->name=$usr->name;
        $this->color=$usr->color;
    }
    
    function getId()
    {
        return $this->id;
    }
}

?>
