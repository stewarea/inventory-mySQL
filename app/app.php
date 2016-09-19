<?php
    date_default_timezone_set('America/Los_Angeles');
    require_once __DIR__.'/../vendor/autoload.php';
    require_once __DIR__.'/../src/Inventory.php';

    $app = new Silex\Application();
    $app['debug'] = true;

    $server = 'mysql:host=localhost;dbname=inventories';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
    ));

    $app->get('/', function() use ($app) {
        return $app['twig']->render('home.html.twig');
    });

    $app->get('/inventory', function() use ($app){
        return $app['twig']->render('inventory.html.twig', array('inventory' => Inventory::getAll()));
    });

    $app->post('/postInventory', function() use ($app){
        $name = $_POST['name'];
        $new_inventory = new Inventory($name, 12);
        $new_inventory->save();
        return $app->redirect('/inventory');
    });



    $app->post('/delete_inventory', function() use ($app) {
        Inventory::deleteAll();
        return $app['twig']->render('home.html.twig');
    });

    return $app;
 ?>
