<?php

  namespace App\Services;
  use Carbon\Carbon;

  class TodoListService
  {
      /**
       * Check if the request due date is late.
       *
       * @param string $request_due_date
       * @return bool
       */
      public function isDateLate($request_due_date): bool
      {
          $date = Carbon::createFromFormat('Y-m-d', $request_due_date);
          return $date < Carbon::now();
      }
      public function setDate()
      {
          $date = Carbon::now();
          return $date->format('Y-m-d-H:i:s');
      }
  }