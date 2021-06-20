<?php

/**
 * author:shawn
 * data:2021
 */

	require('./config/database.php');
	//session存储路径
	session_save_path('./config/sessions');
	session_start();


	//检查SESSION	
	if(!empty($_SESSION['USER']) && $_SESSION['USER'] == md5($usr.time()) && ip2long($_SERVER['REMOTE_ADDR'] == $ip)){
		
	}else{
		header("location:./");
	}