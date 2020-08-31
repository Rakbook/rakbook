<?php
$mailserver=getenv('IMAP_MAILSERVER');
$maillogin=getenv('IMAP_MAILLOGIN');
$mailpass=getenv('IMAP_MAILPASS');

class Attachment
{
	public $name;
	public $type;
	public $data;
	public $messageuid;
	public $messagepartnumber;
	
	function __construct($name, $type, $uid, $partnumber)
	{
		$this->name=$name;
		$this->type=$type;
		$this->data=$data;
		$this->messageuid=$uid;
		$this->messagepartnumber=$partnumber;
	}
	
	function generateLink()
	{
		return '<a href="downloadattachment.php?mailuid='.$this->messageuid.'&partno='.$this->messagepartnumber.'">'.$this->name.'</a>';
	}
}

class Part
{
	public $message;
	public $attachments;
	
	function __construct(&$stream, $mid, $p, $partno)
	{
		$this->message='';
		$this->attachments=array();
		
		$data='';
		
		if($p->type<3)
		{
			$data = $partno ? imap_fetchbody($stream, $mid, $partno) : imap_body($stream, $mid);
			if ($p->encoding==4)
				$data = quoted_printable_decode($data);
			elseif ($p->encoding==3)
				$data = base64_decode($data);
		}
		$params = array();
		if ($p->ifparameters)
			foreach ($p->parameters as $x)
				$params[strtolower($x->attribute)] = $x->value;
		if ($p->ifdparameters)
			foreach ($p->dparameters as $x)
				$params[strtolower($x->attribute)] = $x->value;
		
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
		
		if ($filename)
		{
			$this->attachments[] = new Attachment($filename, $p->type, imap_uid($stream, $mid), $partno);
		}elseif ($p->type==0 && $data)
		{
			$charset = $params['charset'];
			$data=iconv($charset, 'UTF-8', $data);
			$this->message.=$data.'<br>';
		}elseif($p->type==2 && $data)
		{
			$this->message.=$data.'<br>';
		}
		
		if ($p->parts)
		{
			foreach ($p->parts as $pno0=>$p2)
			{
				$part=new Part($stream, $mid, $p2, $partno.($pno0+1));
				$this->message.=$part->message.'<br>';
				$this->attachments=array_merge($this->attachments, $part->attachments);
			}
		}
	}
}

class Mail
{
	
	public $from;
	public $subject;
	public $message;
	public $attachments;
	public $uid;
	public $date;
	
	function __construct(&$stream, $mid)
	{
		$this->attachments=array();
		$this->uid=imap_uid($stream, $mid);
		$h=imap_header($stream, $mid);
		$fromInfo = $h->from[0];
		$this->from=(isset($fromInfo->mailbox) && isset($fromInfo->host)) ? $fromInfo->mailbox . '@' . $fromInfo->host : '';
		$this->subject=isset($h->subject) ? imap_mime_header_decode($h->subject)[0]->text : '';
		$this->date=isset($h->date) ? strtotime($h->date) : null;
		
		$this->message='';
		
		$s=imap_fetchstructure($stream, $mid);
		
		if(!$s->parts)
		{
			$p=new Part($stream, $mid, $s, 0);
			$this->message.=$p->message;
			$this->attachments=$p->attachments;
		}else
		{
			foreach($s->parts as $pno0 => $part)
			{
				$p=new Part($stream, $mid, $part, $pno0+1);
				$this->message.=$p->message.'<br>';
				$this->attachments=array_merge($this->attachments, $p->attachments);
			}
		}
		
		$this->message=nl2br($this->message);
	}
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
