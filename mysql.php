<?php

$link = mysqli_connect('db', 'book_log', 'pass', 'book_log');

if (!$link) {
    echo 'Error: データーベースに接続出来ませんでした。' . PHP_EOL;
    echo 'Debugging error: ' . mysqli_connect_error() . PHP_EOL;
    exit;
}
echo 'データベースに接続出来ました。' . PHP_EOL;
mysqli_close($link);
echo 'データベースを切断しました。' . PHP_EOL;
