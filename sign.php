<?php 
require_once 'db.php';
$db = new Database;


//////////////////////////Register////////////////////////////
/////////////////////////////////////////////////////////////

session_start();

if(isset($_POST['submit'])){
    require_once'validate.php';
    if( validateUsername($_POST['userName'])[0] and validateLastName($_POST['lname'])[0] and validateName($_POST['fname'])[0] and  validateEmail($_POST['email'])[0] and validateAge($_POST['age'])[0] and validatePsw($_POST['psw']) and validateRpsw($_POST['rpsw'],$_POST['psw'])[0] ){

        $usr=$_POST['userName'];
        $psw=$_POST['psw'];
        $age=$_POST['age'];
        $sex=$_POST['sex'];
        $email=$_POST['email'];
        $name=$_POST['fname'];
        $lname=$_POST['lname'];
        
        global $db;
        
        $currentTime = $db->query("SELECT NOW();");
        $currentTime = $currentTime[0];
        $currentTime = $currentTime["NOW()"];

        $db->execute("INSERT INTO `user` SET `username`= '$usr',`password` = '$psw' ,`age`= '$age' ,`sex`= '$sex', `email`= '$email',`name`= '$name',`l_name`= '$lname',`reg_time`= '$currentTime',`last_log`= '$currentTime' ");
        $_SESSION['username']=$_POST['userName'];
        $_POST=array();    
        header('Location: loged.php');

    }
}


//////////////////////////Log In////////////////////////////
/////////////////////////////////////////////////////////////

$admin_email;
$admin_username;
if(isset($_POST['submitLogin'])){
    foreach ($_POST as $key => $value) {
        trim($_POST[$key]);
    }
    // 
    function checkData($login,$pass){ 

        global $db;
        if (preg_match("/^[A-Za-z]{1}[A-Za-z0-9]{5,31}$/",$login) or preg_match('/[\w\.\-]{6,}@[a-zA-Z]+\.[a-zA-Z]+/',$login) and preg_match("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/",$pass)) {

            $dbUsr = $db->query("SELECT username,email,password FROM user");
            foreach ($dbUsr as $key => $value) {
                if(($value['username']==$login or $value['email']==$login ) and $value['password']==$pass){
                    
                    return [true];

                }
            }
            return [false,"Մուտքանունը և (կամ) գաղտնաբառը սխալ է մուտքագրված<br/><br/>"]; 
            }
        else return [false,"Մուտքանունը և (կամ) գաղտնաբառը սխալ է մուտքագրված<br/><br/>"];
    }
    if(checkData($_POST['userNameL'],$_POST['pswL'])[0]){
        global $db;
        global $admin_email;
        global $admin_username;
        if(isset($_SESSION['username'])){
        $usrData=$_SESSION['username'];
        $admin_data = $db->query("SELECT `username`,`email` FROM user WHERE id=1");
        $admin_data = $admin_data[0];
        $admin_email = $admin_data['email'];
        $admin_username = $admin_data['username'];
        $admin_password = $admin_data['password'];
        }elseif($_POST['userNameL']==$admin_email or $_POST['userNameL']==$admin_username and $_POST['pswL']==$admin_password) {
            $_SESSION['username']=$_POST['userNameL'];
            $_POST=array();  
            header('Location: admin.php');
            exit;
        }else{
        $_SESSION['username']=$_POST['userNameL'];
        global $db;
        $usrData=$_SESSION['username'];
        $currentTime = $db->query("SELECT NOW();");
        $currentTime = $currentTime[0];
        $currentTime = $currentTime["NOW()"];
        $usrArr = $db->execute("UPDATE `user` SET `last_log`='$currentTime' WHERE `username`='$usrData' or `email`='$usrData';");
        $_POST=array(); 
        header('Location: loged.php');
        exit;
        }
    }      
}
///////////////////////////////////////////////////////////////////////////////////////
 ////////////// Ստուգե թե լօգին էղած մարդ կա քցե իրա գլավնի էջը /////////////////
//////////////////////////////////////////////////////////////////////////////////////

if(isset($_SESSION['username'])){
    global $db;
    $check = $db->query("SELECT * FROM user WHERE `id`=1;");////կստանա ադմինի տվյալները///
    $check=$check[0];
    if($_SESSION['username']==$check['username'] or $_SESSION['username']==$check['email']){
        header('Location: admin.php');////// եթե ադմինն է կքցե ադմինի գլխավոր էջը     
    }else{
        header('Location: loged.php');////// եթե չէ կքցե user-ի գլխավոր էջը
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>MyLife.org</title>
    <link rel="icon" href="favicon.ico" type="image/x-icon"/>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<!-- w33333 -->
<button onclick="closeForm(1);" id='b01' style="width:auto;">Գրանցվել</button>
<button onclick="closeForm();" id='b02' style="width:auto;">Մուտք գործել</button>

<div id="id01" class="modal">
    <!-- w44444 -->
    <!-- <div class='signup mod'> -->
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" >

            <div class="container" style="">

                <label><b>Մուտքանուն</b></label>
                    <input type="text" placeholder="Գրեք Ձեր մուտքանունը" name="userName" value="<?php if(isset($_POST['submit']))echo $_POST['userName'] ?>" >
                    <span class="error"> <?php if(isset($_POST['submit']) and isset(validateUsername($_POST['userName'])[1]))echo validateUsername($_POST['userName'])[1] ?></span>

                <label><b>Ազգանուն</b></label>
                    <input type="text" placeholder="Գրեք Ձեր ազգանունը" name="lname" value="<?php if(isset($_POST['submit']))echo $_POST['lname'] ?>" >
                    <span class="error"> <?php if(isset($_POST['submit']) and isset(validateLastName($_POST['lname'])[1]))echo validateLastName($_POST['lname'])[1] ?></span>

                <label><b>Անուն</b></label>
                    <input type="text" placeholder="Գրեք Ձեր անունը" name="fname" value="<?php if(isset($_POST['submit']))echo $_POST['fname'] ?>" >
                    <span class="error"> <?php if(isset($_POST['submit']) and isset(validateName($_POST['fname'])[1]))echo validateName($_POST['fname'])[1] ?></span>

                <label><b>Տարիք</b></label>
                    <input type="text" placeholder="Գրեք Ձեր տարիքը" name="age" value="<?php if(isset($_POST['submit']))echo $_POST['age'] ?>" >
                    <span class="error"> <?php if(isset($_POST['submit']) and isset(validateAge($_POST['age'])[1]))echo validateAge($_POST['age'])[1] ?></span><br/>


                <label><b>Սեռ <br/></b></label>
                    <select type="text" placeholder="Ընտրեք Ձեր սեռը" name="sex" value="<?php if(isset($_POST['submit']))echo $_POST['sex'] ?>">
                        <option value="male">Արական</option>
                        <option value="female">Իգական</option>
                    </select><br/><br/>

                <label><b>Էլ. հասցե</b></label>
                    <input type="text" placeholder="Գրեք Ձեր Էլ. հասցեն" name="email" value="<?php if(isset($_POST['submit']))echo $_POST['email'] ?>" >
                    <span class="error"> <?php if(isset($_POST['submit']) and isset(validateEmail($_POST['email'])[1]))echo validateEmail($_POST['email'])[1] ?></span>

                <label><b>Գաղտնաբառ</b></label>
                    <input type="password" placeholder="Գրեք Ձեր գաղտնաբառը" name="psw" value="<?php if(isset($_POST['submit']))echo $_POST['psw'] ?>" >
                    <span class="error"> <?php if(isset($_POST['submit']) and isset(validatePsw($_POST['psw'])[1]))echo validatePsw($_POST['psw'])[1] ?></span>

                <label><b></b></label>
                    <input type="password" placeholder="Կրկնեք գաղտնաբառը" name="rpsw" value="<?php if(isset($_POST['submit']))echo $_POST['rpsw'] ?>" >
                    <span class="error"> <?php if(isset($_POST['submit']) and isset(validateRpsw($_POST['rpsw'],$_POST['psw'])[1]))echo validateRpsw($_POST['rpsw'],$_POST['psw'])[1] ?></span>




                <div class="clearfix">
                    <button  type="submit" class="signupbtn" name="submit">    Մուտք գործել   </button>
                </div>

            </div>
        </form>
    <!-- </div> -->

    <!-- w33333 -->
</div>
<div id="id02" class="modal" style="display:block;">
    <!-- w44444 -->
<!--     <div class='signup mod' style='display:block;'>  -->   
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" >
            <div class="container" style="">
                <span class="error"> <?php if(isset($_POST['submitLogin']) and isset(checkData($_POST['userNameL'],$_POST['pswL'])[1]) )echo checkData($_POST['userNameL'],$_POST['pswL'])[1] ?></span>
                <label><b>Մուտքանուն կամ էլ. հասցե</b></label>
                    <input type="text" placeholder="Գրեք Ձեր մուտքանունը կամ էլ. հասցեն" name="userNameL" value="<?php if(isset($_POST['submitLogin']))echo $_POST['userNameL'] ?>" >

                <label><b>Գաղտնաբառ</b></label>
                    <input type="password" placeholder="Գրեք Ձեր Գաղտնաբառը" name="pswL" value="<?php if(isset($_POST['submitLogin']))echo $_POST['pswL'] ?>" >

                <div class="clearfix">
                    <button  type="submit" class="signupbtn" name="submitLogin">Մուտք գործել</button>
                </div>

            </div>
        </form>
    </div>

    <!-- w33333 -->
</div>
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

<!-- w44444 -->
</body>
</html>