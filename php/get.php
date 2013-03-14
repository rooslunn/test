<?php

require_once "DataProvider.php";
require_once "DataStore.php";
require_once "DataPresenter.php";
require_once "Controller.php";

$query = htmlentities($_REQUEST['q'], ENT_QUOTES, 'UTF-8');

$provider = new RSSDataProvider();
$presenter = new DataPresenter();
$store = new MySQLDataStore();
$controller = new Controller($provider, $store, $presenter);

header('Content-type: application/json');
echo $controller->search_news_for($query);