<?php

function validate($review) {
    $errors = [];

    //書籍名入力チェック
    if (!strlen($review['title'])) {
        $errors['title'] =  '書籍名を入力してください。';
    } elseif(strlen($review['title']) > 255) {
        $errors['title'] = '書籍名は255文字以内で入力してください。';
    }

    //著者名入力チェック
    if (!strlen($review['book_author'])) {
        $errors['book_author'] = '著者名を入力してください。';
    } elseif(strlen($review['book_author']) > 255) {
        $errors['book_author'] = '著者名は255文字以内で入力してください。';
    }

    //読書状況入力チェック
    $array = ['未読', '読んでる', '読了'];
    if (!in_array($review['book_status'], $array, true)) {
        $errors['book_status'] = '読書状況は、未読、読んでる、読了のどれかを入力してください。';
    }

    //評価をチェック
    if (!(int)($review['book_score'])) {
        $errors['book_score'] = '評価は整数値で入力してください。';
    } elseif ($review['book_score'] < 1 || $review['book_score'] > 5) {
        $errors['book_score'] = '評価は1~5の整数値で入力してください。';
    }

    //感想入力チェック
    if (!strlen($review['book_text'])) {
        $errors['book_text'] = '感想を入力してください。';
    } elseif (strlen($review['book_text']) > 1000) {
        $errors['book_text'] = '感想は2000文字以内で入力してください。';
    }

    return $errors;
}

function dbconnect()
{
    $link = mysqli_connect('db', 'book_log', 'pass', 'book_log');

    if (!$link) {
        echo 'データーベースに接続出来ませんでした。' . PHP_EOL;
        echo 'Debbug Error:' . mysqli_connect_error() . PHP_EOL;
    }

    return $link;
}

function createReview($link)
{
    $review = [];

    echo '読書ログを登録してください' . PHP_EOL;
    echo '書籍名：';
    $review['title'] = trim(fgets(STDIN));
    echo '著者名：';
    $review['book_author'] = trim(fgets(STDIN));
    echo '読書状況(未読,読んでる,読了)：';
    $review['book_status'] = trim(fgets(STDIN));
    echo '評価(5点満点の整数)：';
    $review['book_score'] = trim(fgets(STDIN));
    echo '感想：';
    $review['book_text'] = trim(fgets(STDIN));

    //エラーチェック
    $validated = validate($review);
    if (count($validated) > 0) {
        foreach ($validated as $error) {
            echo $error . PHP_EOL;
        }
        return;
    }

    $sql = <<<EOT
    INSERT INTO reviews (
        title,
        author,
        status,
        score,
        summary
    ) VALUES (
        "{$review['title']}",
        "{$review['book_author']}",
        "{$review['book_status']}",
        "{$review['book_score']}",
        "{$review['book_text']}"
    );
    EOT;

    $result = mysqli_query($link, $sql);
    if ($result) {
        echo 'データを追加しました。' . PHP_EOL;
        echo '登録が完了しました。' . PHP_EOL;
    } else {
        echo 'Error: データの追加に失敗しました。' . PHP_EOL;
        echo 'debugging error: ' . mysqli_error($link) . PHP_EOL;
    }

    return [
        'title'   => $review['title'],
        'book_author'   => $review['book_author'],
        'book_status' => $review['book_status'],
        'book_score'    => $review['book_score'],
        'book_text'    => $review['book_text'],
    ];
}

function readReview($link)
{
    echo '登録されている読書ログを表示します。';
    $sql = 'SELECT title, author, status, score, summary FROM reviews';
    $results = mysqli_query($link, $sql);

    while ($company = mysqli_fetch_assoc($results)) {
        echo '書籍名：' . $company['title'] . PHP_EOL;
        echo '著者名：' . $company['author'] . PHP_EOL;
        echo '読書状況：' . $company['status'] . PHP_EOL;
        echo '評価：' . $company['score'] . PHP_EOL;
        echo '感想：' . $company['summary'] . PHP_EOL;
        echo '--------------------' . PHP_EOL;
    }
    mysqli_free_result($results);
}

$link = dbconnect();

while (true) {
    echo '1. 読書ログを登録' . PHP_EOL;
    echo '2. 読書ログを表示' . PHP_EOL;
    echo '9. アプリケーションを終了' . PHP_EOL;
    echo '番号を選択してください(1,2,9) :';
    $num = trim(fgets(STDIN));

    if ($num === '1') {
        //読書ログを登録
        $reviews[] = createReview($link);
    } elseif ($num === '2') {
        //読書ログを表示
        readReview($link);
    } elseif ($num === '9') {
        //アプリケーションを終了
        mysqli_close($link);
        echo 'データベースを切断しました。' . PHP_EOL;
        break;
    } else {
        echo '1,2,9のどれかを選択してください。' . PHP_EOL;
    }
}
