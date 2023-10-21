<?php
namespace App\Repositories\Interfaces;

interface IndustryRepositoryInterface
{
    public function store($title);
    public function index();
}