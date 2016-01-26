<?php
namespace reserved\avcpman\gare\copy;

class Control extends \Control
{
    /**
     * @Access(roles="administrator,publisher,editor,viewer",redirect=true)
     */
    public function d()
    {
        
        $month = (int) date("m");
        
        //Get the list of years to be used
        $years=get_years_gare();
        $today_year = (int)date("Y");
        if ($month == 1) {
                $years[((int)date("Y")) - 1]=((int)date("Y")) - 1;
        }
        $years[$today_year]=$today_year;
        unset($years[$today_year]); //is bit oossible to copy item of current year
        asort($years);
        
        //Set default year if no year is selected
        if (!isset($_SESSION["year"])) {
            $_SESSION["year"]=end($years);
            
        }
        else {
            if (!in_array($_SESSION["year"],$years)) {
                $_SESSION["year"]=end($years);
            }
        }            
        
        $all=!!($this->user->isRole("administrator") &&
                isset($_SESSION["all"]) && $_SESSION["all"]);
        
        #List possible destination year
        $years_destination = array();
        if ($_SESSION["year"] < $today_year)
        {
            $y = $_SESSION["year"]+1;
            do {
                $years_destination[$y]=$y;
                $y++;
            } while ($y <= $today_year);
        }
        
        //Pick last destination year as default destination year
        $destination_year = end($years_destination);
        if (isset($this->_s["destination_year"]) and in_array($this->_s["destination_year"],$years_destination))
            $destination_year = $this->_s["destination_year"];
        
        //Retrieve contest 
        if ($all) {
            $gare = get_gare_stream($_SESSION["year"],$destination_year);            
            $view_all = "true";
        } else {
            $gare =get_gare_stream($_SESSION["year"],$destination_year, $this->user->getID());
            $view_all = "false";
        }

        
        
        $gare_warning=array();
        
        //verifiche sui problemi relativi ad una gara
        foreach ($gare as $gid=>$gara) {
            $gare[$gid]->warning=false;
                        
            if ($gara->importo > $gara->importo_liquidato) {
                $gare[$gid]->warning=true;
                $gare_warning[$gid]=$gare[$gid];
                continue;                                
            }
            if (is_null($gara->data_inizio) || is_null($gara->data_fine)) {
                $gare[$gid]->warning=true;
                $gare_warning[$gid]=$gare[$gid];
                continue;                                
            }
            
        }

        return ReturnSmarty('gare.copy.tpl', array("year"=>$_SESSION["year"],
                                              "years"=>$years,
                                              "years_destination"=>$years_destination,
                                              "destination_year"=>$destination_year,
                                              "gare"=>$gare_warning,
                                              "view_all"=>$view_all));
    }

     
    public function set_current_year()
    {
        if (isset($this->_r["year"])) {
            $y = $this->_r["year"]*1;
            $cy = date("Y")*1;
            if (($y > 1950) && ($y <= $cy)) {
                $_SESSION["year"] = $y;
            }
        }
        return ReturnArea($this->status->getSiteView(), $this->status->getArea());
    }
    
    public function set_destination_year()
    {
        if (isset($this->_r["year"])) {
            $y = $this->_r["year"]*1;
            $cy = date("Y")*1;
            if (($y > 1950) && ($y <= $cy)) {
                $this->_s["destination_year"] = $y;
            }
        }
        return ReturnArea($this->status->getSiteView(), $this->status->getArea());
    }
   /**
    * @Access(roles="administrator")
    */
    public function set_view_all()
    {
        if (isset($this->_r["all"])) {
            if (strcmp($this->_r["all"], "true") == 0) {
                $_SESSION["all"] = true;
            } else {
                $_SESSION["all"] = false;
            }
        }
        return ReturnArea($this->status->getSiteView(), $this->status->getArea());
    }
    

    /**
     * @Access(roles="administrator,editor",redirect=true)
     */
    public function submit()
    {
        if ($this->_r["submit"] == "save" and isset($this->_r["gid"])) {
            $gids = $this->_r["gid"];
            $destination_year = $this->_r["destination-year"];
            copy_gare($gids, $destination_year);
            $_SESSION["year"] = $destination_year;
            return ReturnArea($this->status->getSiteView(), "avcpman/gare");
        } else {
            return ReturnArea($this->status->getSiteView(), "avcpman/gare");
        }
    }
}
