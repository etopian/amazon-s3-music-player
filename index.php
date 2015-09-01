<?php
# The MIT License (MIT)
# Copyright (c) 2015 Etoian Inc.
# THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
# IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
# FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
# AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
# LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
# OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
# THE SOFTWARE.


require_once('aws.phar');

$settings['AWS_KEY']="";
$settings['AWS_SECRET']="";
$settings['PASSWORD']="";
$settings['BUCKET']="";

if($_GET['pass'] != $settings['PASSWORD']){
die('Access denied');
}

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;

// Instantiate an S3 client
$s3 = S3Client::factory(['key' => $settings['AWS_KEY'], 'secret' => $settings['AWS_SECRET']]);


$bucket = $settings['BUCKET'];
$iterator = $s3->getIterator('ListObjects', array(
    'Bucket' => $bucket
));

$urls = [];
foreach ($iterator as $object) {
     //$urls[] = ($object)['Key'];
     $urls[$object['Key']] = $s3->getObjectUrl($bucket, $object['Key'], '+4 hours');
}
?>
<!DOCTYPE html>
<html>
<head>
   
<link rel="stylesheet" href="//codeorigin.jquery.com/jquery-wp-content/themes/jquery/css/base.css?v=1">

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="http://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>

<script>
function change(sourceUrl, text) {
   var audio = $("#player");      
   $("#mp3Src").attr("src", sourceUrl);
   /****************/
   audio[0].pause();
   audio[0].load();//suspends and restores all audio element
   audio[0].play();
   /****************/
   
   $('#audio-info').text(text);
}


$(document).ready(function(){
   $('.audio-file').click(function(){
	  change($(this).attr('href'), $(this).text());
	  
	  return false;
   });   
   
});



   
   
</script>

<style>
body{
}



.flexbox-container {
	display: block;
}
.flexbox-container > div:first-child {
   width: 20%;
   height: 100%;
}
.flexbox-container > div:nth-child(2) {
   width: auto;
   margin-left: 300px;
   padding-left: 40px;
   padding-top: 20px;
   background: none;
}


.flexbox-container > div:first-child {
   margin-right: 20px;
   width: 300px;
	
   
}

#sidebar-fixed{
   position:fixed;
   top: 0;
   left: 0;
   background-color: #322E2E;
   height: 100%;
}

#player{
   margin: 10px;

}

#main-content{

   background: #161515;
}

#main-content ul li{
   overflow: hidden;
   margin-top: 10px;
   margin-bottom: 10px;
 
}

#main-content ul li a{
   padding: 20px;
   display: block;

}

#main-content ul li:hover{
   background: #000;
}

#main-content ul li a{
   color: #fff;
   text-decoration: none;

}

#audio-info{
width: 96%; 
width: 300px;  
border-radius: 2px; 
border: 1px solid black; 
background: #878484; 
padding: 1%; 
color: white; 
margin: 2%;"
}

</style>
</head>
<body>
<div class="flexbox-container">
   <div>
	  <div id="sidebar-fixed">
		 <div id="audio-info">
			
		 </div>
  
		<audio id="player" controls>
  
		 <source id="mp3Src" src="" type="audio/mpeg">
	   
	   </audio> 
  
	 </div>
	</div>
   <div id="main-content" >
	  <ul >
		 <?php foreach($urls as $key => $url): ?>
		 <li><a class="audio-file" target="_blank" href="<?= $url?>"><?= $key ?></a>
		 <?php endforeach; ?>
	  </ul>
   </div>
</div>




</body>
</html>
