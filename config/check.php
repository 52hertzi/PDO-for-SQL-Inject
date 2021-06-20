<?php

/**
 * author:shawn
 * data:2021
 */

	header('conotent-type:text/html;charset=utf-8');
	require_once("./config/database.php");

	//检查账户是否锁定，1为锁定
	if($status == 1){
		//判断时间是否过时
		if($lock_data - strtotime(date("Y-m-d H:i:s"))  <= 0){
			//取消锁定以及清空登陆失败次数
			try{
				$pdo -> beginTransaction();
				$sql_1 = "UPDATE user SET status = 0 , err_time = 0  WHERE id = 1";
				$affetedROW = $pdo -> exec($sql_1);
				if(!$affetedROW){
					throw new PDOException("状态码更新失败");
				}
				$pdo -> commit();
				}catch(PDOException $e){
					echo $e -> getMessage();
				}
		}else{
			$stay_time = $lock_data - strtotime(date("Y-m-d H:i:s"));
			echo "<script>alert('账户已锁定，5分钟后请重试！剩余时间".$stay_time."');window.history.back(-1);</script>";
		}
	}else{
		//检查当前登陆ip是否存在于黑名单
		try{
			$client_ip = ip2long($_SERVER["REMOTE_ADDR"]);
			$black_ip_sql = "SELECT ip FROM black_list WHERE ip = '{$client_ip}'";
			$stmt = $pdo -> query($black_ip_sql);
			if($stmt -> rowCount()){
				echo "<script>alert('登陆失败!');window.history.back(-1);</script>";
			}else{
				header("location:./public/index.php");
			}
		}catch(PDOException $ee){
			echo $ee -> getMessage();
			}

		}
	

