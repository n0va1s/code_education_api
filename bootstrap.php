<?php
require __DIR__.'/vendor/autoload.php';

$app = new \Silex\Application();
$app['debug'] = true;

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/views',
));

//Foi para o core do Silex 2.0
//$app->register(new Silex\Provider\UrlGeneratorServiceProvider());
