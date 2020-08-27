<?php
require_once( 'dependencies.php' );

$id=validatetoken();

class Note
{
	public $id;
	public $content;
	public $title;
}

if($_SERVER['REQUEST_METHOD'] === 'POST')
{
	if(!isset($_POST['note'])&&!isset($_POST['title']))
	{
		respond('wtf are you trying to do?', 400);
	}
	if(isset($_POST['id']))
	{
		$noteid=intval($_POST['id']);
		$result=easyQuery('SELECT owner FROM notes WHERE id=?', 'i', $noteid);
		if($result->num_rows<1)
		{
			respond('note not found', 404);
		}
		$row=$result->fetch_assoc();
		if($row['owner']===$id)
		{
			if(isset($_POST['note'])&&isset($_POST['title']))
			{
				easyQuery('UPDATE notes SET content=?, title=? WHERE id=?', 'ssi', $_POST['note'], $_POST['title'], $noteid);
				respond();
			}elseif(isset($_POST['note']))
			{
				easyQuery('UPDATE notes SET content=? WHERE id=?', 'si', $_POST['note'], $noteid);
				respond();
			}elseif(isset($_POST['title']))
			{
				easyQuery('UPDATE notes SET title=? WHERE id=?', 'si', $_POST['title'], $noteid);
				respond();
			}
			respond('some weird shit that should\'nt happen', 500);
		}else
		{
			respond('you do not have permission to edit this note', 403);
		}
	}else
	{
		if(!isset($_POST['note'])||!isset($_POST['title']))
		{
			respond('wtf are you trying to do?', 400);
		}else
		{
			$noteid=easyQuery('INSERT INTO notes (title, content, owner) VALUES (?, ?, ?)', 'ssi', $_POST['title'], $_POST['note'], $id);
			respond($noteid);
		}
	}
}elseif($_SERVER['REQUEST_METHOD'] === 'GET')
{
	if(isset($_GET['id']))
	{
		$noteid=intval($_GET['id']);
		$result=easyQuery('SELECT id, owner, title, content FROM notes WHERE id=?', 'i', $noteid);
		if($result->num_rows<1)
		{
			respond('note not found', 404);
		}
		$row=$result->fetch_assoc();
		if($row['owner']!=$id)
		{
			respond('you do not have permission to read this note', 403);
		}
		$note = new Note;
		$note->id=$row['id'];
		$note->title=$row['title'];
		$note->content=$row['content'];
		respond(json_encode($note));
	}else
	{
		$notes=array();
		$result=easyQuery('SELECT id FROM notes WHERE owner=?', 'i', $id);
		while($row=$result->fetch_assoc())
		{
			$notes[]=$row['id'];
		}
		respond(json_encode($notes));
	}
}

?>
