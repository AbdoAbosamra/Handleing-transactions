<?php
declare(strict_types =1 );

$root = dirname(__DIR__) . DIRECTORY_SEPARATOR;

// we have here Three constants to all paths we have

define('APP_PATH', $root . 'app' . DIRECTORY_SEPARATOR);
define('FILES_PATH' , $root .'transaction_files' . DIRECTORY_SEPARATOR);
define('VIWES_PATH' , $root . 'views' . DIRECTORY_SEPARATOR);

// so here we define all paths as constants at first

include APP_PATH . "App.php";
require APP_PATH . 'helper.php';
$files = getTransactionFiles(FILES_PATH);
// var_dump($files);
// echo "<br>";

$transactions = [];
foreach($files as $file){
    $transactions[] = array_merge($transactions ,getTransactions($file , "extractTransactions")); 
}
$totals = calcTotals($transactions);

$transactions = flattenArray($transactions);
// print_r($transactions);

require VIWES_PATH . "transactions.php";