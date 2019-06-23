<?php
require_once('../chatbot_line_LINEBotTiny/LINEBotTiny.php');

$channelAccessToken = '9JPOOKX01MpOUK/erxfRJdUEnGPxTKYAtwODwy/ReEV9u5yGaXQzh7s53otvWiyZRh+wNZJ5SDckqSkDwgxaIBqFwgEvwFQUQ59EKTyskOmh6ChdFD6rCOQ5dIyD7xPb0+hiiDd52OcHZnV5RcpkawdB04t89/1O/w1cDnyilFU=';
$channelSecret = '9fd9e41cbb39048c31d6a4175b44bfd3';
$webSiteUrl = "https://5542051c.ngrok.io";

###########################################################################################################
// 接收user 傳來的資訊

   $input = json_decode(file_get_contents('php://input'), true);
		/*$f = fopen("log.txt", "w");
		fwrite($f, "\n=============================\n".var_export($input, true)."\n");
		fclose($f);*/
   
   
   $replyToken = $input[events][0]['replyToken'];
   $userId = $input[events][0]['source']['userId'];
   if(trim($userId)=='') $userId = $input[events][0]['source']['roomId'];
   $message = $input[events][0]['message']['text'];
   $type = $input[events][0]['message']['type'];

   $eventId = $input['events']['0']['message']['id'];
   $timestamp = $input['events']['0']['timestamp'];

###########################################################################################################
// $client & $event 物件
   $client = new LINEBotTiny($channelAccessToken, $channelSecret);
   $event = array_shift($client->parseEvents());


#####
##傳送圖片
##https://developers.line.biz/en/reference/messaging-api/#image-message



$file_path_open = '../chatbot_line_LINEBotTiny/log.txt';
$file_path_lang = '../chatbot_line_composerSDK/log.txt';

if(file_exists($file_path_open))
{
	$file_arr = file($file_path_open);
	for( $i=0; $i<count($file_arr); $i=$i+2)
	{//逐行讀取檔案內容
		//echo $file_arr[$i]."<br />";
		$file_arr[$i]=str_replace("\n","",$file_arr[$i]); 
		echo $file_arr[$i];
		$open = $file_arr[$i];
	}
	
}

if(file_exists($file_path_lang))
{
	$file_arr = file($file_path_lang);
	for( $i=0; $i<count($file_arr); $i=$i+2)
	{//逐行讀取檔案內容
		//echo $file_arr[$i]."<br />";
		$file_arr[$i]=str_replace("\n","",$file_arr[$i]); 
		echo $file_arr[$i];
		$language = $file_arr[$i];
	}
	
}

if($message == 'robot 睡覺')
{
	//$open = -1;
	$f = fopen($file_path_open, "w");
	fwrite($f,"-1");
	fclose($f);
	$client->replyMessage([
			'replyToken' => $event['replyToken'],
			'messages' => [
				[
				   'type' => 'text',
				   'text' => '好哦~好哦~'
				]
			]
		  ]);
}
else if($message == 'robot 起床')
{
	//$open = 1;
	$f = fopen($file_path_open, "w");
	fwrite($f,"1");
	fclose($f);
	$client->replyMessage([
			'replyToken' => $event['replyToken'],
			'messages' => [
				[
				   'type' => 'text',
				   'text' => '起來惹~~'
				]
			]
		  ]);
}

if($message == 'robot 中文')
{
	$f = fopen($file_path_lang, "w");
	fwrite($f,"zh-TW");
	fclose($f);
	$client->replyMessage([
			'replyToken' => $event['replyToken'],
			'messages' => [
				[
				   'type' => 'text',
				   'text' => '好~'
				]
			]
		  ]);
}
else if($message == 'robot 日文')
{
	$f = fopen($file_path_lang, "w");
	fwrite($f,"ja");
	fclose($f);
	$client->replyMessage([
			'replyToken' => $event['replyToken'],
			'messages' => [
				[
				   'type' => 'text',
				   'text' => '好きな~'
				]
			]
		  ]);
}
else if($message == 'robot 韓文')
{
	$f = fopen($file_path_lang, "w");
	fwrite($f,"ko");
	fclose($f);
	$client->replyMessage([
			'replyToken' => $event['replyToken'],
			'messages' => [
				[
				   'type' => 'text',
				   'text' => '승인!'
				]
			]
		  ]);
}
else if($message == 'robot 英文')
{
	$f = fopen($file_path_lang, "w");
	fwrite($f,"en");
	fclose($f);
	$client->replyMessage([
			'replyToken' => $event['replyToken'],
			'messages' => [
				[
				   'type' => 'text',
				   'text' => 'ok~'
				]
			]
		  ]);
}
else if($message == 'robot 泰文')
{
	$f = fopen($file_path_lang, "w");
	fwrite($f,"th");
	fclose($f);
	$client->replyMessage([
			'replyToken' => $event['replyToken'],
			'messages' => [
				[
				   'type' => 'text',
				   'text' => 'ตกลง~'
				]
			]
		  ]);
}

else if($message == 'robot 德文')
{
	$f = fopen($file_path_lang, "w");
	fwrite($f,"de");
	fclose($f);
	$client->replyMessage([
			'replyToken' => $event['replyToken'],
			'messages' => [
				[
				   'type' => 'text',
				   'text' => 'OK~'
				]
			]
		  ]);
}

else if($message == 'robot 狀態')
{
	
	
	$sleep="  robot 睡覺  ";
	if($open == 1){$sleep="  robot 醒著  ";}
	$lan_state=$language;


    switch ($lan_state)
	{
		case 'zh-TW':
		$lan_state_c='中文(繁體)';
		break;
		case 'ja':
		$lan_state_c='日文';
		break;
		case 'ko':
		$lan_state_c='韓文';
		break;
		case 'th':
		$lan_state_c='泰文';
		break;
		case 'de':
		$lan_state_c='德文';
		break;
		case 'en':
		$lan_state_c='英文';
		break;
	}
		  $client->replyMessage([
			'replyToken' => $event['replyToken'],
			'messages' => [
				[
				   'type' => 'text',
				   'text' => $lan_state_c.$sleep
				]
			]
		  ]);

}

if($open == 1)
{
	if ($type == 'image')
	{
		$url = 'https://api.line.me/v2/bot/message/'.$eventId.'/content';
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Authorization: Bearer {' . $channelAccessToken . '}',
		));

		$json_content = curl_exec($ch);
		curl_close($ch);
		if (!$json_content) {
			return false;
		}

		$fileURL = './'.$eventId.'.jpg';
		$fp = fopen($fileURL, 'w');
		fwrite($fp, $json_content);
		fclose($fp);


		$picture_path =  "https://5542051c.ngrok.io/stu10/cloudsystem/computerVision/".$eventId.'.jpg';

		  
		  $client->replyMessage([
			'replyToken' => $event['replyToken'],
			'messages' => [
				[
				   'type' => 'text',
				   'text' => 'http://5542051c.ngrok.io/stu10/cloudsystem/computerVision/picture.php?picture_path='.$picture_path.'&language='.$language
				]
			]
		  ]);


		  //echo "<script type='text/javascript'>window.location.href='http://5542051c.ngrok.io/stu10/cloudsystem/computerVision/picture.php?picture_path=".$picture_path."'</script>";

	}
	else if ( $type == 'text')
	{
		$key = '050922789d104c5d88fd0cc4cd13efe3';
		$host = "https://api.cognitive.microsofttranslator.com";
		$path = "/translate?api-version=3.0";
		//$language='ja';
		$params = "&to=".$language;
		//$text = "Hello, world! 我是誰";
		$text = $message;
		if (!function_exists('com_create_guid')) {
		  function com_create_guid() {
			return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
				mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
				mt_rand( 0, 0xffff ),
				mt_rand( 0, 0x0fff ) | 0x4000,
				mt_rand( 0, 0x3fff ) | 0x8000,
				mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
			);
		  }
		}
		function Translate ($host, $path, $key, $params, $content) {
			$headers = "Content-type: application/json\r\n" .
				"Content-length: " . strlen($content) . "\r\n" .
				"Ocp-Apim-Subscription-Key: $key\r\n" .
				"X-ClientTraceId: " . com_create_guid() . "\r\n";
			$options = array (
				'http' => array (
					'header' => $headers,
					'method' => 'POST',
					'content' => $content
				)
			);
			$context  = stream_context_create ($options);
			$result = file_get_contents ($host . $path . $params, false, $context);
			return $result;
		}
		$requestBody = array (
			array (
				'Text' => $text,
			),
		);
		$content_tansf = json_encode($requestBody);
		$result_tansf  = Translate ($host, $path, $key, $params, $content_tansf );

		$n= json_decode($result_tansf  , true);
		//print_r($n["0"]["translations"]["0"]["text"]);
				
		
		 $client->replyMessage([
			'replyToken' => $event['replyToken'],
			'messages' => [
				[
				   'type' => 'text',
				   'text' => $n["0"]["translations"]["0"]["text"]
				]
			]
		  ]);
	}
}
?>
  



