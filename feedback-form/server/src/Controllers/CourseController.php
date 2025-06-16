<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\Course;
use ErrorException;

class CourseController
{
    private Course $course;

    public function __construct() 
    {
        $this->course = new Course();
    }

    public function getAll(): ?array 
    {
        try {
            $result = $this->course->getCoures();

            return [
                "message" => "Successfully fetched courses.",
                "success" => 1,
                "data" => $result,
            ];
        } catch (ErrorException $err) {
            http_response_code(417);

            return [
                "message" => "Something went wrong",
                "success" => 0
            ];
        }
    }
}