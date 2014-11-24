<?php
/**
 * Author: Md Prawez Musharraf
 * Created Date: 14/10/14
 * This class is responsible for mysql db connection
 */
Class DBOperation
{
	#declare class variables
	private $ServerName;
	private $UserName;
	private $Password;
	private $DBName;
	private $ConnectionResource;
	
	/**
	 * Define class constructor
	 */
	public function __construct()
	{
		#set class variable
		$this->ServerName	= HOST;
		$this->UserName		= DBUSER;
		$this->Password		= DBPASSWORD;
		$this->DBName		= DBNAME;
		
		#create connection
		$this->Connect();
	}
	
	/**
	 * This function is used to connect with mysql database
	 */
	public function Connect()
	{
		$this->ConnectionResource = new PDO("mysql:host=".$this->ServerName.";dbname=".$this->DBName."", $this->UserName, $this->Password);
		
		if (!$this->ConnectionResource) {
			#generate mysql error
            echo "Failed to connect to MySQL";
		}
	}
	
	/**
	 * This function is used to close mysql connection
	 */
	public function CloseConnection()
	{
		#close mysql connection
		$this->ConnectionResource = null;
	}
        
        /**
         * This function is used to insert a new user
         * @param   string $intAccountId
         * @param   string $strAccountType 
         * @param   string $strFirstName 
         * @param   string $strLastName 
         * @param   string $strEmail 
         * @param   string $strProfileImage 
         * @return void 
         */
        public function UserSignup($intAccountId, $strAccountType, $strFirstName, $strLastName, $strEmail, $strProfileImage)
        {
			#prepare query
            $query = "CALL procUserSignup('".$intAccountId."', '".$strAccountType."', '".$strFirstName."', '".$strLastName."', '".$strEmail."', '".$strProfileImage."');";
            
			#prepare query
			$res = $this->ConnectionResource->prepare($query);
			
			#execute query
			$res->execute();
			
			#free resource
			$res->closeCursor();
			
			return true;
			
            /*#execute query
            $result = $this->ConnectionResource->query($query);      
            
            #row
            $arrRow = $result->fetch_assoc();*/
        }
        
        /**
         * This function is used to check if user exists with AccountId, AccountType and Email
         * @param integer $intAccountType 
         * @param string $strAccountType 
         * @param string $strEmail
         * @return array 
         */
        public function CheckUserExistence($intAccountId, $strAccountType, $strEmail)
        {
            #prepare query
            $query = "CALL procCheckUserExistence('".$intAccountId."', '".$strAccountType."', '".$strEmail."');";
            
			#prepare query
			$res = $this->ConnectionResource->prepare($query);
			
			#execute query
			$res->execute();
			$res->setFetchMode(PDO::FETCH_ASSOC);
			
			#get result
			$arrResult = $res->fetch();
			
			#free resource
			$res->closeCursor();
            
            return $arrResult;
        }
		
		/**
         * This function is used to check if user exists with AccountId and AccountType
         * @param integer $intAccountType 
         * @param string $strAccountType 
         * @return array 
         */
        public function CheckUserLogin($intAccountId, $strAccountType)
        {
            #prepare query
            $query = "CALL procCheckUserLogin('".$intAccountId."', '".$strAccountType."');";
            
			#prepare query
			$res = $this->ConnectionResource->prepare($query);
			
			#execute query
			$res->execute();
			$res->setFetchMode(PDO::FETCH_ASSOC);
			
			#get result
			$arrResult = $res->fetch();
			
			#free resource
			$res->closeCursor();
            
            return $arrResult;
        }
		
		/**
         * This function is used to user phone no
         * @param integer $intAccountType 
         * @param string $strPhoneNo 
         * @return array 
         */
        public function UpdateUserPhoneNo($intAccountId, $strPhoneNo)
        {
            #prepare query
            $query = "CALL procUpdateUserPhoneNo('".$intAccountId."', '".$strPhoneNo."');";
            
			#prepare query
			$res = $this->ConnectionResource->prepare($query);
			
			#execute query
			$res->execute();
			
			#free resource
			$res->closeCursor();
            
            return true;
        }
}

?>