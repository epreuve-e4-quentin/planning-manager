<?php

namespace App\Entity\Quentin;


class PlanningQuentin
{

   public $day;
   public $timeSlot= [8, 16];

   public function __construct($year = null, $month = null, $day = null)
   {
      $this->month = new Month($month, $year);

      if($day === null){
         $day = date("d");
      }

      $this->day = $day;
   
   }

   public function previousDay(){
      return strtotime($this->month->year."-".$this->month->month."-$this->day -1 day");
   }

   public function nextDay(){
      return strtotime($this->month->year."-".$this->month->month."-$this->day +1 day");
   }

   

   public function getDays($max = 4){

      for($day=0; $day<= $max -1; $day++)
        {
            $days[] =  strtotime($this->month->year."-".$this->month->month."-$this->day +$day day");
        }

        return $days;
   }


   // public function getNbDay(): int
   // {
      
   // }
}