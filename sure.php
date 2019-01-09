<?php 
	if(isset($_POST['sign_out']) or isset($_POST['sign_outbtn'])){
    $_POST=array();
    session_destroy();
    $SESSION=array();
    header('Location: sign.php');
	}
	if(isset($_POST['non_sign_out']) or isset($_POST['non_sign_outbtn'])){
    $_POST=array();
    session_destroy();
    $SESSION=array();
    header('Location: sign.php');
	}
 ?>
 <!DOCTYPE html>
 <html lang="en">
 <head>
 	<meta charset="UTF-8">
 	<title>Դուրս Գալ</title>
 	<link rel="stylesheet" type="text/css" href="style.css">
 </head>
 <body style="display: block;">
 	<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post"> 
        <button   type="submit" class="signupbtn" name="sign_outbtn">Դուրս գալ
        <input  type="hidden" name="sign_out">
        </button>
	</form>
	<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post"> 
        <button   type="submit" class="signupbtn" style="background: #217124" name="non_sign_outbtn">Վերադառնալ
        <input  type="hidden" name="non_sign_out">
        </button>
	</form><br><br><br>
	<div style="width: 100%; height: auto; background-image: url(img/);">
		
	</div>
 </body>
 </html>