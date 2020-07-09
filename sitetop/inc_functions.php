<?php

	//-----------------------------------------------------------------------------------------------
	function fn_addColoredDayToDate($a_date){//曜日を色付きで付加
		$asc_day=array(
			'0'=>'日','1'=>'月','2'=>'火','3'=>'水','4'=>'木','5'=>'金','6'=>'土'
		);

		$ary_holiday=array(
			'2020-01-01',//元旦
			'2020-01-13',//成人の日
			'2020-02-11',//建国記念の日
			'2020-02-23',//天皇誕生日
			'2020-02-24',//振替休日
			'2020-03-20',//春分の日
			'2020-04-29',//昭和の日
			'2020-05-03',//憲法記念の日
			'2020-05-04',//みどりの日
			'2020-05-05',//こどもの日
			'2020-05-06',//振替休日
			'2020-07-23',//海の日
			'2020-07-24',//スポーツの日
			'2020-08-10',//山の日
			'2020-09-21',//敬老の日
			'2020-09-22',//秋分の日
			'2020-11-03',//文化の日
			'2020-11-23',//勤労感謝の日
		);
		//
		$date=$a_date;//戻り値 初期化
		//
		$no_day=date('w',strtotime($date));//曜日No（日=0 土=6）
		//$date.='('.date('w',strtotime($date)).')';
		if(in_array($date,$ary_holiday,true)){
			$date.='(<span class="spn_holiday">'.$asc_day[$no_day].'</span>)';
		}else if($no_day==0){//日曜日
			$date.='(<span class="spn_sun">'.$asc_day[$no_day].'</span>)';
		}else if($no_day==6){//土曜日
			$date.='(<span class="spn_sat">'.$asc_day[$no_day].'</span>)';
		}else{//平日
			$date.='('.$asc_day[$no_day].')';
		}
		//
		return $date;
	}


	//-----------------------------------------------------------------------------------------------
	function fn_connect_to_db(){
		// DB接続の設定
		// DB名は`gsacf_x00_00`にする
		$dbn='mysql:dbname=kadai_08_27;charset=utf8;port=3306;host=localhost';
		$user='root';
		$pwd='';

		try{
			// ここでDB接続処理を実行する
			return new PDO($dbn, $user, $pwd);
		} catch (PDOException $e) {
			// DB接続に失敗した場合はここでエラーを出力し，以降の処理を中止する
			echo json_encode(["db error" => "{$e->getMessage()}"]);
			exit();
		}
	}

	//-----------------------------------------------------------------------------------------------
	// ログイン状態のチェック関数
	function fn_check_session_id(){
		// 失敗時はログイン画面に戻る（セッションidがないor一致しない）
		if(!isset($_SESSION['session_id']) ||
			$_SESSION['session_id']!=session_id()) {
			header('Location: index.php'); // ログイン画面へ移動
		}else{
			session_regenerate_id(true); // セッションidの再生成
			$_SESSION['session_id']=session_id(); // セッション変数に格納
		}
	}

