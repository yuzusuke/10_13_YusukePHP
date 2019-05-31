<?php
// 入力チェック
if (
    !isset($_POST['name']) || $_POST['name']=='' ||
    !isset($_POST['bname']) || $_POST['bname']=='' ||
    !isset($_POST['star']) || $_POST['star']=='' ||
    !isset($_POST['url']) || $_POST['url']==''
) {
    exit('paramError');
}
//POSTデータ取得
$name = $_POST['name'];
$bname = $_POST['bname'];
$star = $_POST['star'];
$url = $_POST['url'];
$comment = $_POST['comment'];


//DB接続
$dbn = 'mysql:dbname=gsf_l01_db13;charset=utf8;port=3306;host=localhost';
$user = 'root';
$pwd = 'root';

try {
    $pdo = new PDO($dbn, $user, $pwd);
} catch (PDOException $e) {
    exit('dbError:'.$e->getMessage());
}

//データ登録SQL作成
$sql ='INSERT INTO gs_bm_table(id, name, bname, star, url, comment, indate)VALUES(NULL, :a1, :a2, :a3, :a4, :a5, sysdate())';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':a1', $name, PDO::PARAM_STR);    //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':a2', $bname, PDO::PARAM_STR);    //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':a3', $star, PDO::PARAM_STR);   //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':a4', $url, PDO::PARAM_STR);   //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':a5', $comment, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute();

//４．データ登録処理後
if ($status==false) {
    //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
    $error = $stmt->errorInfo();
    exit('sqError:' .$error[2]);
} else {
    //５．index.phpへリダイレクト
    header('Location: index.php');
}
