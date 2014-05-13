 <?php

    //Classe astratta utilizzata per le info restituite da una funzione di esecuzione
    abstract class ReturnedObject
    {
	public $name_class = __CLASS__; //giusto per riempirla
    }
    
    class NilObject extends ReturnedObject
    {
	public $error;
	public $message;
	function __construct()
	{
	}
    }
    
    abstract class BackObject extends ReturnedObject {
	
    }
    
    
    //Classe da utilizzare per restituire una pagina da visualizzare
    class ReturnedPage 
    {
	public $page;
	public $parameters;
	public $name_class = __CLASS__;
	function __construct($page, $parameters=array())
	{
	    $this->page = $page;
	    $this->parameters = $parameters;
	}
    }
    
    function ReturnHTMLPage($page,$parameters=array())
    {
	return new ReturnedPage($page,$parameters);
    }
    
    class ReturnedArea extends BackObject
    {
	private $status;
	private $action=NULL;
	
	public $name_class = __CLASS__;
	function __construct($site_view, $area, $action=NULL)
	{
	    //Create and store the new state
	    $this->status = new State($site_view,$area);
	    $this->action = $action;
	}
	public function getStatus()
	{
	    return $this->status;
	}
	public function getAciton()
	{
	    return $action;
	}
    }
    
    function ReturnArea($site_view,$area)
    {
	return new ReturnedArea($site_view,$area);	
    }
    
    //Classe da utilizzare per una richiesta di tipo Ajax
    class ReturnedAjax extends ReturnedObject
    {
	public $name_class = __CLASS__;
	public $code;
	
	function __construct($mode="json",$code)
	{
	    if (strcmp($mode,"json") == 0)
		    $this->code = json_encode($code);
	    else
		    $this->code = $code;
	}
    }


    
?>
