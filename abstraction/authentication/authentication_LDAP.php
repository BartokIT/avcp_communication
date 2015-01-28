<?php

class LDAPAuthentication implements Authenticator, UserInfoRetriever
{
    private $ldap_host;
    private $ldap_port;

    private $rootdn;
    private $rootdnpwd;
    
    
    private $basedn;
    private $idattribute;
    private $filter;
    public function __construct($ldap_host,$ldap_port,$rootdn,$rootdnpwd,$basedn,$idattribute,$filter="")
    {
        $this->ldap_host=$ldap_host;
        $this->ldap_port=$ldap_port;
        $this->rootdn=$rootdn;
        $this->rootdnpwd=$rootdnpwd;
        $this->basedn=$basedn;
        $this->filter=$filter;
        $this->idattribute=$idattribute;        
    }

/**
 * Retrieve user information as name and other information from an LDAP
 * @param User $user Pass the user object to be filled with information
 * */    
    public function getUserInfo($user)
    {
        $filter='(&' . $this->filter.'(' . $this->idattribute . '='. $user->getID() .'*))';
        //Open an LDAP connection
        $ldapconn = ldap_connect($this->ldap_host,intval($this->ldap_port));
        
        if ($ldapconn) {        
            // binding to ldap server
            $ldapbind = ldap_bind($ldapconn, $this->rootdn, $this->rootdnpwd);
            // verify binding
            if ($ldapbind) {
                //Search from the specified filter
                $sr=ldap_search($ldapconn, $this->basedn, $filter);
                $info = ldap_get_entries($ldapconn, $sr);
                $found=false;
                foreach($info as $row)
                {
                    //verify the exact match
                    if ( strcmp($row[$this->idattribute][0],$user->getID()) == 0)
                    {
                        $found=true;
                        unset($row["memberof"]["count"]);
                        $user->setGroups($row["memberof"]);
                        $user->setName($row["givenname"][0],$row["sn"][0],$row["displayname"][0]);
                        break;
                    }                    
                }
                ldap_close($ldapconn);
                return $found;
            } 
        }        
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
        
        $filter='(&' . $this->filter.'(' . $this->idattribute . '='.$id.'*))';        
        $ldapconn = ldap_connect($this->ldap_host,intval($this->ldap_port));
        
        if ($ldapconn) {        
            // binding to ldap server
            $ldapbind = ldap_bind($ldapconn, $this->rootdn, $this->rootdnpwd);
            // verify binding
            if ($ldapbind) {
                //Search from the specified filter
                $sr=ldap_search($ldapconn, $this->basedn, $filter);
                $info = ldap_get_entries($ldapconn, $sr);
                $result=false;
                foreach($info as $row)
                {
                    //verify the exact match
                    if ( strcmp($row[$this->idattribute][0],$id)  == 0)
                    {
                        if (@ldap_bind($ldapconn, $row["distinguishedname"][0], $password))
                        {
                            $result=true;                            
                        }
                        break;
                    }                    
                }
                ldap_close($ldapconn);
                return $result;
            } 
        }
    }
}

class SimpleUserRoleMapper implements UserRoleMapper{
    private $user_list;
    private $group_list;
    public function __construct($users_roles=array(),$groups_roles=array())
    {
        $this->user_list=$users_roles;
        $this->group_list = $groups_roles;
    }
    /**
     * @param User $user Pass the user object to be filled with information
     * */
    public function setUserRoles($user)
    {
        
        //Scan for a user role
        if (array_key_exists($user->getID(),$this->user_list))
        {
            if (is_array($this->user_list[$user->getID()]))
            {
                foreach($this->user_list[$user->getID()] as $role)
                {
                    $user->addUserRole($role);
                }
            }
            else
                $user->addUserRole($this->user_list[$user->getID()]);
        }
        
        
        //Scan for a group role
        foreach ($user->getGroups() as $group_value)
        {
            
            if (isset($this->group_list[trim($group_value)]))
            {
                
                $roles = $this->group_list[trim($group_value)];
                if (is_array($roles))
                {
                    foreach($roles as $role)
                    {
                        $user->addUserRole($role);
                    }
                }
                else
                    $user->addUserRole($roles);
            }
        }
    }
}