<?php

/**
 * author:shawn
 * data:2021
 */
	require('./config/database.php');

	date_default_timezone_set('PRC');
	$Now_data = date("y-m-d H:i:s");
	//获取当前用户ip
	$Now_ip = ip2long($_SERVER["REMOTE_ADDR"]);
	//获取登陆失败次数，并匹配黑名单，存在黑名单封ip
	if($err_time == 3 && $status == 0){
		//检测登陆ip是否为上次成功登陆ip
		if($Now_ip == $ip){
			//添加等待机制时间戳,5分钟 
			$timi = strtotime(date("Y-m-d H:i:s")+300);
			try{
				//开启事务
				$pdo -> beginTransaction();
				$sql_5 = "UPDATE user SET status = 1,lock_data = '{$timi}' WHERE id = 1";
				$affectedROW = $pdo -> exec($sql_5);
				//抛出异常
				if(!$affectedROW){
					throw new PDOException("状态码与锁定时间更新失败");
				}
				$pdo -> commit();
			}catch(PDOException $r){
				echo $r -> getMessage();
			}
		}else{
			try{
				$sql_6 = "SELECT ip,time FROM black_list WHERE ip = '{$Now_ip}'";
				$stmt = $pdo -> query($sql_6);
				if($stmt -> rowCount()){ 
					$stmt -> bindColumn("time",$time);
					$stmt -> fetch(PDO::FETCH_ASSOC);
					//更新该ip尝试登陆次数
					$tim = $time + 1;
					try{
						$pdo -> beginTransaction();
						$sql_7 = "UPDATE black_list SET time = '{$tim}' ,add_data = '{$Now_data}'WHERE ip = '{$Now_ip}'";
						$affectedROW = $pdo -> exec($sql_7);
						if(!$affectedROW){
							throw new PDOException("黑名单ip登陆次数更新失败");
						}
						$pdo -> commit();
					}catch(PDOException $aa){
						echo $aa -> getMessage();
					}
					echo "<script>alert('登陆失败!');window.history.back(-1);</script>";
				}else{
					//添加黑名单
					try{
						$sql_3 = "INSERT INTO black_list (ip,add_data) VALUE(?,?)";
						$stmt = $pdo -> prepare($sql_3);
						//绑定参数
						$stmt -> bindParam(1,$ips);
						$stmt -> bindParam(2,$add_data);
						$ips = $Now_ip;
						$add_data = date("y-m-d H:i:s");
						$stmt -> execute();
					}catch(PDOException $e){
						echo $e -> getMessage();
					}
					echo "<script>alert('登陆失败!');window.history.back(-1);</script>";
				}
			}catch(PDOException $e){
				echo $e -> getMessage();
			}
		}
	}else{
		if($err_time < 4){
			$error_time = $err_time + 1;
			try{
				$pdo -> beginTransaction();
				$sql_4 = "UPDATE user SET err_time = '{$error_time}' WHERE id = 1";
				$affectedROW = $pdo -> exec($sql_4);
				if(!$affectedROW){
					throw new PDOException("登陆失败次数更新失败");
				}
				$pdo -> commit();
			}catch(PDOException $a){
				echo $a -> getMessage();
			}
			echo "<script>alert('登陆失败');window.history.back(-1);</script>";
		}else{
			echo "<script>alert('账户已锁定');window.history.back(-1);</script>";

		}
		
	}
	
	

?>