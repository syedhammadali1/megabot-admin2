<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateTransactionRequest;
use App\Repositories\Eloquents\TransactionRepository;

class TransactionController extends Controller
{
    protected $repository;

    public function __construct(TransactionRepository $repository)
    {
        $this->repository = $repository;
    }

    public function store(CreateTransactionRequest $request)
    {
        return $this->repository->store($request);
    }
}
