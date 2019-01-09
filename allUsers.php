<?php 
require_once 'db.php';
$db = new Database;
$newpic="";
session_start();
global $db;
$usrData=$_SESSION['username'];
$isadmin=$db->query("SELECT * FROM `user` WHERE `id`=1");
$isadmin=$isadmin[0];
// print_r($usrData);
// print_r($isadmin["username"]);
if(  ($isadmin['username']!=$usrData) and ($isadmin['email']!=$usrData)    ){
                header('Location: sign.php');
            }

$allUsersPrint=$db->query("SELECT `id`, `username`, `name`, `l_name`, `email`, `sex`, `age`,`reg_time`,`last_log` FROM `user` WHERE `id`!=1 ORDER BY `id` DESC");

function print_row(&$item) {
  echo('<tr>');
  array_walk($item, 'print_cell');
  echo('</tr>');
}

function print_cell(&$item) {
  echo('<td  class="table_block">');
  echo("&nbsp".$item."&nbsp");
  echo('</td>');
}
 ?>


 <!DOCTYPE html>
 <html lang="en">
 <head>
 	<meta charset="UTF-8">
 	<title>Document</title>
 	<link rel="stylesheet" href="allusers.css">
 </head>
 <body>
 	<style type="text/css">
	          .table_block{ border-radius: 25px; border-style: solid; text-align: center;}
	</style>
 	<div class="flexConteiner">
	 	<div class="clearfix">
	    <form action="admin.php?inchinch=$arjeq" method="POST"> 
	        <button   type="submit" class="signupbtn" name="TakeaNewPic">Գլխավոր էջ
	        <input  type="hidden" name="takeNewPic">
	        </button>
	    </form><br><br><br><br>
	    </div>
	 	<table>
	 		<tr class="values">
		  			<td>&nbspՀ/Հ&nbsp</td>
			  		<td>&nbspՄՈՒՏՔԱՆՈՒՆ&nbsp</td>
			  		<td>&nbspԱՆՈՒՆ&nbsp</td>
			  		<td>&nbspԱԶԳԱՆՈՒՆ&nbsp</td>
					<td>&nbspԷԼԵԿՏՐՈՆԱՅԻՆ ՀԱՍՑԵ&nbsp</td>
			  		<td>&nbspՍԵՌ&nbsp</td>
			  		<td>&nbspՏԱՐԻՔ&nbsp</td>
			  		<td>&nbspՎԵՐՋԻՆ ՄՈՒՏՔԸ&nbsp</td>
			  		<td>&nbspԳՐԱՆՑՎԵԼ Է&nbsp</td>
		  		<tr>
		  <?php array_walk($allUsersPrint, 'print_row');?>
		</table>
	</div>
 </body>
 </html>