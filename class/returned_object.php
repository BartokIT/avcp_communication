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
	
    /**
     * Base class used to specify that is necessary another cycle in main flow
     * */
    abstract class BackObject extends ReturnedObject {	
    }
    /**
	 * Base classe use to specify that the output is printable
	 * */
    abstract class PrintableObject extends ReturnedObject{
		public $page;
		public $parameters;
		public $name_class = __CLASS__;
		
		function __construct($page, $parameters=array())
		{
			$this->page = $page;
			$this->parameters = $parameters;
		}
		public function getPage()
		{
			return $this->page;
		}
	}
	
    
	/**
	 * This class represent a site area used to address
	 * the execution flows
	 * */
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
		
		public function getAction()
		{
			return $action;
		}
    }
    /**
	 * Wrapper function that return an object
	 * of type ReturnedArea
	 * */
    function ReturnArea($site_view,$area,$action=NULL)
    {
		return new ReturnedArea($site_view,$area,$action);	
    }
    
	/**
     * Class that represent a front-end php page
     * */
    class ReturnedPage extends PrintableObject
    {
		
    }
	
	/**
	 *Returned page
	 **/
	function ReturnPage($page,$parameter=NULL)
	{
		return new ReturnedPage($page,$parameter=NULL);
	}
	
	/**
     * Class that represent a front-end html page
     * */
    class ReturnedHTMLPage extends PrintableObject
    {
		
    }
	
	/**
	 *Returned page
	 **/
	function ReturnHTMLPage($page)
	{
		return new ReturnedHTMLPage($page);
	}
	
    //Classe da utilizzare per una richiesta di tipo Ajax
    class ReturnedAjax extends PrintableObject
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
