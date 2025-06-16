<?php

use App\Controllers\UserController;
use App\Controllers\FeedbackController;
use App\Controllers\CourseController;

$router->get('/users', [new UserController(), 'index']);
$router->post('/users', [new UserController(), 'store']);
$router->get('/feedbacks', [new FeedbackController(), 'getall']);
$router->post('/feedback', [new FeedbackController(), 'add']);
$router->get('/courses', [new CourseController(), 'getAll']);