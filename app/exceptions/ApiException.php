<?php

namespace App\Exceptions;

use App\Enums\ExceptionType;
use Exception;

class ApiException extends Exception
{
    // enum
    protected $type;
    // constructor
    public function __construct(ExceptionType $type)
    {
        $this->type = $type;
    }

    public function render(){

      // use case condtions
      switch ($this->type) {
          case ExceptionType::ROLE_NOT_ALLOWED:
              return response()->json([
                  "message" => $this->type,
                 
              ],403);
          case ExceptionType::UNAUTHORIZED:
              return response()->json([
                  "message" => $this->type,
                 
              ],401);
          case ExceptionType::RESOURCE_NOT_FOUND:
              return response()->json([
                  "message" => $this->type,
                 
              ],404);
          case ExceptionType::SERVER_ERROR:
              return response()->json([
                  "message" => $this->type,
                 
              ],500);
      }
    }
}
