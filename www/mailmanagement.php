<?php
$mailserver=getenv('IMAP_MAILSERVER');
$maillogin=getenv('IMAP_MAILLOGIN');
$mailpass=getenv('IMAP_MAILPASS');

function getInbox()
{
	global $mailserver, $maillogin, $mailpass;
	$inbox = imap_open($mailserver, $maillogin, $mailpass);
		if(!$inbox)
		{
		die("Nie udało się połączyć z serwerem pocztowym");
		die("Coś się zepsuło");
		}
	return $inbox;
}

class Mail
{
	
	public $from;
	public $subject;
	public $uid;
	public $date;
	public $mainPart;
	
	function __construct(&$stream, $mid)
	{
		$this->uid=imap_uid($stream, $mid);
		$h=imap_header($stream, $mid);
		$fromInfo = $h->from[0];
		$this->from=(isset($fromInfo->mailbox) && isset($fromInfo->host)) ? $fromInfo->mailbox . '@' . $fromInfo->host : '';
		$this->subject=isset($h->subject) ? imap_mime_header_decode($h->subject)[0]->text : '';
		$this->date=isset($h->date) ? strtotime($h->date) : null;
		$s=imap_fetchstructure($stream, $mid);
		$this->mainPart = new Part($stream, $mid, $s, '');
		//print_r($s);
		//print_r(imap_body($stream, $mid));
	}
	
	function getMessage()
	{
		return $this->mainPart->getMessage();
	}

	function getAttachments()
	{
		return $this->mainPart->getAttachments();
	}
}

class Part
{
	public $html_converted_body;
	public $attachment;
	public $parts;
	public $type;
	public $subtype;
	
	function __construct(&$stream, $mid, $p, $partno='')
	{
		$this->html_converted_body=null;
		$this->attachment=null;
		$this->type=$p->type;
		$this->subtype=isset($p->subtype)?strtolower($p->subtype):null;
		$params = array();
		if (isset($p->parameters)){
			foreach ($p->parameters as $x)
				$params[strtolower($x->attribute)] = $x->value;}
		if (isset($p->dparameters))
			foreach ($p->dparameters as $x)
				$params[strtolower($x->attribute)] = $x->value;
		$filename = Attachment::getFilename($params);

		if (isset($filename))
		{
			$this->attachment = new Attachment($filename, imap_uid($stream, $mid), $partno);
		}else
		{
			if($p->type==TYPETEXT)
			{
				$this->html_converted_body=$partno==''?imap_body($stream, $mid):imap_fetchbody($stream, $mid, $partno);
				if ($p->encoding==4)
					$this->html_converted_body = quoted_printable_decode($this->html_converted_body);
				elseif ($p->encoding==3)
					$this->html_converted_body = base64_decode($this->html_converted_body);

				$this->html_converted_body=iconv($params['charset'], 'UTF-8', $this->html_converted_body);
				if(!(isset($p->subtype)&&strtolower($p->subtype)=='html'))
				{
					$this->html_converted_body=nl2br(htmlentities($this->html_converted_body));
				}
			}else
			{
				$this->html_converted_body = '<span style="color:red">ta część wiadomosci nie jest wspierana przez Rakbooka</span>';
			}
		}

		if($partno!='')
		{
			$partno.='.';
		}
		
		$this->parts=array();
		if(isset($p->parts))
		{
			foreach($p->parts as $pnum=>$part)
			{
				$this->parts[]=new Part($stream, $mid, $part, $partno.($pnum+1));
			}
		}
	}

	function getAttachments()
	{
		$a=array();
		if(isset($this->attachment)) $a[] = $this->attachment;
		foreach($this->parts as $part)
		{
			$a = array_merge($a, $part->getAttachments());
		}
		return $a;
	}

	function GetMessage()
	{
		if($this->type==TYPEMULTIPART)
		{
			$message='';
			if(isset($this->subtype)&&$this->subtype=='alternative')
			{
				$parts=array_reverse($this->parts);
				foreach($parts as $p)
				{
					if($p->type==TYPETEXT)
					{
						return $p->html_converted_body;
					}
				}
				return '<span style="color:red">Żadna z alternatyw tej części wiadomości nie jest wspierana przez Rakbooka</span>';
			}else
			{
				foreach($this->parts as $p)
				{
					$msg=$p->getMessage();
					$message.=strlen($msg)>0?'<p>'.$p->getMessage().'</p>':'';
				}
			}
			return $message;
		}else
		{
			return $this->html_converted_body;
		}
	}
}

class Attachment
{
	public $name;
	public $messageuid;
	public $messagepartnumber;
	
	function __construct($name, $uid, $partnumber)
	{
		$this->name=$name;
		$this->messageuid=$uid;
		$this->messagepartnumber=$partnumber;
	}
	
	function generateLink()
	{
		return '<a href="downloadattachment.php?mailuid='.$this->messageuid.'&partno='.$this->messagepartnumber.'">'.$this->name.'</a>';
	}

	static function getFilename($params)
	{
		$filename=null;
		if(isset($params['filename']) || isset($params['name']))
		{
			$filename = $params['filename'] ? $params['filename'] : $params['name'];
			$filename= iconv_mime_decode($filename);
		}elseif(isset($params['filename*']) || isset($params['name*']))
		{
			$filename=$params['filename*']?$params['filename*']:$params['name*'];
			$explodedname=explode("'", $filename);
			$filename=rawurldecode($explodedname[2]);
			$filename=iconv($explodedname[0], 'UTF-8', $filename);
		}

		return $filename;
	}
}

function getrawmail(&$stream, $mid)
{
	return imap_fetchbody($stream, $mid, "");
}

function deleteMail(&$stream, $uid)
{
	$mid=imap_msgno($stream, $uid);
	
	if(!imap_mail_move($stream, $mid.':'.$mid, getenv('IMAP_TRASH_DIRECTORY')))
	{
		die("Nie udało się przenieść wiadomości do kosza");
	}

	imap_delete($stream, $mid);
	imap_expunge($stream);
}

?>
