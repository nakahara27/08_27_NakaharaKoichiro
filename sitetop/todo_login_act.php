<?php
	session_start(); // セッションの開始
	include('inc_functions.php'); // 関数ファイル読み込み
	fn_check_session_id(); // idチェック関数の実行
?>
<?php
	session_start();
	//var_dump($_POST);exit();

	// DB接続します
	$pdo=fn_connect_to_db(); // DB接続

	// データ受け取り
	$txt_user_id=$_POST['txt_user_id']; // データ受け取り→変数に入れる
	$txt_password=$_POST['txt_password'];

	// データ取得SQL作成&実行
	$sql='SELECT * FROM user_tbl WHERE user_id=:user_id AND password=:password';
	$stmt=$pdo->prepare($sql);
	$stmt->bindValue(':user_id',$txt_user_id,PDO::PARAM_STR);
	$stmt->bindValue(':password',$txt_password,PDO::PARAM_STR);
	$status=$stmt->execute();

	// SQL実行時にエラーがある場合はエラーを表示して終了

	// うまくいったらデータ（1レコード）を取得
	$asc_rec=$stmt->fetch(PDO::FETCH_ASSOC);

	// ユーザ情報が取得できない場合はメッセージを表示
	if(!$asc_rec) {
		echo '<p>ログイン情報に誤りがあります．</p>';
		echo '<a href="index.php">login</a>';
		exit();
	}else{
		// ログインできたら情報をsession領域に保存して一覧ページへ移動
		$_SESSION=array(); // セッション変数を空にする
		$_SESSION['session_id']=session_id();
		$_SESSION['is_admin']=$asc_rec['is_admin'];
		$_SESSION['user_id']=$asc_rec['user_id'];
		$_SESSION['user_name']=$asc_rec['user_name'];
		header('Location:todo_read.php'); // 一覧ページへ移動
		exit();
	}
