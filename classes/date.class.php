<?php
date_default_timezone_set('Europe/London');

    class DateClass
    {
        //Class Varibles
        var $day;
        var $month;
        var $year;
        var $hour;
        var $minute;
        var $second;

        function setnormaldatetime($normaldate)
        {
          //echo$normaldate;
            if(substr($normaldate,2,1) == "/"){
                //Normal Date
                $this->day = substr($normaldate,0,2);
                $this->month = substr($normaldate,3,2);
                $this->year = substr($normaldate,6,4);
                $this->hour = substr($normaldate,11,2);
                $this->minute = substr($normaldate,14,2);
                $this->second = substr($normaldate,17,2);
            } else {
                //Database Datetime
                $this->year = substr($normaldate,0,4);
                $this->month = substr($normaldate,5,2);
                $this->day = substr($normaldate,8,2);
                $this->hour = substr($normaldate,11,2);
                $this->minute = substr($normaldate,14,2);
                $this->second = substr($normaldate,17,2);
            }
        }
        //Get Normal Date & Time
        function getnormaldatetime($Second = false)
        {
            $SecondString = $Second ? ":" . $this->second : "";
            return $this->day . "/" . $this->month . "/" . $this->year . " " . $this->hour . ":" . $this->minute . $SecondString;
        }
        //Get String Date Short Format
        function stringdateshort()
        {
            return $this->day . " " . $this->monthstring . " " . $this->year;
        }
        //Set Database Date
        function setdatabasedate($databasedate)
        {
            $this->year = substr($databasedate,0,4);
            $this->month = substr($databasedate,5,2);
            $this->day = substr($databasedate,8,2);
        }

        //Get Database Date & Time
        function getdatabasedate()
        {
            return $this->year . "/" . $this->month . "/" . $this->day;
        }
        function setdatabasedatetime($databasedate)
        {
            $this->year = substr($databasedate,0,4);
            $this->month = substr($databasedate,5,2);
            $this->day = substr($databasedate,8,2);
            $this->hour = substr($databasedate,11,2);
            $this->minute = substr($databasedate,14,2);
            $this->second = substr($databasedate,17,2);
        }

        //Get Database Date & Time
        function getdatabasedatetime()
        {
            $Second = $this->second == '' ?  '00' : $this->second;
            return $this->year . "-" . $this->month . "-" . $this->day . " " . $this->hour . ":" . $this->minute . ":" . $Second;
        }

        //Set Day
        function setday($day)
        {
            $this->day = $day;
        }
        //Get Day
        function getday()
        {
            return $this->day;
        }
        //Get Month
        function getmonth()
        {
            if($this->month <= 9){
                return "0" . $this->month;
            } else {
                return "" . $this->month;
            }
        }
        //Set Month
        function setmonth($month)
        {
            $this->month = $month;
        }        
        //Set Year
        function setyear($year)
        {
            $this->year = $year;
        }
        //Get Year
        function getYear()
        {
            return $this->year;
        }
        function getdatestring()
        {
          return $this->getdaystring() . " " . $this->getmonthstring() . " " . $this->getYear();
        }
        //Date Class Constructor
        function DateClass($classdate = 0, $datestring = 0, $day = 0, $month = 0, $year = 0, $datetimestring = 0)
        {
            if($classdate)
            {
                //New Date from Class
                $this->day = $classdate->day;
                $this->month = $classdate->month;
                $this->year = $classdate->year;
                $this->hour = $classdate->hour;
                $this->minute = $classdate->minute;
                $this->second = $classdate->second;
            } else if($datestring) {
                //New Date from String
                $this->setnormaldate($datestring);
            } else if($day && $month && $year){
                //New Date from Day Month Year
                $this->day = $day;
                $this->month = $month;
                $this->year = $year;
            } else if($datetimestring != 0){
              //New Date & Time from String
              $this->setnormaldatetime($datetimestring);
            } else {
                //Today
                $this->day = date("d");
                $this->month = date("m");
                $this->year = date("Y");
                $this->hour = date("H");
                $this->minute = date("i");
                $this->second = date("s");
            }
        }

        //Add Days to Date
        function adddays($numberofdays)
        {
            do{
                if(($this->day + $numberofdays) <= $this->daysinamonth()){
                    //Can Add Days
                    $this->day += $numberofdays;
          					if($this->day <= 9)
          					{
          						$this->day = "0" . $this->day;
          					}
                    $numberofdays = 0;
                    } else {
                      //Add Month
                      $this->day = "01";
                      $this->addmonths(1);
                     $numberofdays -= ($this->daysinamonth() - $this->day);
                    }
            }while($numberofdays>0);

        }

        //Add Days to Date and return the new date
        function adddaysreturn($numberofdays)
        {
            do{
                if(($this->day + $numberofdays) <= $this->daysinamonth()){
                    //Can Add Days
                    $this->day += $numberofdays;
          					if($this->day <= 9)
          					{
          						$this->day = "0" . $this->day;
          					}
                    $numberofdays = 0;
                    } else {
                      $this->day = ($this->day + $numberofdays) - $this->daysinamonth();
                      if($this->day <= 9)
            					{
            						$this->day = "0" . $this->day;
            					}
                      //Add Month
                      $this->addmonths2(1);
                     $numberofdays -= ($this->daysinamonth() - $this->day);
                    }
            }while($numberofdays>0);
            return$this;
        }

        //Add Months to Date
        function addmonths($numberofmonths)
        {
            do{
                if(($this->month + $numberofmonths) <= 12){
                    $this->month += $numberofmonths;
        					if($this->month <= 9)
        					{
        						$this->month = "0" . $this->month;
        					}
                    $numberofmonths = 0;
                } else {
                    $numberofmonths -= (12 - $this->month);
                    $numberofmonths = 1;
                    $this->addyears(1);
                }
            }while($numberofmonths>0);
        }

        //Add Months to Date
        function addmonths2($numberofmonths)
        {
            if(($this->month + $numberofmonths) <= 12){
              $this->month += $numberofmonths;
            }else{
              $this->month = ($this->month + $numberofmonths) - 12;
              $this->addyears(1);
            }
        }

        //Add Years to Date
        function addyears($numberofyears)
        {
            $this->year += $numberofyears;
        }

        //Check Date is Valid
        function valid()
        {
            if($this->month<=12){
                if($this->day > $this->daysinamonth()){
                    return false;
                } else {
                    return true;
                }
            } else {
                return false;
            }
        }

        //Check if Year is Leap Year
        function isleapyear()
        {
            return ($this->year%400==0) || ($this->year%4==0 && $this->year%100!=0);
        }

        //Number of Days in this Month
        function daysinamonth()
        {
            switch($this->month)
            {
                case 1: return 31;
                case 2: if($this->isleapyear){ return 28; } else { return 29; }
                case 3: return 31;
                case 4: return 30;
                case 5: return 31;
                case 6: return 30;
                case 7: return 31;
                case 8: return 31;
                case 9: return 30;
                case 10: return 31;
                case 11: return 30;
                case 12: return 31;
            }
        }

        //Dates Equal
        function equals($classdate2)
        {
            if(($this->day == $classdate2->day) && ($this->month == $classdate2->month) && ($this->year == $classdate2->year)){
                return true;
            } else {
                return false;
            }
        }

        //Dates Greater Than
        function greaterthan($classdate2)
        {
            if($this->getdatabasedate() > $classdate2->getdatabasedate()){
                return true;
            } else {
                return false;
            }
        }

        //Dates Less Than
        function lessthan($classdate2)
        {
            if($this->getdatabasedate() < $classdate2->getdatabasedate()){
                return true;
            } else {
                return false;
            }
        }

        //To String
        function tostring()
        {
            return $this->getnormaldate();
        }

    }

?>
