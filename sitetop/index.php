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
	<form action='todo_login_act.php' method='POST'>
		<fieldset>
			<legend>ToDo Manager</legend>
			<div>
				ユーザーID: <input type='text' name='txt_user_id'>
			</div>
			<div>
				パスワード: <input type='password' name='txt_password'>
			</div>
			<div>
				<button>ログイン</button>
			</div>
		</fieldset>
	</form>
</body>
</html>