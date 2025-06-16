<?php

use App\Controllers\TestController;
use App\Controllers\UserController;
use App\Controllers\CommentController;
use App\Controllers\ReplyController;

$router->get('/', [new TestController(), 'index']);
$router->post('/auth/signup', [new UserController(), 'signUp']);
$router->post('/auth/signin', [new UserController(), 'signIn']);
$router->get('/auth/signout', [new UserController(), 'signOut']);
$router->get('/auth/check', [new UserController(), 'isLoggedIn']);

// Comment
$router->get('/comment/getall', [new CommentController(), 'getAllWithReplies']);
$router->post('/comment/create', [new CommentController(), 'createComment']);

// Reply
$router->post('/reply/create', [new ReplyController(), 'createReply']);