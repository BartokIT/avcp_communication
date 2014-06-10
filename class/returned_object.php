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

    abstract class PrintableObject extends ReturnedObject{
		/**
		 * Method that need to be overwrited to implement the print
		 * */
		public function out()
		{
			/**/
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
			return $this->action;
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
    * Class that represent a front-end page, php or html
    * */
    class ReturnedPage extends PrintableObject
    {
		public $page;
		public $parameters;
		public $name_class = __CLASS__;
		
		   /**
			* Constructor of the class 
		* @param string $page The name of the page that contain the front end
			* @param array $parameters The set of parameters to be passed to the page
		**/
		function __construct($page, $parameters=array())
		{
			$this->page = $page;
			$this->parameters = $parameters;
		}
		
		/**
		 * Include the front-end page
		 * */
		public function out()
		{
			$p = $this->parameters;
			include PRESENTATION_PATH . $this->page;
		}
    }
	
    /**
    * Wrapper function that return an object of type ReturnedPage
    * @param string $page The name of the page that contain the front end
    * @param array $parameters The set of parameters to be passed to the page
    **/
    function ReturnPage($page,$parameters=array())
    {
		return new ReturnedPage($page,$parameters);
    }
	
    /**
     * Class that permit to out a string
     * */
    class ReturnedInline extends PrintableObject
    {
		public $data;
		public $type;
		function __construct($data, $type="plain")
		{
			$this->data = $data;
			$this->type = $type;
		}
		
		/**
		 * Out the data passed with given format
		 * */
		public function out()
		{
			if ($this->type == "json")
			{
			echo json_encode($this->data);
			}
			else
			echo $this->data;
		}
    }
	
    /**
     * Wrapper to the ReturnedInline class
     **/
    function ReturnInline($data,$type="plain")
    {
	    return new ReturnedInline($data,$type);
    }
	

?>
