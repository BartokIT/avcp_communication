<?php
//namespace reserved\avcpman\pubblicazioni;
/**
* $action variabile che contiene il nome dell'area corrente
* @Skippable
*/
class Control extends \Control
{
    /**
     * @Access(roles="administrator,publisher",redirect=true  )
     */
    function d()
    {
            //default action
            $pubs = get_pubblicazioni();
            $pubblicazioni=array();
            //TODO: manage index
            $parameters = array("pubblicazioni"=>$pubs);
            if (isset($this->_r["error"]))
            {
                $parameters["error"]=$this->_r["error"];
            }
            return ReturnSmarty('avcp/pubblicazioni.tpl',$parameters);
    }

    
    /**
     * @Access(roles="administrator,publisher"  )
     */
    function delete()
    {
        if (isset($this->_r["anno"]) && isset($this->_r["numero"]))
        {
            $anno = $this->_r["anno"];
            $numero = $this->_r["numero"];
            start_transaction();
            $result = update_gare($anno,$numero,null,null,null,null,null,null,null,null,"NULL",false);
            if (!$result)
            	rollback_transaction();
            $result = delete_pubblicazione($anno,$numero);
            if (!$result)
            	rollback_transaction();
            $result = delete_files($anno,$numero,false);
            if (!$result)
            	rollback_transaction();            
            commit_transaction();            
        }
		return ReturnArea($this->status->getSiteView(),$this->status->getArea());
    }
	
    /**
     * @Access(roles="administrator,publisher"  )
     */    
	function edit()
	{
		if (isset($this->_r["anno"]) && isset($this->_r["numero"]))
        {
            $anno = $this->_r["anno"];
            $numero = $this->_r["numero"];
            return ReturnArea($this->status->getSiteView(),$this->status->getArea()  . "/edit_pubblicazione");
        }
	}

    /**
     * @Access(roles="administrator,publisher"  )
     */    	
	function view()
	{
		if (isset($this->_r["anno"]) && isset($this->_r["numero"]))
        {
            $anno = $this->_r["anno"];
            $numero = $this->_r["numero"];
            return ReturnArea($this->status->getSiteView(),$this->status->getArea()  . "/view_pubblicazione");
        }
	}


    /**
     * @Access(roles="administrator,publisher"  )
     */    	
    function verify_anno()
    {
        if (isset($this->_r["anno"]))
        {
            $anno = $this->_r["anno"];
            if (!is_year_gare_present($anno))
            {
                return ReturnInline(array("trouble"=>true,"message"=>"Non sono presenti gare per l'anno specificato"),"json");
            }
            else if (is_year_publication_present($anno))
            {
                return ReturnInline(array("trouble"=>true,"message"=>"E' stata gia creata una pubblicazione per l'anno richiesto"),"json");
            }
            else
                return ReturnInline(array("trouble"=>false),"json");
        }        
    }

    /**
     * @Access(roles="administrator,publisher"  )
     */        
    function download_file()
    {
        global $xml_writer;
        if (isset($this->_r["anno"]) && isset($this->_r["numero"]))
        {
            $anno = $this->_r["anno"];
            $numero = $this->_r["numero"];
            $filename = get_last_filename($anno, $numero);
            return new \ReturnedFile('get_last_file',array($anno, $numero),
                                     $filename ,"text/xml");
        }
        else
        {
            return ReturnSmarty('avcp/pubblicazioni.tpl',array("pubblicazioni"=>$pubs));            
        }
    }
}
?>
