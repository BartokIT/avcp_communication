<?php
//namespace reserved\locroyalties\loclist;

/**
* $action variabile che contiene il nome dell'area corrente
* @Skippable
*/
class Control extends \Control
{
    /**
     * @Access(roles="administrator,publisher,editor,viewer",redirect=true)
     */
    public function d()
    {

        return ReturnSmarty('locroyalties/alloggi.tpl',array("contract"=>array()));
    }
}
