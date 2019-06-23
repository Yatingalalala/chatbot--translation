<?php
//Image recognition


$picture_path=$_GET['picture_path'];
$language=$_GET['language'];

$webSiteUrl ="https://5542051c.ngrok.io";
$APIkey = "9e235a49c87e4f4485c82cd5ecc9181a";
//if($img=='') $img='11.jpg';
//$imgUrl = "$webSiteUrl/stu10/cloudsystem/computerVision/demoImages/$img";
$imgUrl= $picture_path;
//Translate-------------------------------------------------------------------------
$key = '050922789d104c5d88fd0cc4cd13efe3';
$host = "https://api.cognitive.microsofttranslator.com";
$path = "/translate?api-version=3.0";
$params = "&to=".$language;
//$params = "&to=ja";
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
//Make Picture -------------------------------------------------------------------------
$parameters = "language=unk&detectOrientation=true";
$ocr='curl -v -X POST \'https://eastasia.api.cognitive.microsoft.com/vision/v1.0/ocr?'.$parameters.'\' \
-H \'Content-Type: application/json\' \
-H \'Ocp-Apim-Subscription-Key: '.$APIkey.'\' \
-d \'{"url":"'.$imgUrl.'"}\'
';
$return = shell_exec($ocr);
$returnData = json_decode($return, true);
$regionList = $returnData['regions']['0']['lines'];
?>

<body onload='javascript: draw();'>

<canvas id='canvas' width='2000' height='1000'></canvas>
</body>
<script>
function draw() {
  var ctx = document.getElementById('canvas').getContext('2d');
  var img = new Image();
  
  img.onload = function(){
    ctx.drawImage(img,0,0);
    <?php
    foreach($regionList as $eachRegion){
      $boundingBox_list = explode(",",$eachRegion['boundingBox']);
      $left   = $boundingBox_list[0];
      $top    = $boundingBox_list[1]; 
      $width  = $boundingBox_list[2]; 
      $height = $boundingBox_list[3]; 
      echo "ctx.rect($left,$top,$width,$height);\n";
      
      $words='';
      foreach($eachRegion['words'] as $eachWord){
        $requestBody = array (
							array (
								'Text' => $eachWord['text'],
							),
						);
		$content=json_encode($requestBody);
		$result_tansf  = Translate ($host, $path, $key, $params, $content);
		$n= json_decode($result_tansf  , true);
		$words .=$n["0"]["translations"]["0"]["text"]." ";		
      }//end foreach
      $words = addslashes($words);     
      echo "
      ctx.font = '16pt Calibri';
      ctx.fillStyle = '#ff0000';
      ctx.fillText('".$words."', $left, $top);
      "; 
    }//end foreach
    ?>	
    ctx.strokeStyle = '#00ffff';
    ctx.stroke();
  };
  img.src = '<?php echo $imgUrl;?>';
}
</script>


					