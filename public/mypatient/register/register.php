<?php
require_once 'dbconfig.php';

if($_POST)
{
    $name =$_REQUEST['name'];// mysql_real_escape_string($_REQUEST['name']);
    $usertype =$_REQUEST['usertype'];//mysql_real_escape_string($_REQUEST['usertype']);
    $username      = $_REQUEST['username'];// mysql_real_escape_string($_REQUEST['username']);
    $email     = $_REQUEST['email']; // mysql_real_escape_string($_REQUEST['email']);
    $hospital_id     = $_REQUEST['hospital']; //mysql_real_escape_string($_REQUEST['hospital']);
    $password  = $_REQUEST['password']; // mysql_real_escape_string($_REQUEST['password']);
    $joining_date   = date('Y-m-d H:i:s');
    $contactnumber = $_REQUEST['contactnumber'];

    //password_hash see : http://www.php.net/manual/en/function.password-hash.php
    $password   = password_hash( $user_password, PASSWORD_BCRYPT, array('cost' => 11));
   
    try
    {
        if($usertype== 'nurse' || $usertype== 'pharmacy' || $usertype== 'doctor')
        {
            $stmt = $db_con->prepare("SELECT * FROM User WHERE email=:email");
            $stmt->execute(array(":email"=>$user_email));
            $count = $stmt->rowCount();
        
            if($count==0){
                $stmt = $db_con->prepare("INSERT INTO User(UserID, Name, Username,HospitalId, UserType , Email, Password) VALUES(:userid,:name,:username,:hospital_id, :usertype, :email, :password)");
                
                $stmt->bindParam(":userid",gen_uuid());
                $stmt->bindParam(":name",$name);
                $stmt->bindParam(":username",$username);
                $stmt->bindParam(":usertype",$usertype);
                $stmt->bindParam(":email",$email);
                $stmt->bindParam(":password",$password);
                $stmt->bindParam(":hospital_id",$hospital_id);
                
                if($stmt->execute())
                {
                    echo "registered";
                }
                else
                {
                    echo "Query could not execute !";
                }

            }
            else{
                echo "1"; //  not available
            }

        }else{

            $stmt = $db_con->prepare("SELECT * FROM Hospitals WHERE email=:email");
            $stmt->execute(array(":email"=>$user_email));
            $count = $stmt->rowCount();
        
            if($count==0){
                $stmt = $db_con->prepare("INSERT INTO Hospitals(AccountID, AccountName, ContactNumber,Email,  AccountType,Password,Address) VALUES(:userid, :name,:contactnumber,:email, :usertype,  :password,  :address)");
                
                $stmt->bindParam(":userid",gen_uuid());
                $stmt->bindParam(":name",$name);
                $stmt->bindParam(":contactnumber",$contactnumber);
                $stmt->bindParam(":usertype",$usertype);
                $stmt->bindParam(":email",$email);
                $stmt->bindParam(":password",$password);
                $stmt->bindParam(":address",$address);
                
                if($stmt->execute())
                {
                    echo "registered";
                }
                else
                {
                    echo "Query could not execute !";
                }

            }
            else{
                echo "1"; //  not available
            }


        }

        

    }
    catch(PDOException $e){
        echo $e->getMessage();
    }
}


function gen_uuid() {
    return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        // 32 bits for "time_low"
        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),

        // 16 bits for "time_mid"
        mt_rand( 0, 0xffff ),

        // 16 bits for "time_hi_and_version",
        // four most significant bits holds version number 4
        mt_rand( 0, 0x0fff ) | 0x4000,

        // 16 bits, 8 bits for "clk_seq_hi_res",
        // 8 bits for "clk_seq_low",
        // two most significant bits holds zero and one for variant DCE1.1
        mt_rand( 0, 0x3fff ) | 0x8000,

        // 48 bits for "node"
        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
    );
}
?>