<?php

namespace App\Http\Services;

use App\Http\Repositories\KomselRepository;


class komselService
{

    protected $komsel_repo;

    public function __construct(KomselRepository $komselRepository){
        $this->komsel_repo = $komselRepository;
    }

    public function getAll(){

    }
    
}

