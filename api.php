<?php
error_reporting(0);
@ini_set('display_errors', 0);

#include files
require_once 'config/config.php';
require_once 'classes/dboperation.class.php';

#get params
$action = trim($_GET['action']);

switch ($action)
{
    case "usersignup":
		#get data
        $intAccountId   = $_POST['accountId'];
        $strAccountType = trim($_POST['accountType']);
        $strFirstName   = trim($_POST['firstname']);
        $strLastName    = trim($_POST['lastname']);
        $strEmail       = trim($_POST['email']);
        $strUserImage   = '';
        
        #create db instance
        $objDBOperation = new DBOperation();
        
        #insert user
        try {
            #check user existance
            $chkUserExistance = $objDBOperation->CheckUserExistence($intAccountId, $strAccountType, $strEmail);
            
            if(empty($chkUserExistance)) {
                $objDBOperation->UserSignup($intAccountId, $strAccountType, $strFirstName, $strLastName, $strEmail, $strProfileImage);
                $response = array('error' => 0, 'msg' => 'Account has been created successfully.');
            } else {
                $response = array('error' => 1, 'msg' => 'User already exists.');
            }
        } catch (Exception $ex) {
            $response = array('error' => 1, 'msg' => 'there is some technical issue with account creation');
        }        
        
        #close db connection
        $objDBOperation->CloseConnection();
        
        echo json_encode($response); exit;
        
    break;
    
    case "userlogin":
        $intAccountId   = $_POST['accountId'];
        $strAccountType = trim($_POST['accountType']);
		
		#create db instance
        $objDBOperation = new DBOperation();
		
		try{
			#check user login
			$chkUser = $objDBOperation->CheckUserLogin($intAccountId, $strAccountType);
			
			if (!empty($chkUser)) {
				$response = array('error' => 0, 'msg' => 'Login Successful.');
			} else {
				$response = array('error' => 1, 'msg' => 'Invalid Login.');
			}
		} catch (Exception $ex) {
            $response = array('error' => 1, 'msg' => 'there is some technical issue with account creation');
        }        
		
		#close db connection
        $objDBOperation->CloseConnection();
		
		echo json_encode($response); exit;
    break;
	
	case "addphoneno":
		#get data
		$intAccountId   = $_POST['accountId'];
        $strPhoneNo		= trim($_POST['phoneno']);
		
		#create db instance
        $objDBOperation = new DBOperation();
		
		try{
			#check user login
			$objDBOperation->UpdateUserPhoneNo($intAccountId, $strPhoneNo);			
			$response = array('error' => 0, 'msg' => 'Phone no has been updated');			
		} catch (Exception $ex) {
            $response = array('error' => 1, 'msg' => 'there is some technical issue with account creation');
        }		
		
		#close db connection
        $objDBOperation->CloseConnection();
		
		echo json_encode($response); exit;
	break;

    default:
        
    break;
}
?>