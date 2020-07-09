<?php
	session_start(); // セッションの開始
	include('inc_functions.php'); // 関数ファイル読み込み
	fn_check_session_id(); // idチェック関数の実行
	//die(var_dump($g_asc_day));
?>
<?php

	// DB接続
	$pdo=fn_connect_to_db();
	
	//ユーザー情報取得（ssnは_SESSIONの意）
	$ssn_user_id=$_SESSION['user_id'];//ユーザーid
	$ssn_user_name=$_SESSION['user_name'];//ユーザー名
	$ssn_is_admin=$_SESSION['is_admin'];//管理者か？

	//①他ユーザーデータ取得SQL作成-----------------------------------------------------------------
	$sql='SELECT * FROM user_tbl WHERE user_id<>:user_id ORDER BY user_id';
	// SQL準備&実行
	$stmt=$pdo->prepare($sql);
	$stmt->bindValue(':user_id',$ssn_user_id,PDO::PARAM_STR);
	$status=$stmt->execute();
	if($status==false) {
		// SQL実行に失敗した場合はここでエラーを出力し，以降の処理を中止する
		$error=$stmt->errorInfo();
		echo json_encode(['error_msg' => "{$error[2]}"]);
		exit();
	}else{
		$ary_result=$stmt->fetchAll(PDO::FETCH_ASSOC);// データの出力用変数（初期値は空文字）を設定
		$asc_user=array();//「user_id=>user_name」形式
		foreach ($ary_result as $asc_rec){
			$asc_user[$asc_rec['user_id']]=$asc_rec['user_name'];
		}
	}

	//②ToDoデータ取得SQL作成-----------------------------------------------------------------
	$sql='SELECT * FROM todo_tbl WHERE user_id=:user_id AND is_eliminated=false ORDER BY deadline';
	// SQL準備&実行
	$stmt=$pdo->prepare($sql);
	$stmt->bindValue(':user_id',$ssn_user_id,PDO::PARAM_STR);
	$status=$stmt->execute();
	// データ登録処理後
	if($status==false) {
		// SQL実行に失敗した場合はここでエラーを出力し，以降の処理を中止する
		$error=$stmt->errorInfo();
		echo json_encode(['error_msg' => "{$error[2]}"]);
		exit();
	}else{
		//管理者なら
		$link_user_register='';
		if($ssn_is_admin)$link_user_register='管理者操作：<a href="user_register.php">新規ユーザー登録</a>';

		// 正常にSQLが実行された場合は入力ページファイルに移動し，入力ページの処理を実行する
		// fetchAll()関数でSQLで取得したレコードを配列で取得できる
		$ary_result=$stmt->fetchAll(PDO::FETCH_ASSOC);// データの出力用変数（初期値は空文字）を設定
		$output='';
		// <tr><td>deadline</td><td>todo</td><tr>の形になるようにforeachで順番に$outputへデータを追加
		// `.=`は後ろに文字列を追加する，の意味
		foreach ($ary_result as $asc_rec){
			$deadline=fn_addColoredDayToDate($asc_rec['deadline']);//曜日を色付きで付加
			//
			$output.='<tr>';
			$output.="<td>{$deadline}</td>";
			$output.="<td>{$asc_rec["todo"]}</td>";
			$output.="<td>{$asc_rec["created_at"]}</td>";
			$output.="<td>{$asc_rec["updated_at"]}</td>";
			//操作を追加
			$output.='<td>';
			$output.='<select id="slt_act_todo">';
			$output.='<option value="top">（処理を選択）</option>';
			$output.='<option value="edit_'.$asc_rec['sn'].'">編集</option>';
			$output.='<option value="copy_'.$asc_rec['sn'].'">コピーして新規作成</option>';
			$output.='<option value="eliminate_'.$asc_rec['sn'].'">除外（論理削除）</option>';
			
			$output.='</td>';
			$output.='</tr>';
		}
		// $ary_resultの参照を解除する．解除しないと，再度foreachした場合に最初からループしない
		// 今回は以降foreachしないので影響なし
		unset($ary_result);
	}

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
	<fieldset>
		<legend>ToDoリスト（<?= $ssn_user_id ?> <?= $ssn_user_name ?>）</legend>
		<a href='todo_input.php'>ToDo新規追加</a>
		<a href='todo_read_eliminated.php'>除外リスト表示</a>
		<a href='todo_logout.php'>ログアウト</a>
		<?= $link_user_register ?>
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
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script>
		$(document).on('change','#slt_act_todo',function(){
			const slt_val=$(this).val();//「act_sn」形式（act:edit/copy/eliminate）
			const ary_val=slt_val.split('_');//デリミタ「_」分割
			const i_length_ary_val=ary_val.length;
			if(i_length_ary_val==2){//「act_sn」形式なら
				const url='todo_'+ary_val[0]+'.php?sn='+ary_val[1];
				//alert(url);
				window.location.href=url;//ページ遷移
			}
		});
  </script>
</body>

</html>