<?php
	session_start(); // セッションの開始
	include('inc_functions.php'); // 関数ファイル読み込み
	fn_check_session_id(); // idチェック関数の実行
?>
<?php
	// 送信確認
	// var_dump($_POST);exit();

	//ユーザー情報取得（ssnは_SESSIONの意）
	$ssn_user_id=$_SESSION['user_id'];//ユーザーid

	// 項目入力のチェック
	// 値が存在しないor空で送信されてきた場合はNGにする
	if(!isset($_POST['txt_todo']) || $_POST['txt_todo'] == '' 
		||!isset($_POST['tdt_deadline']) || $_POST['tdt_deadline'] == ''){// 項目が入力されていない場合はここでエラーを出力し，以降の処理を中止する
		echo json_encode(["error_msg" => "no input"]);
		exit();
	}

	// 受け取ったデータを変数に入れる
	$txt_todo=$_POST['txt_todo'];
	$tdt_deadline=$_POST['tdt_deadline'];

	// DB接続
	$pdo=fn_connect_to_db();

	// データ登録SQL作成
	// `created_at`と`updated_at`には実行時の`sysdate()`関数を用いて実行時の日時を入力する
	$sql='INSERT INTO todo_tbl(sn,user_id, todo, deadline, created_at, updated_at) VALUES(NULL,:user_id,:todo,:deadline,sysdate(),sysdate())';

	// SQL準備&実行
	$stmt=$pdo->prepare($sql);
	$stmt->bindValue(':user_id',$ssn_user_id,PDO::PARAM_STR);
	$stmt->bindValue(':todo',$txt_todo,PDO::PARAM_STR);
	$stmt->bindValue(':deadline',$tdt_deadline,PDO::PARAM_STR);
	$status=$stmt->execute();

	// データ登録処理後
	if($status==false){
		// SQL実行に失敗した場合はここでエラーを出力し，以降の処理を中止する
		$error=$stmt->errorInfo();
		echo json_encode(["error_msg" => "{$error[2]}"]);
		exit();
	} else {
		// 正常にSQLが実行された場合は入力ページファイルに移動し，入力ページの処理を実行する
		header("Location:todo_input.php");
		exit();
	}
