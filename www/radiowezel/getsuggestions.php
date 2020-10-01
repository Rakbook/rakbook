<?php
class Suggestion implements JsonSerializable
{
	public $name;
	public $url;
	public $status;
	public $ytident;

	public function jsonSerialize() {
        return ['name'=>$this->name, 'url'=>$this->url, 'status'=>$this->status];
    }
}
$pages=1;
if(isset($_GET['pages']))
{
	if(is_numeric($_GET['pages']))
	{
		$p=intval($_GET['pages']);
		if($p>0)
		{
			$pages=$p;
		}
	}
}
$filter=0b111;
define('FILTER_WAITING', 1<<0);
define('FILTER_REJECTED', 1<<1);
define('FILTER_ACCEPTED', 1<<2);

if(isset($_GET['filter']))
{
	if(is_numeric($_GET['filter']))
	{
		$f=intval($_GET['filter']);
		if($f>0)
		{
			$filter=$f;
		}
	}
}

header('Content-Type: application/json');
$url = 'http://158.75.60.75/api/player/suggestions';
$options = array(
    'http' => array(
        'header'  => "Content-type: application/json\r\n",
        'method'  => 'POST',
        'content' => '{"data":{"site":'.$pages.',"waiting":'.($filter&FILTER_WAITING?'true':'false').',"accepted":'.($filter&FILTER_ACCEPTED?'true':'false').',"denied":'.($filter&FILTER_REJECTED?'true':'false').'}}'
    )
);
$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);
if($result === FALSE)
{
    http_response_code(500);
}

$decoded=json_decode($result);
//print_r($decoded);
$response = array();
if(isset($decoded->result))
{
	$ytidslist=array();
	foreach($decoded->result as $s)
	{
		if(!isset($s->ytid)||!isset($s->url)||!isset($s->status)) break;
		$suggestion = new Suggestion;
		$suggestion->name=$s->ytid;
		$suggestion->url=$s->url;
		$suggestion->status=$s->status;
		$suggestion->ytident=null;
		$parsedurl=parse_url($s->url);
		if($parsedurl==FALSE)
		{
			http_response_code(500);
			die();
		}else
		{
			$youtubeidentifier=null;
			if(($parsedurl['host']=='www.youtube.com'||$parsedurl['host']=='youtube.com'||$parsedurl['host']=='m.youtube.com')&&$parsedurl['path']=='/watch'&&isset($parsedurl['query']))
			{
				$params=array();
				parse_str($parsedurl['query'], $params);
				if(isset($params['v'])&&is_string($params['v']))
				{
					$youtubeidentifier=$params['v'];
				}
			}elseif($parsedurl['host']=='youtu.be')
			{
				if(isset($parsedurl['path']))
				{
					$youtubeidentifier=ltrim($parsedurl['path'], '/');
				}
			}

			if(isset($youtubeidentifier))
			{
				$suggestion->ytident=$youtubeidentifier;
				$ytidslist[]=$youtubeidentifier;
				
			}
		}
		$response[]=$suggestion;
	}
	$idtoname=array();
	$ytidslist=array_chunk($ytidslist, 50);
	foreach($ytidslist as $arr)
	{
		$ytrequest='https://www.googleapis.com/youtube/v3/videos?id='.implode(",", $arr).'&key='.getenv('YOUTUBE_KEY').'&part=snippet&part=snippet&fields=items(id,snippet(title))';
		$ytresponse=file_get_contents($ytrequest);
		$decodedytresponse=json_decode($ytresponse);
		foreach($decodedytresponse->items as $item)
		{
			$idtoname[$item->id]=$item->snippet->title;
		}
	}
	foreach($response as &$s)
	{
		if(isset($s->ytident)&&isset($idtoname[$s->ytident]))
		{
			$s->name=$idtoname[$s->ytident];
		}
	}
	unset($s);
	echo json_encode($response);

}else
{
	http_response_code(500);
	die();
}


?>