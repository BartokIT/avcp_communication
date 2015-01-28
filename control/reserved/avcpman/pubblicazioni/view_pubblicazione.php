<?php
namespace reserved\avcpman\pubblicazioni\view_pubblicazione;
class Control extends \Control
{
    /**
     * @Access(roles="administrator,publisher"  )
     */    
    function d(){
        if (isset($this->_r["anno"]) && isset($this->_r["numero"]))
        {
            $anno  = (int) $this->_r["anno"];
			$numero =  (int) $this->_r["numero"];
			$p = (array)get_pubblicazione_detail($anno,$numero);
			$file_list = get_files_list($anno,$numero);
			$p["files"] = $file_list;
            return ReturnSmarty('pubblicazione.view.tpl',$p);
        }
        else
            return ReturnArea($this->status->getSiteView(),"avcpman/pubblicazioni");
    }

    /**
     * @Access(roles="administrator,publisher"  )
     */        
    function download_file()
    {
        global $xml_writer;
        if (isset($this->_r["fid"]))
        {
            $fid = $this->_r["fid"];
            $filename=get_file_filename($fid);
            return new \ReturnedFile('get_file',array($fid),
                                     $filename,"text/xml");			
        }
        else
        {
            return ReturnSmarty('pubblicazioni.tpl',array("pubblicazioni"=>$pubs));            
        }
    }
    
}
?>
