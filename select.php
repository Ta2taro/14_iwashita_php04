<?php
//SESSIONスタート
session_start();


//1.  DB接続します
require_once('funcs.php');

//ログインチェック
loginCheck();

$pdo = db_conn();

//２．SQL文を用意(データ取得：SELECT)
$stmt = $pdo->prepare("SELECT * FROM gs_bmkadai_table");

//3. 実行
$status = $stmt->execute();

//4．データ表示
$view="";
if($status==false) {
    //execute（SQL実行時にエラーがある場合）
  // $error = $stmt->errorInfo();
  // exit("ErrorQuery:".$error[2]);
  sql_error($stmt);

}else{
  //Selectデータの数だけ自動でループしてくれる
//   FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php
  while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){ 
    $view .= "<p>";
    $view .= '<a href="detail.php?id='.$result['id'].'">';
    $view .= $result['indate'].' : '.$result['book'].' : '.$result['URL'].' : '.$result['comment'];
    $view .= "</a>";
    $view .= '<a href="delete.php?id='.$result['id'].'">';
    $view .= '[ 削除 ]';
    $view .= "</a>";
    $view .= "</p>";
  }
// var_dump($result); なぜ'url'だけundefindなのか、ループ関数で一つにまとめている？項目名個別に抜き出す方法もどうやる？
// 上記url問題はURL表記を大文字にしたところ解決。phpAdminでテーブルの項目名見たところURLだけ自動で大文字になっていたのでそれに対応してみた所、正しく表示された。
}
?>


<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>ブックマーク</title>
<link rel="stylesheet" href="css/range.css">
<link href="css/bootstrap.min.css" rel="stylesheet">
<style>div{padding: 10px;font-size:16px;}</style>
</head>
<body id="main">
<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">
      <a class="navbar-brand" href="index.php">データ登録</a>
      </div>
    </div>
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<div>
    <div class="container jumbotron"><?= $view ?></div>
</div>
<!-- Main[End] -->

</body>
</html>
