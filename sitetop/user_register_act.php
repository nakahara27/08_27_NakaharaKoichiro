<?php
	session_start(); // セッションの開始
	include('inc_functions.php'); // 関数ファイル読み込み
	fn_check_session_id(); // idチェック関数の実行
?>
<?php
	//var_dump($_POST);exit();

	// データ受け取り
	$txt_user_id=$_POST["txt_user_id"];
	$txt_user_name=$_POST["txt_user_name"];
	$txt_password=$_POST["txt_password"];

	// DB接続関数
	$pdo=fn_connect_to_db();

	// ユーザ存在有無確認
	$sql='SELECT COUNT(*) FROM user_tbl WHERE user_id=:user_id';

	$stmt=$pdo->prepare($sql);
	$stmt->bindValue(':user_id', $txt_user_id, PDO::PARAM_STR);
	$status=$stmt->execute();

	if($status==false){
		// SQL実行に失敗した場合はここでエラーを出力し，以降の処理を中止する
		$error=$stmt->errorInfo();
		echo json_encode(["error_msg" => "{$error[2]}"]);
		exit();
	}

	if($stmt->fetchColumn()>0){
		// user_idが1件以上該当した場合はエラーを表示して元のページに戻る
		// $count=$stmt->fetchColumn();
		echo '<p>すでに登録されているユーザです</p>';
		echo '<a href="user_register.php">戻る</a>';
		exit();
	}

	// ユーザ登録SQL作成
	$sql='INSERT INTO user_tbl(user_id,password,user_name,is_admin) VALUES(:user_id,:password,:user_name,false)';

	// SQL準備&実行
	$stmt=$pdo->prepare($sql);
	$stmt->bindValue(':user_id',$txt_user_id,PDO::PARAM_STR);
	$stmt->bindValue(':user_name',$txt_user_name,PDO::PARAM_STR);
	$stmt->bindValue(':password',$txt_password,PDO::PARAM_STR);
	$status=$stmt->execute();

	// データ登録処理後
	if ($status == false) {
		// SQL実行に失敗した場合はここでエラーを出力し，以降の処理を中止する
		$error=$stmt->errorInfo();
		echo json_encode(["error_msg" => "{$error[2]}"]);
		exit();
	} else {
		// 正常にSQLが実行された場合はログインページファイルに移動
		header("Location:todo_read.php");
		exit();
	}
