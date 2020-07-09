<?php
	session_start(); // セッションの開始
	include('inc_functions.php'); // 関数ファイル読み込み
	fn_check_session_id(); // idチェック関数の実行
?>
<?php
	//ユーザー情報取得（ssnは_SESSIONの意）
	$ssn_user_id=$_SESSION['user_id'];//ユーザーid
	$ssn_user_name=$_SESSION['user_name'];//ユーザー名
?>
<!DOCTYPE html>
<html lang='ja'>

<head>
	<meta charset='UTF-8'>
	<meta name='viewport' content='width=device-width, initial-scale=1.0'>
	<title>ToDo Manager</title>
	<link rel='stylesheet' type='text/css' href='css/reset.css' />
	<link rel='stylesheet' type='text/css' href='css/sanitize.css' />
	<link rel='stylesheet' type='text/css' href='css/style.css' />
</head>

<body>
	<form action='todo_input_act.php' method='POST'>
		<fieldset>
			<legend>ToDo新規入力（<?= $ssn_user_id ?> <?= $ssn_user_name ?>）</legend>
			<a href='todo_read.php'>ToDoリスト</a>
			<a href='todo_logout.php'>ログアウト</a>
			<div>
				締切日: <input type='date' name='tdt_deadline'>
			</div>
			<div>
				ToDo: <input type='text' class='txt_todo' name='txt_todo'>
			</div>
			<div>
				<button>ToDo登録</button>
			</div>
		</fieldset>
	</form>

</body>

</html>