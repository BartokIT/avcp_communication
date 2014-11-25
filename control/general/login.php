<?php
namespace general\login;
/**
* $action variabile che contiene il nome dell'area corrente
* @Skippable
*/
class Control extends \Control
{
    /**
     * Summary
     * @return object  Description
     */
    function d(){
       //default action		
		return ReturnSmarty("login.tpl");	
    }
	
	function login()
	{
		$username=$this->_r["user"];
		$password=$this->_r["passwd"];
		$result= $this->user->login($username,$password);
		if ($result == FALSE)
		{
			return ReturnSmarty("login.tpl",array("error"=>"Inserire <em>username</em> e<br/> <em>password</em> corretti"));
		}
		else
		{
			return ReturnArea("reserved","home");
		}
	}
	
	function logout()
	{
		$result= $this->user->logout();
		return ReturnArea("general","home");			
	}
}
?>
