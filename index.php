<?php

if(isset($_SESSION['username'])){
        header('Location: sign.php');
} 
$config = require_once 'config.php';

    try {
		$dsn = 'mysql:host='.$config['host'];
        $dbh = new PDO($dsn,  $config['username'], $config['password']);

        $dbh->exec("CREATE DATABASE IF NOT EXISTS `test_pdo`;
		        		USE `test_pdo`;
		                CREATE TABLE IF NOT EXISTS `user` (
						        `id` INT(11) NOT NULL AUTO_INCREMENT,
								`username` VARCHAR(255) NOT NULL,
								`password` VARCHAR(255) DEFAULT NULL,
								`age` INT(3) DEFAULT NULL,
								`sex` VARCHAR(25) DEFAULT NULL,
								`email` VARCHAR(50) NOT NULL,
								`name` VARCHAR(255) DEFAULT NULL,
								`l_name` VARCHAR(255) DEFAULT NULL,
								`usrpic` VARCHAR(255) DEFAULT 'unknown.png',
								`last_log` VARCHAR(255) DEFAULT NULL,
								`reg_time` VARCHAR(255) DEFAULT NULL,
								PRIMARY KEY (`id`),
								UNIQUE KEY (`username`,`email`)
						) ENGINE=INNODB DEFAULT CHARSET=utf8;
						
						CREATE TABLE IF NOT EXISTS `messages` (
								`id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
								`from` INT(11) NOT NULL,
								`to` INT(11) NOT NULL,
								`message` TEXT NOT NULL,
								`send_time` VARCHAR(60) NOT NULL,
								PRIMARY KEY (`id`)
						) ENGINE=INNODB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8
					") ;

        		

        $dbh->exec("INSERT IGNORE INTO `user` SET `username`= 'admin1234',`password` = 'admin1234' ,`age`= '22' ,`sex`= 'male', `email`= 'Nshan.Vardanyan.1996@gmail.com',`name`= 'Nshan',`l_name`= 'Vardanyan' ");
        $dbh->exec("INSERT IGNORE INTO `user` SET `username`= 'Nshan0102',`password` = 'Nshan0102' ,`age`= '22' ,`sex`= 'male', `email`= 'Nshan.Vardanyan.1996@mail.ru',`name`= 'Nshan',`l_name`= 'Vardanyan' ");
        $dbh->exec("INSERT IGNORE INTO `user` SET `username`= 'Vardan0102',`password` = 'Vardan0102' ,`age`= '22' ,`sex`= 'male', `email`= 'Vardan.Vardanyan.1996@gmail.com',`name`= 'Vardan',`l_name`= 'Vardanyan' ");
        //or die(print_r($dbh->errorInfo(), true));

    } catch (PDOException $e) {
        //die("DB ERROR: ". $e->getMessage());
    }
    header("Location: sign.php")
?>