<?php 

/**
 * author:shawn
 * data:2021
 */
	

	//设置时间为24小时制
	date_default_timezone_set('PRC');
	
	$user_name = trim($_POST['username']);
	$pass_wd = md5(trim($_POST['password']));
	
	if(isset($_POST)){
		if(empty($user_name) || empty($pass_wd)){
			echo "<script>alert('账号或密码为空！');window.history.back(-1);</script>";
		}else{
			include_once('./config/database.php');
			if($usr == $user_name && $pwd == $pass_wd){
				include_once('./config/check.php');
				//设置session
				session_start();
				$_SESSION['USER'] = md5($usr.time());
				//获取当前客户端ip，转换为ip使用2iplong
				$Nip = ip2long($_SERVER["REMOTE_ADDR"]);
				$Time = date("y-m-d H:i:s");
				try{
					$pdo -> beginTransaction();
					$sql_2 = "UPDATE user SET ip = '{$Nip}' , success_data = '{$Time}' , err_time = 0  WHERE id = 1";
					$affetedROW = $pdo -> exec($sql_2);
					if(!$affetedROW){
						throw new PDOException("ip,时间更新失败");
					}
					$pdo -> commit();
				}catch(PDOException $hh){
					echo $hh -> getMessage();
				}
			}else{
				include('./config/loginerror.php');
			}
		}
	}