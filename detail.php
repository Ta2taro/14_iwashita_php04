<?php
session_start();


//selsect.phpから処理を持ってくる
//1.外部ファイル読み込みしてDB接続(funcs.phpを呼び出して)
require_once('funcs.php');

loginCheck();


//2.対象のIDを取得
$id = $_GET['id'];
$pdo = db_conn();


//3．データ取得SQLを作成（SELECT文）
$stmt = $pdo->prepare("SELECT * FROM gs_bmkadai_table WHERE id=:id");
$stmt->bindValue(':id',$id,PDO::PARAM_INT);
$status = $stmt->execute();

//4．データ表示
if($status == false){
    //execute（SQL実行時にエラーがある場合）
    // $error = $stmt->errorInfo();
    // exit("ErrorQuery:".$error[2]);
    sql_error($stmt);

}else{
    $result = $stmt->fetch();
    // var_dump($result);
}

?>

<!-- 以下はindex.phpのHTMLをまるっと持ってくる -->
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>データ登録</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <style>div{padding: 10px;font-size:16px;}</style>
</head>
<body>

<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
    <div class="navbar-header"><a class="navbar-brand" href="select.php">データ一覧</a></div>
    </div>
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<form method="POST" action="bm_update_view.php">
  <div class="jumbotron">
   <fieldset>
    <legend>データ更新</legend>
     <label>書籍名：<input type="text" name="book" value="<?= $result['book'] ?>"></label><br>
     <label>書籍URL：<input type="text" name="URL" value="<?= $result['URL'] ?>"></label><br>
     <label><textArea name="comment" rows="4" cols="40"><?= $result['comment'] ?></textArea></label><br>
     <input type="hidden" name="id" value="<?= $result['id'] ?>">
     <input type="submit" value="送信">
    </fieldset>
  </div>
</form>
<!-- Main[End] -->


</body>
</html>
