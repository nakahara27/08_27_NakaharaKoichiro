<?php
	session_start(); // セッションの開始
	include('inc_functions.php'); // 関数ファイル読み込み
	fn_check_session_id(); // idチェック関数の実行
?>
<?php
	// 送信データのチェック
	//var_dump($_GET);exit();

	// 送信データ受け取り
	$get_sn=$_GET['sn'];
	$get_user_id=$_GET['user_id'];

	// DB接続
	$pdo=fn_connect_to_db();

	//①コピー元ToDo情報取得-------------------------------------------------------------------------
	$sql='SELECT * FROM todo_tbl WHERE sn=:sn';
	// SQL準備&実行
	$stmt=$pdo->prepare($sql);
	$stmt->bindValue(':sn', $get_sn, PDO::PARAM_INT);
	$status=$stmt->execute();
	// データ登録処理後
	if($status==false){
		// SQL実行に失敗した場合はここでエラーを出力し，以降の処理を中止する
		$error=$stmt->errorInfo();
		echo json_encode(['error_msg'=>"{$error[2]}"]);
		exit();
	} else {
		// 正常にSQLが実行された場合は指定の11レコードを取得
		// fetch()関数でSQLで取得したレコードを取得できる
	 	$asc_user_id=$stmt->fetch(PDO::FETCH_ASSOC);
	}

	//②ToDoコピー文を作成&実行----------------------------------------------------------------------
	$sql='INSERT INTO todo_tbl(sn,user_id, todo, deadline, created_at, updated_at) VALUES(NULL,:user_id,:todo,:deadline,sysdate(),sysdate())';
	// SQL準備&実行
	$stmt=$pdo->prepare($sql);
	$stmt->bindValue(':user_id',$get_user_id,PDO::PARAM_STR);
	$stmt->bindValue(':todo',$asc_user_id['todo'],PDO::PARAM_STR);
	$stmt->bindValue(':deadline',$asc_user_id['deadline'],PDO::PARAM_STR);
	$status=$stmt->execute();

	// データ登録処理後
	if($status==false) {
		// SQL実行に失敗した場合はここでエラーを出力し，以降の処理を中止する
		$error=$stmt->errorInfo();
		echo json_encode(['error_msg' => "{$error[2]}"]);
		exit();
	}else{
		// 正常にSQLが実行された場合は一覧ページファイルに移動し，一覧ページの処理を実行する
		header('Location:todo_read.php');
		exit();
	}