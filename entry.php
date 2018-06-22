<?php
//Git すげええええええ
require 'specialchar.php';
$name = '';                                                                     //初期化
$tell = '';                                                                     //初期化
$mail = '';                                                                     //初期化
session_start();
if(isset($_SESSION['prof'])){                                                   //確認画面から戻ってきた場合にテキストボックスに入る値
  $name = $_SESSION['prof']['name'];
  $tell = $_SESSION['prof']['tell'];
  $mail = $_SESSION['prof']['mail'];
}
$_SESSION = array();                                                            //セッション削除
if(isset($_COOKIE[SESSION_name()])){
  setcookie(session_name(),'',time()-42000);
}
session_destroy();

$err = array();                                                                 //それぞれのエラー用の配列生成
$err['name'] = '';
$err['tell'] = '';
$err['mail'] = '';

if(isset($_GET['name']) && isset($_GET['tell']) && isset($_GET['mail'])){       //送信ボタンをクリックされこのページに来た時値を格納
  $name = $_GET['name'];
  $tell = $_GET['tell'];
  $mail = $_GET['mail'];

  if($tell != ''){                                                              //電話番号のエラーチェック
    if(is_numeric($tell)){                                                      //数字であるかのチェック
      if(9 > strlen($tell) || strlen($tell) > 12){                              //数字であり9~12桁の数字であるかのチェック
        $err['tell'] = '9~12桁で入力してください。';
      }
    }else{                                                                      //数字出ない場合
      $err['tell'] = '半角数字を入力してください。ハイフンはいりません。';
    }
  }else{                                                                        //未入力のチェック
    $err['tell'] = '未入力です。';
  }

  if($mail != ''){                                                              //メールアドレスのエラーチェック
    if(!strpos($mail,'@')){                                                     //＠があるかのチェック
      $err['mail'] = '@も入力してください。';
    }
  }else{                                                                        //未入力のチェック
    $err['mail'] = '未入力です。';
  }

  if($name == ''){                                                              //氏名のエラーチェック
    $err['name'] = '未入力です。';
  }elseif(strpos($name,',')){
    $err['name'] = '使用できない文字が含まれています';
  }

  if($err['name'] == '' && $err['tell'] == '' && $err['mail'] == ''){           //エラーがない場合登録確認画面に飛ばす
    session_start();
    $_SESSION['prof'] = $_GET;                                                  //セッションに氏名、電話番号、メールアドレス格納
    header('Location: check.php');
    exit();
  }
}
?>
