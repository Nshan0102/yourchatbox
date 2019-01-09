<?php 

    foreach ($_POST as $key => $value) {
        trim($_POST[$key]);
    }

    function validateUsername($x){

        global $db;
        if (preg_match('/^[A-Za-z]{1}[A-Za-z0-9]{5,31}$/',$x)) {
            $dbUsr = $db->query("SELECT username FROM user");
            foreach ($dbUsr as $key => $value) {
                if ($x==$value['username'])return [false,'Այս մուտքանունը պատկանում է ուրիշ օգտատիրոջ<br/><br/>'];
            }
            return [true];    
        }
        else return [false,"Մուտքանունը պետք է պարունակի միայն տառեր և թվեր<br/>*Առնվազն 6 նիշ <br/><br/>"];
    }

    function validateUsernameU($x){

        global $db;
        global $usrData;
        if (preg_match('/^[A-Za-z]{1}[A-Za-z0-9]{5,31}$/',$x)) {
            $dbUsr = $db->query("SELECT username FROM user");
            $dbUsrCurrent = $db->query("SELECT username FROM `user` WHERE (`username`='$usrData' or `email`='$usrData' )");
            //print_r($dbUsrCurrent[0]['username']);
            echo('<br />');
            foreach ($dbUsr as $key => $value) {
                if ($x==$value['username'] and $x!=$dbUsrCurrent[0]['username'])return [false,'Այս մուտքանունը պատկանում է ուրիշ օգտատիրոջ<br/><br/>'];
            }
            return [true];    
        }
        else return [false,"Մուտքանունը պետք է պարունակի միայն տառեր և թվեր<br/>*Առնվազն 6 նիշ <br/><br/>"];
    }

    function validateName($x){
        if (preg_match("/^[a-zA-Z'-]+$/",$x))  return [true];
        else return [false,"Անունը պետք է պարունակի միայն տառեր<br/><br/>"];
    }

    function validateLastName($x){
        if (preg_match("/^[a-zA-Z'-]+$/",$x))  return [true];
        else return [false,"Ազգանունը պետք է պարունակի միայն տառեր<br/><br/>"];
    }

    function validateEmail($x){
        global $db;
        if (preg_match('/[\w\.\-]{6,}@[a-zA-Z]+\.[a-zA-Z]+/',$x)) {
            $dbUsr = $db->query("SELECT email FROM user");
            foreach ($dbUsr as $key => $value) {
                if ($x==$value['email']) return [false,'Այս էլ. հասցեն պատկանում է ուրիշ օգտատիրոջ<br /><br />'];
            }
            return [true];   
        }
        else return [false,"Մուտքագրեք ակտիվ էլ. հասցե<br /><br />"];
    }

    function validateEmailU($x){

        global $db;
        global $usrData;
        if (preg_match('/[\w\.\-]{6,}@[a-zA-Z]+\.[a-zA-Z]+/',$x)) {
            $dbUsr = $db->query("SELECT email FROM user");
            $dbEmailCurrent = $db->query("SELECT email FROM `user` WHERE (`username`='$usrData' or `email`='$usrData' )");
            foreach ($dbUsr as $key => $value) {
                if ($x==$value['email'] and $x!=$dbEmailCurrent[0]['email']) return [false,'Այս էլ. հասցեն պատկանում է ուրիշ օգտատիրոջ<br/><br/>'];
            }
             return [true];   
        }
        else return [false,"Մուտքագրեք ակտիվ էլ. հասցե<br/><br/>"];
    }

    function validateAge($x){
        if (preg_match('/^\S[0-9]{0,3}$/',$x)){
            if($x < 18 || $x > 125){
                return [false,"Գրանցվելու իրավունք ունեն միայն 18-125 տարեկան անձիք<br />"];
            }
            return [true];
        }else{
            return [false,"Տարիքը պետք է պարունակի միայն թվանշաններ (18-125)<br />"];
        }
    }

    function validatePsw($x){
        if (preg_match("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/",$x))  return [true];
        else return [false,"Գաղտնաբառը պետք է պարունակի միայն տառեր և թվեր ( Օր. ''MyLife2017'' )<br/>*Առնվազն 8 նիշ<br/><br/>"];
    }

    function validateRpsw($x,$y){
        if ($x==$y and preg_match("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/",$x)) return [true];   
        else return [false,"Գաղտնաբառը չի համընկնում<br/><br/>"];
    }


?>