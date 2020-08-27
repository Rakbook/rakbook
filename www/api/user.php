<?php
require_once( 'dependencies.php' );

class RegistrationUser
{
	public $login;
	public $nr;
	public $pass;

	function __construct( string $login, int $nr, string $pass ) {
		if ( isset( $login ) )$this->login = $login;
		if ( isset( $nr ) )$this->nr = intval($nr);
		if ( isset( $pass ) )$this->pass = $pass;
	}

	function register()
	{
		if ( isset( $this->login, $this->nr, $this->pass ) )
		{
			$result = easyQuery( 'SELECT id FROM users WHERE user_name=?', 's', $this->login );
			if($result->num_rows>0)
			{
				respond('login jest zajęty', 409);
			}
			
			$minusernamelength=3;
			$maxusernamelength=10;

			if(strlen($this->login)<$minusernamelength||strlen($this->login)>$maxusernamelength)
			{
				respond('login musi mieć od '.$minusernamelength.' do '.$maxusernamelength.' znaków', 409);
			}
			
			$dzienniknum=intval($this->nr);
			$maxdzienniknum=33;
			if($dzienniknum<1||$dzienniknum>$maxdzienniknum)
			{
				if($dzienniknum!=41) respond('podaj prawidłowy numer w dzienniku', 409);
			}
			
			$result=easyQuery('SELECT id FROM users WHERE user_nrwdzienniku=?', 'i', $this->nr);
			if($result->num_rows>0)
			{
				respond('numer w dzienniku jest zajęty', 409);
			}
			
			$minpasslength=8;
			if(strlen($this->pass)<$minpasslength)
			{
				respond('hasło musi mieć co najmniej '.$minpasslength.' znaków', 409);
			}
			
			$passhash=password_hash($this->pass, PASSWORD_DEFAULT);
			
			easyQuery('INSERT INTO users (user_name, user_pass, user_nrwdzienniku) VALUES(?, ?, ?)', 'ssi', $this->login, $passhash, $this->nr);
			
			$to = "wojtek.j.malecha@gmail.com, mikolaj.juda@gmail.com";
			$topic = "Nowy użytkownik!";
			$headers = 'From: donotreply@rakbook.pl';
			$content = "Nowy użytkownik chce dołączyć do Rakbooka! Jego nazwa: ".$this->login.". Jego numer w dzienniku: ".$this->nr; 
			mail($to, $topic, $content, $headers);
			
		} else
		{
			respond('not all registration parameters present', 422);
		}
	}
}

if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
	if(isset( $_SERVER[ "CONTENT_TYPE" ] ))
	{
		if($_SERVER[ "CONTENT_TYPE" ] == 'application/x-www-form-urlencoded')
		{
			if(is_string($_POST['login'])&&is_string($_POST['password'])&&is_numeric($_POST['nr']))
			{
				$reg = new RegistrationUser( $_POST['login'], $_POST['nr'], $_POST['password'] );
				$reg->register();
				respond();
			}else
			{
				respond('registration data incorrect', 422);
			}
			
		}
		else if ( isset( $_SERVER[ "CONTENT_TYPE" ] ) && $_SERVER[ "CONTENT_TYPE" ] == 'application/json' )
		{
			$inp = json_decode( file_get_contents( 'php://input' ) );
			if ( is_null( $inp ) ) {
				respond('json decoding failed', 400);
			} else
			{
				$user = new User( validatetoken() );
				$user->getInfo();
				if($user->isAdmin)
				{
					if(!is_array($inp))
					{
						$inp=array($inp);
					}

					foreach($inp as &$obj)
					{
						$usr=new User($obj->id);
						$usr->update($obj);
					}
					respond();
				}else
				{
					respond('admin privilages required', 403);
				}
				
			}
		}
	}else
	{
		respond('wtf are you trying to do?', 400);
	}
	
}
else if($_SERVER['REQUEST_METHOD'] === 'GET')
{
	$user = new User( validatetoken() );
	$user->getInfo();

	if ( isset( $_GET[ 'id' ] ) ) {
		if ( is_array( $_GET[ 'id' ] ) ) {
			$ids = array_map( 'intval', $_GET[ 'id' ] );

			$questionmarks = implode( ',', array_fill( 0, count( $ids ), '?' ) );

			$types = str_repeat( 'i', count( $ids ) );

			$query = 'SELECT * FROM users WHERE id IN (' . $questionmarks . ') ORDER BY FIELD(id, ' . $questionmarks . ')';

			$result = easyQuery( $query, $types . $types, ... array_merge( $ids, $ids ) );

			$requested = array();

			while ( $row = $result->fetch_assoc() ) {
				$usr = new User( $row[ 'id' ] );
				$usr->name = $row[ 'user_name' ];
				$usr->color = $row[ 'color' ];
				$usr->nr_dziennik = $row[ 'user_nrwdzienniku' ];
				$usr->activated = $row[ 'activated' ];
				$usr->isAdmin = $row[ 'isadmin' ];
				$usr->isRedaktor = $row[ 'redaktor' ];
				$usr->RakCoins = $row[ 'RakCoins' ];

				if ( !$user->isAdmin && $usr->getId() != $user->getId() )$usr = new BasicUser( $usr );

				$requested[] = $usr;
			}
			respond(json_encode($requested));

		} else {
			$requested = new User( intval( $_GET[ 'id' ] ) );
			if ( $requested->getInfo() ) {

				if ( !$user->isAdmin && $requested->getId() != $user->getId() ) $requested = new BasicUser( $requested );

				respond(json_encode($requested));
			} else {
				respond('user not found', 404);
			}
		}

	} else {
		respond(json_encode($user));
	}
}


?>
