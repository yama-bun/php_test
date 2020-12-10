<?php

function createMemo() {
    echo 'やるべきこと：';
    $memo = trim(fgets(STDIN));
    echo '登録が完了しました。' . PHP_EOL;
    return [
        'memo' => $memo,
    ];
}

function readMemo($memos) {
    echo 'やることリスト' . PHP_EOL;
    foreach ($memos as $todo) {
        echo 'やるべきこと：' . $todo['memo'] . PHP_EOL;
        echo '---------' . PHP_EOL;
    }
}

$memos = [];

while (true) {
    echo '1. やることを登録' . PHP_EOL;
    echo '2. やることを確認' . PHP_EOL;
    echo '9. アプリケーションを終了' . PHP_EOL;
    echo '番号を選択してください(1, 2, 9):';
    $num = trim(fgets(STDIN));

    if ($num === '1') {
        $memos[] = createMemo();
    } elseif($num === '2') {
        readMemo($memos);
    } elseif($num === '9') {
        break;
    } else {
        echo '1,2,9のどれがを入力してください。' . PHP_EOL;
    }
}
