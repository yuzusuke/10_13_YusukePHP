<?php
//1. DB接続
$dbn ='mysql:dbname=gsf_l01_db13;charset=utf8;port=3306;host=localhost';
$user = 'root';
$pwd = 'root';
    try {
        $pdo = new PDO($dbn, $user, $pwd);
    } catch (PDOException $e) {
        exit('dbError:'.$e->getMessage());
    }


//2. データ表示SQL作成
$sql = 'SELECT * FROM gs_bm_table'; //ORDER BY  deadline ASC or DESC で順番替え
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();


//3. データ表示

$view='';
if ($status==false) {
    //execute（SQL実行時にエラーがある場合）
    $error = $stmt->errorInfo();
    exit('sqlError:'.$error[2]);
} else {
    // $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // var_dump($result);
    // exit();

    //Selectデータの数だけ自動でループしてくれる
    //http://php.net/manual/ja/pdostatement.fetch.php
    while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // $star = $result['star'];
        if ($result['star'] == 1) {
            $val = '★';
        }
        if ($result['star'] == 2) {
            $val = '★★';
        }
        if ($result['star'] == 3) {
            $val = '★★★';
        }
        if ($result['star'] == 4) {
            $val = '★★★★';
        }
        if ($result['star'] == 5) {
            $val = '★★★★★';
        }

        //exit();                                                                              //$result['star']ではなく
        $view .= '<li class="list-group-item">';                                               //$valに置き換える
        $view .= '<p>'.'読者名：'.$result['name'].'<br>'.'書籍名：'.$result['bname'].'<br>'.'評価：'.$val.'<br>'.'URL：'.$result['url'].'<br>'.'コメント：'.$result['comment'].'</p>';
        $view .= '</li>';
    }
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Book Mark</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css"
        integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <style>
        div {
            padding: 10px;
            font-size: 16px;
        }
    </style>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-primary	">
            <a class="navbar-brand text-white font-weight-bold" href="#">ブック登録情報</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">ブックマーク</a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    <div>
        <ul class="list-group">
            <!-- ここにDBから取得したデータを表示しよう -->
            <?=$view?>
        </ul>
    </div>

</body>

</html>