<?php

declare(strict_types=1);
function flattenArray($array, $levels = 1) {
    $result = [];
    foreach ($array as $value) {
        if ($levels > 0 && is_array($value)) {
            $result = array_merge($result, flattenArray($value, $levels - 1));
        } else {
            $result[] = $value;
        }
    }
    return $result;
}

function getTransactionFiles(string $filename ): array
{
    $files = [];
    if (is_dir(FILES_PATH)) {
        foreach (scandir(FILES_PATH) as $file) {
            if (is_dir($file)) {
                continue;
            }
            $files[] = $filename . $file;
        }
    } else {
        echo "The diectory is not found";
    }
    return $files;
}
function getTransactions(string $filename, ?callable $transactionHandeller =null): array{
    if(!file_exists($filename)) {
        trigger_error("File " .$filename . "Is not exist" , E_USER_ERROR);
    }
    $file = fopen($filename ,'r');
    fgetcsv($file);
    $transactions=[];
    
    while(($transaction = fgetcsv($file)) !== false) {
        if ($transactionHandeller !== null) {
            $transaction = $transactionHandeller($transaction);
        }
        $transactions[] = $transaction;
    }
        return $transactions;
}

function extractTransactions(array $transactions): array{
    [$date , $checkNumbers , $description , $amount] = $transactions;

    $amount = (float)str_replace(["$" ,","] ,"" ,$amount);

    return [
        'date' => $date,
        'checkNumbers'=> $checkNumbers,
        'description'=> $description,
        'amount'=> $amount
    ];

}
function calcTotals(array $transactions): array{
    $totals = ["netTotal"=> 0 ,"totalIncome"=>0 , "totalExpense"=>0];
    $transactions = flattenArray($transactions);
    foreach($transactions as $transaction){
        $totals["netTotal"] += $transaction["amount"];
        if($transaction["amount"] >= 0){
            $totals["totalIncome"] += $transaction["amount"];
        }else{
            $totals["totalExpense"] += $transaction["amount"];
        }
    }
    return $totals;
}
