<?php
namespace reserved\avcpman\gare\edit_partecipanti;
class Control extends \Control
{
    /**
     * Summary
     * @Access(roles="administrator,editor",redirect=true  )
     * @return object  Description
     */
    function d(){
       global $contest_type;
       global $ruoli_partecipanti_raggruppamento;
        if (isset($this->_r["parameter"]) || isset($this->_s["gid"]) )
        {
            $gid  = (int) isset($this->_r["parameter"])?$this->_r["parameter"]:$this->_s["gid"];
            $this->_s["gid"]=$gid;
            $gara =get_gara($gid);
            $partecipanti = get_partecipanti($gid);
            //default action
			$p = array("gara"=>$gara,
						"partecipanti"=>$partecipanti,
						"contest_type"=>$contest_type,
						"ruoli_raggruppamento"=>$ruoli_partecipanti_raggruppamento);
			if (isset($this->_r["error"]))
				$p["error"] = $this->_r["error"];
				
            return ReturnSmarty('gare.edit_partecipanti.tpl',$p);
        }
        else
            return ReturnArea($this->status->getSiteView(),"avcpman/gare");
    }

    /**
     * Summary
     * @Access(roles="administrator,editor")
     */    
    function save()
    {
        if ($this->_r["submit"] == "save")
        {
            $gid= $this->_r["gid"];
			
            if (isset($this->_r["aggiudicatario"]))
            {
                $pids= $this->_r["aggiudicatario"];
                update_aggiudicatari($gid,$pids);
            }
        }
        return ReturnArea($this->status->getSiteView(),"avcpman/gare");
    }

    /**
     * Summary
     * @Access(roles="administrator,editor")
     */        
    function add_raggruppamento()
    {
        if (isset($this->_r["parameter"]))
        {
            $gid  = (int) $this->_r["parameter"];
            insert_raggruppamento($gid);
        }
        return ReturnArea($this->status->getSiteView(),"avcpman/gare/edit_partecipanti");
    }

    /**
     * Summary
     * @Access(roles="administrator,editor")
     */        
    function delete_raggruppamento()
    {
        if (isset($this->_r["pid"]))
        {
            $pid  = (int) $this->_r["pid"];
            //delete_raggruppamento($pid);
			delete_partecipante($pid,"R");
            return ReturnArea($this->status->getSiteView(),"avcpman/gare/edit_partecipanti",NULL, array("parameter"=>$this->_r["gid"]));
        }
        return ReturnArea($this->status->getSiteView(),"avcpman/gare/edit_partecipanti");
        
    }
	
    /**
     * Summary
     * @Access(roles="administrator,editor")
     */          	
    function delete_ditta_raggruppamento()
	{
		if (isset($this->_r["pid"]) && isset($this->_r["did"]))
        {
            $pid  = (int) $this->_r["pid"];
			$did  = (int) $this->_r["did"];
            delete_ditta_raggruppamento($pid, $did);
            return ReturnArea($this->status->getSiteView(),"avcpman/gare/edit_partecipanti",NULL, array("parameter"=>$this->_r["gid"]));
        }
	}
    /**
	
     * Summary
     * @Access(roles="administrator,editor")
     */        	
    function delete_ditta()
    {
        if (isset($this->_r["pid"]))
        {
            $pid  = (int) $this->_r["pid"];
            delete_partecipante($pid,"D");
            return ReturnArea($this->status->getSiteView(),"avcpman/gare/edit_partecipanti",NULL, array("parameter"=>$this->_r["gid"]));
        }
    }
    
      /**
     * Summary
     * @Access(roles="administrator,editor")
     */          	
    function add_ditta()
    {
        return ReturnArea($this->status->getSiteView(),"avcpman/gare/edit/add_ditta");
    }
    
    
}
?>