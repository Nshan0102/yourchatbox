<?php 
require_once 'db.php';
$db = new Database;
$newpic="";
session_start();

if(isset($_POST['sign_outbtn']) or isset($_POST['sign_outbtn'])){
    $_POST=array();
    $_SESSION=array();
    header('Location: sign.php');   
}

$sex='';$src='';$usrData='';$usrArr=[];

$isadmin=$db->query("SELECT * FROM `user` WHERE id=1");////կստանա ադմինի տվյալները///
$isadmin=$isadmin[0];
if(isset($_SESSION['username'])){ 

    global $isadmin; 
    if($_SESSION['username']!=$isadmin['username'] and $_SESSION['username']!=$isadmin['email']){
        header('Location: loged.php');////// եթե ադմինն է կքցե ադմինի գլխավոր էջը     
    }

	$usrData=$_SESSION['username'];
	$usrArr = $db->query("SELECT * FROM user WHERE `username`='$usrData' or `email`='$usrData';");//print_r($usrArr);die;
	$usrArr=$usrArr[0];
}else{
    header('Location: sign.php');
} 
if(isset($_SESSION["mynewpicture"])){
    $newPic = $_SESSION["mynewpicture"];
    //echo $newPic;
}
    $currentPic=$usrArr['usrpic'];
    //echo($currentPic);die;

    $srcImg= "usrimg/".$currentPic;
    // echo $currentPic;die;

if (isset($_POST['submitU'])) { 
    require_once'validate.php';
    if( validateUsernameU($_POST['userName'])[0] 
        and validateName($_POST['lname'])[0] 
        and validateName($_POST['fname'])[0] 
        and  validateEmailU($_POST['email'])[0] 
        and validateAge($_POST['age'])[0] 
        and (
                (  validatePsw($_POST['psw'])[0] and validateRpsw($_POST['rpsw'],$_POST['psw'])[0]  ) 
                or 
                (empty($_POST['psw']) and empty($_POST['psw']) )
            ) 
        
        and validatePsw($_POST['pswOld'])
    )
    {
        
        $usr=$_POST['userName'];$pswOld=$_POST['pswOld'];$psw=$_POST['psw'];$age=$_POST['age'];$sex=$_POST['sex']; $email=$_POST['email'];$name=$_POST['fname'];$lname=$_POST['lname'];
            global $db;
            if(empty($_POST['psw']) and empty($_POST['psw'])){
                $psw=$pswOld;
            }

        $rows=$db->query("SELECT * FROM `user` WHERE (`username`='$usrData' or `email`='$usrData' ) and `password`='$pswOld';");
        // print_r($rows);die;
        if (isset($rows[0])) {
            global $newPic;
            if($newPic==""){
                $isthereimg=$usrArr['usrpic'];
                if($isthereimg==""){
                $newPic="unknown.png";
                $db->execute("UPDATE `user` SET `usrpic`= '$newPic' WHERE (`username`='$usrData' or `email`='$usrData') ");
                }
            }else{$db->execute("UPDATE `user` SET `usrpic`= '$newPic' WHERE (`username`='$usrData' or `email`='$usrData') "); }
            // print_r($newPic);die;
            $db->execute("UPDATE `user` SET `username`= '$usr',`password` = '$psw' ,`age`= '$age' ,`sex`= '$sex', `email`= '$email',`name`= '$name',`l_name`= '$lname' WHERE (`username`='$usrData' or `email`='$usrData' ) ");
            $_SESSION['username']=$_POST['userName'];
            $_POST=array();
            echo '<script type="text/javascript">window.location.replace("'.basename(__FILE__).'");</script>';
        }
    }           
}
if (isset($_POST['submitD'])) { 
    require_once'validate.php';
    if(validatePsw($_POST['pswD'])[0]){
        
        $pswD=$_POST['pswD']; 
        global $db;
        //print_r($pswD);
        $rows=$db->query("SELECT * FROM `user` WHERE (`username`='$usrData' or `email`='$usrData' ) and `password`='$pswD';");
        //print_r($rows);
        if (isset($rows[0])) {

            $db->execute("DELETE FROM `user` WHERE  (`username`='$usrData' or `email`='$usrData')");
            $_POST=array();  
            header('Location: sign.php');
        }
    }
}

if (isset($_POST['submitAllUsers'])) { 
    header('Location: allUsers.php');
}

function printValue($x){
    // if(){};
    if(isset($_POST['submitU']))echo $_POST['userName'] ;
}
//print_r($usrArr);

?>

<html>
<head>
	<title><?php echo $usrArr['l_name']." ".$usrArr['name'];?></title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="myPic">
        <div class="flex-item">
            <img src="<?php echo $srcImg; ?>" alt="&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspՆկարը չի գտնվել
            &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspԿամ ընտրված Ֆայլը նկար չէ">
        </div>
    </div>
    <form action="avatar.php?inchinch=$arjeq" method="POST"> 
        <button   type="submit" class="signupbtn" name="TakeaNewPic">Ընտրել նկարը
        <input  type="hidden" name="takeNewPic">
        </button>
    </form><br><br>

    <div class="clearfix">
        <form action="allUsers.php?inchinch=$arjeq" method="POST"> 
            <button   type="submit" class="signupbtn" name="TakeaNewPic">Օգտատերերի ցանկը
            <input  type="hidden" name="takeNewPic">
            </button>
        </form><br><br>
    </div>

    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post"> 
        <button   type="submit" class="signupbtn" name="sign_outbtn">Դուրս գալ
        <input  type="hidden" name="sign_out">
        </button>
    </form><br><br><br>

    <button onclick="closeForm(1)" id='b01' style="width: 50%;">Տվյալների փոփոխում</button>

    <div id="id01" class="modal" style="display:block;">
    	<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
    		<div class="container" style="">
                
                    <label><b>Մուտքանուն</b></label>
                        <input type="text" placeholder="Գրեք Ձեր մուտքանունը" name="userName" value="<?php echo $usrArr['username'] ?>" >
                        <span class="error"> <?php if(isset($_POST['submitU']) and isset(validateUsernameU($_POST['userName'])[1]))echo validateUsernameU($_POST['userName'])[1] ?></span>

                    <label><b>Ազգանուն</b></label>
                        <input type="text" placeholder="Գրեք Ձեր ազգանունը" name="lname" value="<?php echo $usrArr['l_name'] ?>" >
                        <span class="error"> <?php if(isset($_POST['submitU']) and isset(validateName($_POST['lname'])[1]))echo validateName($_POST['lname'])[1] ?></span>

                    <label><b>Անուն</b></label>
                        <input type="text" placeholder="Գրեք Ձեր անունը" name="fname" value="<?php echo $usrArr['name'] ?>" >
                        <span class="error"> <?php if(isset($_POST['submitU']) and isset(validateName($_POST['fname'])[1]))echo validateName($_POST['fname'])[1] ?></span>

                    <label><b>Էլ. հասցե</b></label>
                        <input type="text" placeholder="Գրեք Ձեր էլ. հասցեն" name="email" value="<?php echo $usrArr['email'] ?>" >
                        <span class="error"> <?php if(isset($_POST['submitU']) and isset(validateEmailU($_POST['email'])[1]))echo validateEmailU($_POST['email'])[1] ?></span>
    				
                    <label><b>Նոր գաղտնաբառ</b></label>
                        <input type="password" placeholder="Գրեք Ձեր նոր գաղտնաբառը" name="psw" value="" >
                        <span class="error"> <?php if(isset($_POST['submitU']) and isset(validatePsw($_POST['psw'])[1]))echo validatePsw($_POST['psw'])[1] ?></span>

                    <label><b></b></label>
                        <input type="password" placeholder="Կրկնեք գաղտնաբառը" name="rpsw" value="" >
                        <span class="error"> <?php if(isset($_POST['submitU']) and isset(validateRpsw($_POST['rpsw'],$_POST['psw'])[1]))echo validateRpsw($_POST['rpsw'],$_POST['psw'])[1] ?></span>

                    <label><b>Տարիք</b></label>
                        <input type="text" placeholder="Գրեք Ձեր տարիքը" name="age" value="<?php echo $usrArr['age'] ?>" >
                        <span class="error"> <?php if(isset($_POST['submitU']) and isset(validateAge($_POST['age'])[1]))echo validateAge($_POST['age'])[1] ?></span>

                    <label><b>Սեռ</b></label>
                        <select type="text" placeholder="Ընտրեք Ձեր սեռը" name="sex" value="<?php echo $_POST['sex'] ?>">
                            <option value="male">Արական</option>
                            <option value="female">Իգական</option>
                        </select><br><br>
                    
                    <label><b>Առկա գաղտնաբառը</b></label>
                        <input type="password" placeholder="Գրեք Ձեր առկա գաղտնաբառը փոփոխությունները հաստատելու համար" name="pswOld" value="" >
                        <span class="error"> <?php if(isset($_POST['submitU']) and isset(validatePsw($_POST['pswOld'])[1]))echo validatePsw($_POST['pswOld'])[1] ?></span>

                    
                    <div class="clearfix">
                        <button  type="submit" class="signupbtn" name="submitU">     Հաստատել   </button>
                    </div>
                </div>
    	</form>
    </div>
</body>
<script>
// Get the modal
var modal1 = document.getElementById('id01');
var modal2 = document.getElementById('id02');

function closeForm (x) {
    if(x){
            modal1.style.display = "block";
            modal2.style.display = "none";

            console.log("a");
    }else{
            modal2.style.display = "block";
            modal1.style.display = "none";
            console.log("b");
    }
    
}
</script>
</html>