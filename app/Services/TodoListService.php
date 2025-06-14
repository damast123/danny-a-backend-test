<?php

  namespace App\Services;

  use App\Models\TodoList;
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

      public function getChartData($type) {
          switch ($type['type']) {
            case 'status':
              return $this->getStatusChartData();
            case 'assignee':
              return $this->getAssigneeChartData();
            case 'priority':
              return $this->getPriorityChartData();
            default:
              return [];
          }
      }
      private function getStatusChartData() {
          $statuses = TodoList::select('status')
              ->selectRaw('COUNT(*) as count')
              ->groupBy('status')
              ->pluck('count', 'status');

          return [
              'status_summary' => $statuses
          ];
      }
      private function getAssigneeChartData() {
          $assignees = TodoList::all();
          $summary = [];

          foreach ($assignees->groupBy('assignee') as $assignee => $group) {
              $summary[$assignee] = [
                  'total_todos' => $group->count(),
                  'total_pending_todos' => $group->where('status', 'pending')->count(),
                  'total_time_complete_todos' => $group
                      ->where('status', 'complete')
                      ->sum('time_tracked'),
              ];
          }
          return [
              'assignee_summary' => $summary
          ];
      }
      private function getPriorityChartData() {
          $priorities = TodoList::select('priority')
              ->selectRaw('COUNT(*) as count')
              ->groupBy('priority')
              ->pluck('count', 'priority');

          return [
              'priority_summary' => $priorities
          ];
      }
  }