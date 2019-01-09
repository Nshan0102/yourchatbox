<?php 
	session_start();
 	require_once 'db.php';
    $db = new Database;
    $usrData = $_SESSION['username'];
	$from = $db->query("SELECT * FROM `user` WHERE `username` = '$usrData' or `email` = '$usrData'; ");
	$from = $from[0];
	$page_title = $from;
	$from = $from['id'];
	$to;
	if(isset($_POST['msg_text'])){
	$text_msg = $_POST['msg_text'];
	}
	// print_r($from);
	$to="Myteam";
	/*if($from==2){
		$to = 3;
	}else{
		$to = 2;
	}*/

	/*if($from==2 or $from==3){
     
	}else{
		header('Location: sign.php');
	}*/
	
	if(isset($_POST['send_msg']) and !empty($_POST['msg_text'])){
		// print_r($_POST['msg_text']);
		global $db;
		$db->execute(" INSERT INTO `messages` SET `from`='$from', `to`='$to', `message`='$text_msg', `send_time`=Now() ; ");
		$_POST['msg_text'] = '';
	}
?>
 <!DOCTYPE html>
 <html lang="en">
 <head>
 	<meta charset="UTF-8">
 	<title> <?php print_r("Message Room ".$page_title['name']); ?> </title>
 	<link rel="stylesheet" href="messagestyle.css">
 </head>
 <body>
 	<div class="wholePage">
	 	<div class="left">
	 		<div class="name">Գրեք Ձեր Հաղորդագրությունը</div>
			<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post"> 
		        <textarea name="msg_text" cols="30" rows="10" class="textarea_1"></textarea>
		        <button   type="submit" class="signupbtn" name="send_msg">ՈՒղարկել</button>
			</form><br><br><br>
	 	</div>
	 	<div class="right">
 			<div class="messagebox" >
				<table id="msg_print">
					
				</table>
 			</div>
 		</div>
 	</div>

 	<script type="text/javascript">
		function display()
		{
		xmlhttp=new XMLHttpRequest();
		xmlhttp.open("GET","takeData.php",false);
		xmlhttp.send(null);
		document.getElementById("msg_print").innerHTML=xmlhttp.responseText;

		}
		display();

		setInterval(function(){
			display();
		},2000);
		document.getElementById( 'downstairs' ).scrollIntoView();
	</script>
 </body>
 </html>