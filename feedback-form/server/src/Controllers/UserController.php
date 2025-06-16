<?php

namespace App\Controllers;

use App\Core\Request;

class UserController 
{
  public function index(Request $request): array 
  {
    return ['users' => 
      [
        ['id' => 1, 'name' => 'Renier']
      ]
    ];
  }

  public function store(Request $request): array
  {
    $data = $request->getBody();
    return ['message' => 'User created', 'data' => $data];
  }
}