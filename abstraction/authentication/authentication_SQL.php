<?php
require_once(LIB_PATH . "password.php");
//var_dump(password_hash("cicciolo",PASSWORD_BCRYPT));
class SQLAuthentication implements Authenticator, UserInfoRetriever
{
    private $db;
    private $user=null;
    public function __construct($db_link)
    {
        $this->db = $db_link;
    }

/**
 * Retrieve user information as name and other information from an LDAP
 * @param User $user Pass the user object to be filled with information
 * */    
    public function getUserInfo($user)
    {
        $user->setGroups(explode(",",$this->user["roles"]));
        $user->setName("","",$this->user["name"]);
        return true;
    }
    
    /**
     * Overwrite the method that perform authentication and set user information
     * @param User $user Pass the user object to be filled with information
     * @param string $id Contain the user id
     * @param string $password Store the password for the user
     * */
    public function authenticate($id,$password=NULL,$domain=NULL)
    {
        if (trim($id) == "" || trim($password) == "")
            return false;                	
        $userid = $this->db->escape($id);
        
        $query_string= "SELECT  u.id, u.name, u.user_roles, u.access_password " .
	   " FROM " . $this->db->prefix . 'users u WHERE u.id = "' .$userid . '"';
	   $result = $this->db->get_row($query_string);	
        
        if ($result !== FALSE && $result != null) {            
            if (password_verify($password, $result->access_password)) {
                $this->user = array("id"=>$result->id,"name"=>$result->name,"roles"=>$result->user_roles);
                return true;
            } else {
                return false;
            }
        }
        else {
            return false;
        }

    }
}

