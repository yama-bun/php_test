<?php

$link   = mysqli_connect('db', 'book_log', 'pass', 'book_log');

if (!$link) {
    echo 'Error: データーベースに接続出来ませんでした。' . PHP_EOL;
    echo 'Debugging error: ' . mysqli_connect_error() . PHP_EOL;
    exit;
}

echo 'データベースに接続出来ました。' . PHP_EOL;

$sql = <<<EOT
INSERT INTO companies (
    name,
    establishment_date,
    founder
) VALUES (
    'yosimoto',
    '2013-01-13',
    'oosaki syatyo'
)
EOT;

$result = mysqli_query($link, $sql);
if ($result) {
    echo 'データを追加しました。' . PHP_EOL;
} else {
    echo 'Error: データの追加に失敗しました。' . PHP_EOL;
    echo 'debugging error: ' . mysqli_error($link) . PHP_EOL;
}

mysqli_close($link);
echo 'データベースを切断しました。' . PHP_EOL;
