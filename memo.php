<?php

function validate($memo) {
    $errors = [];

    if (!strlen($memo['title'])) {
        $errors['title'] = 'メモを入力してください。';
    } elseif(strlen($memo['title']) > 100) {
        $errors['title'] = '100文字以内で入力してください。';
    }
    return $errors;
}

function dbconnect() {
    $link = mysqli_connect('db', 'book_log', 'pass', 'book_log');

    if (!$link) {
        echo 'Error: データベースの接続に失敗しました。' . PHP_EOL;
        echo 'Debugging Error: ' . mysqli_connect_error($link) . PHP_EOL;
        exit;
    }
    echo 'データーベースに接続しました。' . PHP_EOL;
    return $link;
}

function createMemo($link) {
    $memo = [];

    echo 'やるべきこと：';
    $memo['title'] = trim(fgets(STDIN));

    $validated = validate($memo);
    if (count($validated) > 0) {
        foreach ($validated as $error) {
            echo $error . PHP_EOL;
        }
        return;
    }

    $sql = <<<EOT
    INSERT INTO memo (
        title
    ) VALUES (
        "{$memo['title']}"
    )
    EOT;
    $results = mysqli_query($link, $sql);

    if ($results) {
        echo 'データを追加しました。' . PHP_EOL;
    } else {
        echo 'Error: データの追加に失敗しました。' . PHP_EOL;
        echo 'Debugging Error: ' . mysqli_error($link) . PHP_EOL;
    }

}

function readMemo($link) {
    $sql = 'SELECT title FROM memo';
    $results = mysqli_query($link, $sql);

    while ($company = mysqli_fetch_assoc($results)) {
        echo 'やるべきこと： ' . $company['title'] . PHP_EOL;
        echo '--------------------' . PHP_EOL;
    }

    mysqli_free_result($results);
}

$link = dbconnect();

while (true) {
    echo '1. やることを登録' . PHP_EOL;
    echo '2. やることを確認' . PHP_EOL;
    echo '9. アプリケーションを終了' . PHP_EOL;
    echo '番号を選択してください(1, 2, 9):';
    $num = trim(fgets(STDIN));
    if ($num === '1') {
        $memos[] = createMemo($link);
    } elseif($num === '2') {
        readMemo($link);
    } elseif($num === '9') {
        mysqli_close($link);
        echo 'データベースとの接続を切断しました。' . PHP_EOL;
        break;
    } else {
        echo '1,2,9のどれがを入力してください。' . PHP_EOL;
    }
}
