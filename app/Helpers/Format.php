<?php

    namespace App\Helpers;

    class Format
    {
        const Success = "success";
        const Error = "error";

        public static function responseData($processTime, $status, $statusCode, $reason, $message = [], $data = null)
        {
            $result['header']['process_time'] = $processTime;
            $result['header']['status'] = $status;
            $result['header']['status_code'] = $statusCode;
            $result['header']['reason'] = $reason;
            $result['header']['message'] = $message;

            if ($data !== null) {
                $result['data'] = $data;
            }

            return $result;
        }

    }
