<?php

$GLOBALS['settings'] = json_decode(file_get_contents('settings.json'),true);
if(!empty($GLOBALS['settings']['HTTP_PASSWORD']) && !isset($_GET['pass'])) {
    if ($_GET['pass'] != $GLOBALS['settings']['HTTP_PASSWORD']) {
        die('Access denied.');
    }
}

require_once 'vendor/autoload.php';
require_once('aws.phar');

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;


$configuration = [
    'settings' => [
        'displayErrorDetails' => true,
    ],
];
$c = new \Slim\Container($configuration);


// Create app
$app = new \Slim\App($c);

// Get container
$container = $app->getContainer();

// Register component on container
$container['view'] = function ($container) {
    return new \Slim\Views\PhpRenderer('view/');
};


// Render Twig template in route
$app->get('/', function ($request, $response, $args) {


    $urls = [];
    $path = $this->router->pathFor('player');


    return $this->view->render($response, 'index.tpl.php', [
        'urls' => $urls,
        'base_url' => $path,
        'password' => $GLOBALS['settings']['HTTP_PASSWORD']
    ]);
})->setName('player');

$app->get('/url', function ($request, $oldResponse, $args) {
    
    $settings = $GLOBALS['settings'];
    
    $newResponse = $oldResponse->withHeader('Content-type', 'application/json');
    $bucket = $settings['BUCKET'];    
    $s3 = S3Client::factory(['key' => $settings['AWS_KEY'], 'secret' => $settings['AWS_SECRET']]);    
    $key = urldecode($_GET['key']);
    $item_url = $s3->getObjectUrl($bucket, $key, '+1 hours');
    $newResponse = $oldResponse->withJson($item_url);    
    
    return $newResponse;     
});

$app->get('/clearcache', function ($request, $oldResponse, $args) {
    
    $settings = $GLOBALS['settings'];

    $newResponse = $oldResponse->withHeader('Content-type', 'application/json');

    $newResponse = $oldResponse->withJson(apcu_delete('urls_json'));    
    
    return $newResponse;     
});


$app->get('/load', function ($request, $oldResponse, $args) {
    $newResponse = $oldResponse->withHeader('Content-type', 'application/json');
    
    $settings = $GLOBALS['settings'];

    // Instantiate an S3 client
    $s3 = S3Client::factory(['key' => $settings['AWS_KEY'], 'secret' => $settings['AWS_SECRET']]);


    $bucket = $settings['BUCKET'];
    $iterator = $s3->getIterator('ListObjects', array(
        'Bucket' => $bucket
    ));


    //apcu_delete('urls_json');
    $urls = $settings['APCU_CACHE'] === true ? apcu_fetch('urls_json') : false;
    //$urls = false;
    //print_r(count($urls));
    
    if($urls === false){
        $urls = [];
        foreach ($iterator as $object) {

            if(substr($object['Key'], -3) == 'mp3') {
                
                
                $title = substr($object['Key'], 0, '-4');
                //$item_url = $s3->getObjectUrl($bucket, $object['Key'], '+12 hours');
        
                $url['title'] = $title;
                //$url['url'] = $item_url;
                $url['key'] = urlencode($object['Key']);
                $url['size'] = $object['Size'];
                
                //$urls[$title] = 
                $urls[] = $url;
            }
        }
        $cached = $settings['APCU_CACHE'] ? apcu_add('urls_json', $urls, 39600) : false;
    }
    
    
    //$data = array('name' => 'Bob', 'age' => 40);
    $newResponse = $oldResponse->withJson($urls);    
    
    return $newResponse;
});




// Run app
$app->run();
