<?php
$where = $_POST["where"];
$who = $_POST["who"];
$when = $_POST["when"];
$impressions = $_POST["impressions"];

$write_data = "{$when} {$who} {$where} {$impressions}\n";

$file = fopen('data/memo.csv', 'a'); // ファイルを開く,引数a
flock($file, LOCK_EX); // ファイルをロック
fwrite($file, $write_data);
flock($file, LOCK_UN); // ロック解除
fclose($file);

header("Location:d219.php");
