<?php 
require_once 'db.php';
$db = new Database;
$newpic="";
session_start();
//header("Refresh:2");
//print_r($_POST);
//print_r($_SESSION);
if(isset($_POST['sign_out']) or isset($_POST['sign_outbtn'])){
    $_POST=array();
    session_destroy();
    $SESSION=array();
    header('Location: sign.php');
}
if(isset($_SESSION['username'])){ 
$usrData=$_SESSION['username'];
}
$mySex = $db->query("SELECT `sex` FROM `user` WHERE `username` = '$usrData'; ");
$mySex = $mySex[0];
//print_r($mySex);
?>
<script>
    if(<?php $mySex = 'male' ?>){
        var sex = document.getElementById("userSex");
        sex.value = 'male'
    }else{
        var sex = document.getElementById("userSex");
        sex.value = 'female'
    }
</script>
<?php
$isadmin=$db->query("SELECT * FROM `user` WHERE `id` =1; ");
$isadmin=$isadmin[0];
// print_r($usrData);
// print_r($isadmin["username"]);
if(isset($_SESSION['username'])){
    if($isadmin['username']!=$usrData or $isadmin['email']!=$usrData    ){
    }else{
         header('Location: sign.php');
    }
}
$sex='';$src='';$usrData='';$usrArr=[];
if(isset($_SESSION['username'])){ 
    $usrData=$_SESSION['username'];
    $usrArr = $db->query("SELECT * FROM user WHERE `username`='$usrData' or `email`='$usrData';");//print_r($usrArr);die;
    $usrArr=$usrArr[0];
}else{
    header('Location: sign.php');
}
if(isset($_SESSION["mynewpicture"])){
    global $newPic;
    $newPic = $_SESSION["mynewpicture"];
    //echo $newPic;
}
    $currentPic=$usrArr['usrpic'];
    //echo($currentPic);die;
    $srcImg= "usrimg/".$currentPic;
    // echo $srcImg;die;

if (isset($_POST['submitU'])) {

    require_once'validate.php';

    if( validateUsernameU($_POST['userName'])[0] 
        and validateLastName($_POST['lname'])[0] 
        and validateName($_POST['fname'])[0] 
        and  validateEmailU($_POST['email'])[0] 
        and validateAge($_POST['age'])[0] 
        and (
                (  validatePsw($_POST['psw'])[0] and validateRpsw($_POST['rpsw'],$_POST['psw'])[0]  ) 
                or 
                (empty($_POST['psw']) and empty($_POST['psw']) )
            ) 
        
        and validatePsw($_POST['pswOld'])
    ){
        
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
                global $usrArr;
                $isthereimg=$usrArr['usrpic'];
                //echo($usrArr['usrpic']);die;
                if($isthereimg==""){
                    global $newPic;
                    $newPic="unknown.png";
                    $db->execute("UPDATE `user` SET `usrpic`= '$newPic' WHERE (`username`='$usrData' or `email`='$usrData') ");
                }
            }else{
                global $newPic;
                $db->execute("UPDATE `user` SET `usrpic`= '$newPic' WHERE (`username`='$usrData' or `email`='$usrData') "); 
            }
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
            session_destroy();
            $_SESSION=array();  
            header('Location: sign.php');
        }
    }
}


function printValue($x){
    // if(){};
    if(isset($_POST['submitU']))echo $_POST['userName'] ;
}
//print_r($_POST);

?>

<html>
<head>
    <title><?php echo $usrArr['l_name']." ".$usrArr['name'];?></title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<!--////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////// ՆԿԱՐԻ   ԸՆՏՐԵԼԸ /////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////-->
    <div class="myPic">
        <div class="flex-item">
            <img src="<?php echo $srcImg; ?>" alt="&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspՆկարը չի գտնվել
            &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspԿամ ընտրված Ֆայլը նկար չէ">
        </div>
    </div>
    <form action="avatar.php" method="POST"> 
        <button   type="submit" class="signupbtn" name="TakeaNewPic">Ընտրել նկարը
        <input  type="hidden" name="takeNewPic">
        </button>
    </form><br><br><br>

    <form action="room.php" method="POST"> 
        <button   type="submit" class="signupbtn" name="msg_btn">Հաղորդագրություններ
        <input  type="hidden" name="message">
        </button>
    </form><br><br><br>
   
<button onclick="closeForm()" id='b02' style="width: 50%; background-color: #e66c6c;">Հաշվի ապաակտիվացում</button><br>


<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post"> 
        <button   type="submit" class="signupbtn" name="sign_outbtn">Դուրս գալ
        <input  type="hidden" name="sign_out">
        </button>
</form><br><br><br>


<button onclick="closeForm(1)" id='b01' style="width: 50%;">Տվյալների փոփոխում</button>


<!-- ////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////// ՏՎՅԱԼՆԵՐԻ   ՓՈՓՈԽՈՒՄ //////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////// -->
<div id="id01" class="modal" style="display:block;">
    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
        <div class="container" style="">
            
                <label><b>Մուտքանուն</b></label>
                    <input type="text" placeholder="Գրեք Ձեր մուտքանունը" name="userName" value="<?php echo $usrArr['username'] ?>" >
                    <span class="error"> <?php if(isset($_POST['submitU']) and isset(validateUsernameU($_POST['userName'])[1]))echo validateUsernameU($_POST['userName'])[1] ?></span>

                <label><b>Ազգանուն</b></label>
                    <input type="text" placeholder="Գրեք Ձեր ազգանունը" name="lname" value="<?php echo $usrArr['l_name'] ?>" >
                    <span class="error"> <?php if(isset($_POST['submitU']) and isset(validateLastName($_POST['lname'])[1]))echo validateLastName($_POST['lname'])[1] ?></span>

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
                    <select type="text" placeholder="Ընտրեք Ձեր սեռը" name="sex" id="userSex" value="">
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

<!--////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////// ԱՊԱԱԿՏԻՎԱՑՈՒՄ ////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////// -->


<div id="id02" class="modal">
    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
    
      <label><b><br/><br/>Գաղտնաբառ<br/><br/></b></label>
            <input type="password" placeholder="Մուտքագրեք գաղտնաբառը հաշիվն ապաակտիվացնելու համար" name="pswD" value="<?php if(isset($_POST['submitD']))echo $_POST['pswD'] ?>" >
            <span class="error"> <?php if(isset($_POST['submitD']) and isset(validatePsw($_POST['pswD'])[1]))echo validatePsw($_POST['pswD'])[1] ?></span><br><br>



        <div class="clearfix">
            <br><button type="submit" class="deletebtn" name="submitD">    ԱՊԱԱԿՏԻՎԱՑՆԵԼ   </button>
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