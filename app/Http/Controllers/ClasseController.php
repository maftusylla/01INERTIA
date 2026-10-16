<?php

namespace App\Http\Controllers;

use App\Services\ClasseDatabaseService;

class ClasseController extends Controller
{
public function index(ClasseDatabaseService $classeDatabaseService){

    return $data=$classeDatabaseService->lire();
    var_dump($data);
}
}


