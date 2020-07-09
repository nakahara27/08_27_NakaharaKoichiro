<?php
	session_start(); // セッションの開始
	include('inc_functions.php'); // 関数ファイル読み込み
	fn_check_session_id(); // idチェック関数の実行
?>
<?php
	// 送信データのチェック
	//var_dump($_POST);exit();

	// 送信データ受け取り
	$hdn_sn=$_POST['hdn_sn'];
	$txt_todo=$_POST['txt_todo'];
	$tdt_deadline=$_POST['tdt_deadline'];

	// DB接続
	$pdo=fn_connect_to_db();

	// UPDATE文を作成&実行
	$sql='UPDATE todo_tbl SET todo=:todo, deadline=:deadline, updated_at=sysdate() WHERE sn=:sn';

	$stmt=$pdo->prepare($sql);
	$stmt->bindValue(':todo',$txt_todo,PDO::PARAM_STR);
	$stmt->bindValue(':deadline',$tdt_deadline,PDO::PARAM_STR);
	$stmt->bindValue(':sn', $hdn_sn,PDO::PARAM_INT);
	$status=$stmt->execute();

	// データ登録処理後
	if($status==false){
		// SQL実行に失敗した場合はここでエラーを出力し，以降の処理を中止する
		$error=$stmt->errorInfo();
		echo json_encode(["error_msg" => "{$error[2]}"]);
		exit();
	}else{
		// 正常にSQLが実行された場合は一覧ページファイルに移動し，一覧ページの処理を実行する
		header('Location:todo_read.php');
		exit();
	}
