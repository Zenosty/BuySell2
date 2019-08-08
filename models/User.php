<?php
/**
 * Class: User
 * 
 * The user class represents the end user of the application. 
 * 
 * This class is responsible for providing the following functions:
 * 
     * User registration
     * User Login
     * User Logout
     * Persisting user session data by keeping the$_SESSION array up to date
 *
 * @author gerry.guinane
 */
class User extends Model {
    //put your code here
    
    //class properties
    private $session;
    private $db;
    private $email;
    private $userFirstName;
    private $userLastName;
    private $userType;
    private $postArray;

    //constructor
    function __construct($session,$database) 
    {   
        parent::__construct($session->getLoggedinState());
        $this->db=$database;
        $this->session=$session;
        //get properties from the session object
        $this->userFirstName=$session->getUserFirstName();
        $this->userLastName=$session->getUserLastName();
        $this->userType=$session->getUserType();
        $this->email=$session->getUserEmail();
        $this->postArray=array();
    }
    //end METHOD - Constructor

    public function login($email, $password)
    {
        //This login function checks both the student and lecturer tables for valid login credentials

        //encrypt the password
        $password = hash('ripemd160', $password);

        //set up the SQL query strings
        $SQL1 = "SELECT FirstName,LastName,Email,Admin FROM users WHERE Email='$email' AND Password='$password'";

        //execute the queries to get the 2 resultsets
        $rs1 = $this->db->query($SQL1); //query the lecturer table
        //use the resultsets to determine if login is valid and which type of user has logged on.
        if ($rs1->num_rows === 1)
        {
            $row = $rs1->fetch_assoc();

            if ($row{'Admin'} = 1)
            {
                $this->session->setUserEmail($row['Email']);
                $this->session->setUserFirstName($row['FirstName']);
                $this->session->setUserLastName($row['LastName']);
                $this->session->setLoggedinState(TRUE);

                $this->email = $email;
                $this->userFirstName = $row['FirstName'];
                $this->userLastName = $row['LastName'];
                $this->userType = 'ADMIN';


                $this->loggedin = TRUE;
                return TRUE;

            }
            elseif ($row['Admin'] = 0)
            { //Customer has logged on
                $this->session->setUserEmail($row['Email']);
                $this->session->setUserFirstName($row['FirstName']);
                $this->session->setUserLastName($row['LastName']);
                $this->session->setUserType('CUSTOMER');
                $this->session->setLoggedinState(TRUE);

                $this->email = $email;
                $this->userFirstName = $row['FirstName'];
                $this->userLastName = $row['LastName'];
                $this->userType = 'CUSTOMER';

                $this->loggedin = TRUE;
                return TRUE;
            }

            else
                { //invalid login credentials entered
                $this->session->setLoggedinState(FALSE);
                $this->loggedin = FALSE;
                return FALSE;
            }
        }
    }
    //end METHOD - User login

    public function logout()
    {
        $this->session->logout();
    }
    //end METHOD - User login

    public function register($postArray)
    {
        //get the values entered in the registration form
        $firstName=$this->db->real_escape_string($postArray['FirstName']);
        $lastName=$this->db->real_escape_string($postArray['LastName']);
        $email=$this->db->real_escape_string($postArray['Email']);
        $password=$this->db->real_escape_string($postArray['Pass1']);
        //encrypt the password
        $password = hash('ripemd160', $password);
        //construct the INSERT SQL
        $sql="INSERT INTO users (FirstName,LastName,Email,Password) VALUES ('$firstName','$lastName','$email','$password')";

        //execute the insert query
        $rs=$this->db->query($sql); 
        //check the insert query worked
        if ($rs){return TRUE;}else{return FALSE;}
    }
    //end METHOD - Register User 

    //setters
    public function setLoginAttempts($num){$this->session->setLoginAttempts($num);}
    
    //getters
    public function getLoggedInState(){return $this->session->getLoggedinState();}//end METHOD - getLoggedInState
    public function getUserFirstName(){return $this->userFirstName;}
    public function getUserLastName(){return $this->userLastName;}
    public function getUserType(){return $this->userType;}
    public function getLoginAttempts(){return $this->session->getLoginAttempts();}
    public function getUserEmail(){return $this->email;}
}
