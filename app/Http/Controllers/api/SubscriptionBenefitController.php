<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Repositories\Eloquents\SubscriptionBenefitRepository;

class SubscriptionBenefitController extends Controller
{
    protected $repository;

    public function __construct(SubscriptionBenefitRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        return $this->repository->index();
    }
}
