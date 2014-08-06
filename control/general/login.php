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
            //echo "<p>login\n</p>";
			return ReturnSmarty("login.tpl");
            //return $this->user->login("claudio.papa","Inpdap02");
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
			return ReturnArea("avcpman","gare");
		}
	}
}
?>
