<?php

  namespace App\Services;

  class ReturnResponse
  {
      public function ResponseMessage($data, $statusCode, $message, $type)
      {
          // Validate the status code
          if ($type == 'error') {
              return response()->json([
                  'status' => $type,
                  'message' => $message,
              ], $statusCode);
          }
          return response()->json([
              'status' => $type,
              'data' => $data
          ], $statusCode);
      }
  }