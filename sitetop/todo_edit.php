<?php
	session_start(); // セッションの開始
	include('inc_functions.php'); // 関数ファイル読み込み
	fn_check_session_id(); // idチェック関数の実行
?>
<?php
	// 送信データのチェック
	// var_dump($_GET);exit();

	//ユーザー情報取得（ssnは_SESSIONの意）
	$ssn_user_id=$_SESSION['user_id'];//ユーザーid
	$ssn_user_name=$_SESSION['user_name'];//ユーザー名
	$get_sn=$_GET['sn'];

	$pdo=fn_connect_to_db();

	// データ取得SQL作成
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
	 	$asc_rec=$stmt->fetch(PDO::FETCH_ASSOC);
	}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
	<meta charset='UTF-8'>
	<meta name='viewport' content='width=device-width, initial-scale=1.0'>
	<title>ToDo Manager</title>
	<link rel='stylesheet' type='text/css' href='css/reset.css' />
	<link rel='stylesheet' type='text/css' href='css/sanitize.css' />
	<link rel='stylesheet' type='text/css' href='css/style.css' />
</head>

<body>
	<form action='todo_edit_act.php' method='POST'>
		<fieldset>
			<legend>ToDo編集（<?= $ssn_user_id ?> <?= $ssn_user_name ?>）</legend>
			<a href='todo_read.php'>ToDoリスト</a>
			<div>
				締切日: <input type='date' name='tdt_deadline' value="<?= $asc_rec["deadline"] ?>">
			</div>
			<div>
				ToDo: <input type='text' class='txt_todo' name='txt_todo' value="<?= $asc_rec["todo"] ?>">
			</div>
			<div>
				<button>編集結果を登録</button>
			</div>
			<input type='hidden' name='hdn_sn' value="<?= $asc_rec["sn"] ?>">
		</fieldset>
	</form>
</body>
</html>