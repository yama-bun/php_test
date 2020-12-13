<?php

$link   = mysqli_connect('db', 'book_log', 'pass', 'book_log');

if (!$link) {
    echo 'Error: データーベースに接続出来ませんでした。' . PHP_EOL;
    echo 'Debugging error: ' . mysqli_connect_error() . PHP_EOL;
    exit;
}

echo 'データベースに接続出来ました。' . PHP_EOL;

$sql = 'SELECT name, founder FROM companies';
$results = mysqli_query($link, $sql);

while ($company = mysqli_fetch_assoc($results)) {
    echo '会社名：' . $company['name'] . PHP_EOL;
    echo '代表者名：' . $company['founder'] . PHP_EOL;
}

mysqli_free_result($results); //メモリ解放。
// $sql = <<<EOT
// INSERT INTO companies (
//     name,
//     establishment_date,
//     founder
// ) VALUES (
//     'yosimoto',
//     '2013-01-13',
//     'oosaki syatyo'
// )
// EOT;

// $result = mysqli_query($link, $sql);
// if ($result) {
//     echo 'データを追加しました。' . PHP_EOL;
// } else {
//     echo 'Error: データの追加に失敗しました。' . PHP_EOL;
//     echo 'debugging error: ' . mysqli_error($link) . PHP_EOL;
// }

mysqli_close($link);
echo 'データベースを切断しました。' . PHP_EOL;
