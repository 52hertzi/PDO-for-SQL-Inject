<?php
/**
 * author:shawn
 * data:2021
 */

	header('conotent-type:text/html;charset=utf-8');
	
	$dbms = 'mysql';
	$host = 'localhost';
	$port = '3306';
	$dbname = 'admin';
	$charset = 'utf8';
	$usrname = 'root';
	$passwd = 'c3086167e26bcf11';

$dsn="$dbms:host=$host;port=$port;dbname=$dbname;charset=$charset";

try{
	$pdo = new PDO($dsn,$usrname,$passwd);
	//异常处理模式
	$pdo -> setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	$sql = "SELECT username,password,err_time,ip,status,lock_data,success_data FROM user WHERE id=1"; 
	$stmt = $pdo -> query($sql);
	if($stmt -> rowCount()){
		//绑定字段
		$stmt -> bindColumn("username",$usr);
		$stmt -> bindColumn("password",$pwd);
		$stmt -> bindColumn("err_time",$err_time);
		$stmt -> bindColumn("ip",$ip);
		$stmt -> bindColumn("status",$status);
		$stmt -> bindColumn("lock_data",$lock_data);
		$stmt -> bindColumn("success_data",$success_data);
		$stmt -> fetch(PDO::FETCH_ASSOC);
	}
}catch(PDOException $e){
	echo 'DB Connect Fail'.$e -> getMessage();
}
	
	
	