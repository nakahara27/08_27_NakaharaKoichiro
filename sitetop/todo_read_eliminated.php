<?php
	session_start(); // セッションの開始
	include('inc_functions.php'); // 関数ファイル読み込み
	fn_check_session_id(); // idチェック関数の実行
?>
<?php
	// DB接続
	$pdo=fn_connect_to_db();
	
	//ユーザーid取得
	$ssn_user_id=$_SESSION['user_id'];//ユーザーid
	$ssn_user_name=$_SESSION['user_name'];//ユーザー名

	// データ取得SQL作成
	$sql='SELECT * FROM todo_tbl WHERE user_id=:user_id AND is_eliminated=true ORDER BY deadline';

	// SQL準備&実行
	$stmt=$pdo->prepare($sql);
	$stmt->bindValue(':user_id',$ssn_user_id,PDO::PARAM_STR);
	$status=$stmt->execute();

	// データ登録処理後
	if($status==false) {
		// SQL実行に失敗した場合はここでエラーを出力し，以降の処理を中止する
		$error=$stmt->errorInfo();
		echo json_encode(["error_msg" => "{$error[2]}"]);
		exit();
	} else {
		// 正常にSQLが実行された場合は入力ページファイルに移動し，入力ページの処理を実行する
		// fetchAll()関数でSQLで取得したレコードを配列で取得できる
		$ary_result=$stmt->fetchAll(PDO::FETCH_ASSOC);	// データの出力用変数（初期値は空文字）を設定
		$output='';
		// <tr><td>deadline</td><td>todo</td><tr>の形になるようにforeachで順番に$outputへデータを追加
		// `.=`は後ろに文字列を追加する，の意味
		foreach ($ary_result as $asc_rec){
			$deadline=fn_addColoredDayToDate($asc_rec['deadline']);//曜日を色付きで付加
			//
			$output.="<tr>";
			$output.="<td>{$deadline}</td>";
			$output.="<td>{$asc_rec["todo"]}</td>";
			$output.="<td>{$asc_rec["created_at"]}</td>";
			$output.="<td>{$asc_rec["updated_at"]}</td>";
			// edit deleteリンクを追加
			$output.="<td><a href='todo_restore.php?sn={$asc_rec["sn"]}'>Todoに復活</a>　";
			$output.="<a href='todo_delete.php?sn={$asc_rec["sn"]}'>削除（物理削除）</a></td>";
			$output.="</tr>";
		}
		// $valueの参照を解除する．解除しないと，再度foreachした場合に最初からループしない
		// 今回は以降foreachしないので影響なし
		unset($ary_result);
	}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>ToDo Manager</title>
	<link rel='stylesheet' type='text/css' href='css/reset.css' />
	<link rel='stylesheet' type='text/css' href='css/sanitize.css' />
	<link rel='stylesheet' type='text/css' href='css/style.css' />
</head>

<body>
	<fieldset>
		<legend>除外されたToDoリスト（<?= $ssn_user_id ?> <?= $ssn_user_name ?>）</legend>
		<a href="todo_read.php">ToDoリストに戻る</a>
		<table>
			<thead>
				<tr>
					<th>締切日</th>
					<th>ToDo</th>
					<th>作成日時</th>
					<th>編集日時</th>
					<th>操作</th>
				</tr>
			</thead>
			<tbody>
				<!-- ここに<tr><td>deadline</td><td>todo</td><tr>の形でデータが入る -->
				<?= $output ?>
			</tbody>
		</table>
	</fieldset>
</body>

</html>