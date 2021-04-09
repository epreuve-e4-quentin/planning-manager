<?php

namespace App\Entity\Quentin;


class Month
{

   private $months = ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre"];
   public $month;
   public $year;


   public function __construct(?int $month = null, ?int $year = null)
   {
      if ($month === null) {
         $month = intval(date('m'));
      }
      if ($year === null) {
         $year = intval(date('Y'));
      }

      if ($month < 1 || $month > 12) {
         throw new \Exception("Le mois n'est pas valide");
      }

      if ($year < 1970 || $month > 12) {
         throw new \Exception("L'année est inferieur à 1970, impossible de continuer");
      }
      $this->month = $month;
      $this->year = $year;
   }

   public function toString(): string
   {

      return $this->months[$this->month - 1] . " " . $this->year;
   }

   public function getNbWeeks(): int
   {
      $start = new \DateTime("{$this->year}-{$this->month}-01");
      $end = (clone $start)->modify("+1 month - 1 day");

      $weeks = intval($end->format('W')) - intval($start->format("W")) + 1;

      if ($weeks < 0) {
         $weeks = intval($end->format('W'));
      }

      return $weeks;
   }
}
