<?php

namespace App\Http\Controllers\admin;

use App\DataTables\SubscriptionBenefitDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateSubscriptionBenefitRequest;
use App\Repositories\Admin\SubscriptionBenefitRepository;
use Illuminate\Http\Request;

class SubscriptionBenefitController extends Controller
{
    protected $repository;

    public function __construct(SubscriptionBenefitRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(SubscriptionBenefitDataTable $repository)
    {
        return $this->repository->index($repository);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $repository)
    {
        return $this->repository->create($repository);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateSubscriptionBenefitRequest $request)
    {
        return $this->repository->store($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return $this->repository->edit($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        return $this->repository->update($request, $id);
    }

    public function destroy($id)
    {
        return $this->repository->destroy($id);
    }

    public function FreeStatus(Request $request, $id)
    {
        return $this->repository->FreeStatus($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function ProStatus(Request $request, $id)
    {
        return $this->repository->ProStatus($request, $id);
    }
}
