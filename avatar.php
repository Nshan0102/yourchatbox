<?php
    require_once 'db.php';
    $db = new Database;
	session_start();
    $usrData='';
    global $db;
    if(!isset($_SESSION['username']) and !isset($_SESSION['username'])){
        header('Location: sign.php');
    }
    $usrData=$_SESSION['username'];
    // print_r($usrData);
    $currentpaththis = getcwd();
    $currentpath = str_replace("\\","/",$currentpaththis);
    //echo($currentpath);
    $isadmin=$db->query("SELECT * FROM `user` WHERE id=1");////կստանա ադմինի տվյալները///
    $isadmin=$isadmin[0];
    //print_r($isadmin[username]);
    if(isset($_POST['main_page'])){
        global $isadmin; 
            if($_SESSION['username']==$isadmin['username'] or $_SESSION['username']==$isadmin['email']){
                header('Location: admin.php');////// եթե ադմինն է կքցե ադմինի գլխավոր էջը     
            }else{
                header('Location: loged.php');////// եթե չէ կքցե user-ի գլխավոր էջը
            }
    }

    if(isset($_POST['download'])){
        if(isset($_SESSION['username'])){

            $_SESSION["mynewpicture"] = $_FILES["file"]["name"];

            if (isset($_POST["actions"]) && $_POST["actions"] ) {
                if (!move_uploaded_file($_FILES["file"]["tmp_name"], "/storage/ssd1/506/4151506/public_html/usrimg/" . $_FILES["file"]["name"])) {
                    echo "Հնարավոր չէ բեռնել<br/>Ընտրեք Նկար(jpg / png / gif)<br/>";
                }
            }
            if(  ($isadmin['username']==$usrData) or ($isadmin['email']==$usrData)    ){
                header('Location: admin.php');
            }else{
                header('Location: loged.php');
            }
        }
    }    
 ?>
<!DOCTYPE html>
<html lang="arm">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="style.css">
	<title>Նկար</title>
</head>
<body>
	<form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
        <input type="hidden" name="actions" value="true">
        <input type="file" name="file" value="Ընտրել Նկարը" style="background: #c8c9cc; height: 80px; margin-top: -60px;">
        <input type="submit" name="download" value="Բեռնել Նկարը" style="background: #4CAF50;">
        <input type="submit" name="main_page" value="Գլխավոր էջ" style="background: #4CAF50;">
    </form>


	<!-- <form action="loged.php?variable_name=$value" method="POST"> 
        <button   type="submit" class="signupbtn" name="MyNewPic">Փոփոխել
            <input  type="hidden" name="newPic">
            </button>
    </form> -->
    <br/>
    <div style="display: block; width: 50%; align-items: center; justify-content: center;">
        <div class="flex-item">
            <h4>"Բեռնել նկարը" կոճակը սեղմեուց հետո կարգավորումները պահելու համար Ձեր էջի
            "ՏՎՅԱԼՆԵՐԻ ՓՈՓՈԽՈՒՄ" բաժնում մուտքագրեք առկա գաղտնաբառը </h4>
        </div>
        <div style="width: 700px; height: auto;">
            <img src="img/avatar1.png" alt="" style="width: 700px; height: 170px">
        </div>
    </div>
</body>
</html>


                