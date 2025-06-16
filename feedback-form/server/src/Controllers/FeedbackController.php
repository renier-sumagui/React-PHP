<?php

namespace App\Controllers;

use ErrorException;
use App\Core\Request;
use App\Models\Feedback;
use App\Models\Course;

class FeedbackController
{
    private Feedback $feedback;
    private Course $course;

    public function __construct() {
        $this->feedback = new Feedback();
        $this->course = new Course();
    }

    public function getAll(): array
    {
        $result = $this->feedback->all();

        return $result;
    }

    public function add(Request $request): array
    {
        $data = $request->getBody();

        try {
            $result = $this->feedback->add($data);

            $course = $this->course->getCourse($data['track']);

            $data['track'] = $course;

            return [
                'message' => 'Successfully created feedback', 
                'data' => [
                    'id' => $result,
                    ...$data
                ],
            ];
        } catch (ErrorException $err) {
            return [
                'message' => $err->getMessage(), 
                'success' => false,
            ];
        }
    }
}