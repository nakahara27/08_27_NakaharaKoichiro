<!DOCTYPE html>
<html lang='ja'>

<head>
	<meta charset='UTF-8'>
	<meta name='viewport' content='width=device-width, initial-scale=1.0'>
	<title>ToDo Manager</title>
</head>

<body>
	<form action='user_register_act.php' method='POST'>
		<fieldset>
			<legend>新規ユーザ登録</legend>
			<div>
				ユーザid: <input type='text' name='txt_user_id'>
			</div>
			<div>
				ユーザ名: <input type='text' name='txt_user_name'>
			</div>
			<div>
				パスワード: <input type='text' name='txt_password'>
			</div>
			<div>
				<button>新規登録</button>
			</div>
		</fieldset>
	</form>
</body>
</html>