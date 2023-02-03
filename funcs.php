<?php
//共通に使う関数を記述

//XSS対応（ echoする場所で使用！それ以外はNG ）
function h($str)
{
    return htmlspecialchars($str, ENT_QUOTES);
}

// データベース接続関数
function db_conn(){
    try {
        $db_name = "tealcougar8_gs_bmkadai";    //データベース名
        $db_id   = "tealcougar8";      //アカウント名,XAMPPはすべてこの"root"
        $db_pw   = "ta2rofat";      //パスワード：XAMPPはパスワードなし
        $db_host = "mysql57.tealcougar8.sakura.ne.jp"; //DBホスト
        $db_port = "3306"; //XAMPPの管理画面からport番号確認
        $pdo = new PDO('mysql:dbname=' . $db_name . ';charset=utf8;host=' . $db_host.';port='.$db_port.'', $db_id, $db_pw);
        return $pdo;//ここを追加！！
      } catch (PDOException $e) {
          exit('DB Connection Error:' . $e->getMessage());
    }
}

//DB接続
// function db_conn(){
//     try {
//       $db_name = "gs_bmkadai";    //データベース名
//       $db_id   = "root";      //アカウント名
//       $db_pw   = "";      //パスワード：XAMPPはパスワードなしMAMPのパスワードはroot
//       $db_host = "localhost"; //DBホスト
//       $db_port = "3306"; //XAMPPの管理画面からport番号確認
//       $pdo = new PDO('mysql:dbname=' . $db_name . ';charset=utf8;host=' . $db_host.';port='.$db_port.'', $db_id, $db_pw);
//       return $pdo;//ここを追加！！
//     } catch (PDOException $e) {
//         exit('DB Connection Error:' . $e->getMessage());
//     }
//   }

  //SQLエラー
function sql_error($stmt){
    //execute（SQL実行時にエラーがある場合）
    $error = $stmt->errorInfo();
    exit("SQLError:".$error[2]);
}

//リダイレクト関数: redirect($file_name)
function redirect ($file_name){
    header('Location:'.$file_name);
    exit();
}

//ログインチェック
function loginCheck(){
    if( !isset($_SESSION['chk_ssid']) || $_SESSION['chk_ssid'] !=session_id() ){
     exit("Login Error");
    }else{
     session_regenerate_id(true);
     $_SESSION['chk_ssid'] = session_id();
    } 
}