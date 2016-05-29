<?php

require_once 'vendor/autoload.php';
require_once('aws.phar');


$GLOBALS['settings'] = json_decode(file_get_contents('settings.json'),true);
//if($_GET['pass'] != $settings['PASSWORD']){
//    die('Access denied');
//}

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;



// Create app
$app = new \Slim\App;

// Get container
$container = $app->getContainer();

// Register component on container
$container['view'] = function ($container) {
    return new \Slim\Views\PhpRenderer('view/');
};


// Render Twig template in route
$app->get('/', function ($request, $response, $args) {

    $settings = $GLOBALS['settings'];

    // Instantiate an S3 client
    $s3 = S3Client::factory(['key' => $settings['AWS_KEY'], 'secret' => $settings['AWS_SECRET']]);


    $bucket = $settings['BUCKET'];
    $iterator = $s3->getIterator('ListObjects', array(
        'Bucket' => $bucket
    ));


    
    $urls = $settings['APCU_CACHE'] ? apcu_fetch('urls') : false;

    if($urls === false){
        $urls = [];
        foreach ($iterator as $object) {

            if(substr($object['Key'], -3) == 'mp3') {
                $title = substr($object['Key'], 0, '-4');
                $urls[$title] = $s3->getObjectUrl($bucket, $object['Key'], '+12 hours');
            }
        }
        $cached = $settings['APCU_CACHE'] ? apcu_add('urls', $urls, 39600) : false;
    }


    return $this->view->render($response, 'index.tpl.php', [
        'urls' => $urls
    ]);
})->setName('player');





// Run app
$app->run();