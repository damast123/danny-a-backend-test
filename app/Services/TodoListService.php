<?php

  namespace App\Services;
  use Carbon\Carbon;

  class TodoListService
  {
      public function isDateLate($request_due_date): bool
      {
          $date = Carbon::createFromFormat('Y-m-d', $request_due_date);
          return $date < Carbon::now();
      }
  }