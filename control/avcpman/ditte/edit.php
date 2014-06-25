<?php
namespace avcpman\ditte\edit;
class Control extends \Control
{
    /**
     * Summary
     * @Access(roles="administrator,editors",redirect=true  )
     * @return object  Description
     */
    function d(){
            $did  = (int) $this->_r["parameter"];
            $ditta =get_ditta($did);
            //default action
            return ReturnSmarty('ditte.edit.tpl',array("ditta"=>$ditta));
    }    
}
?>