<?php

namespace App\Http\Controllers\admin;

use App\DataTables\PlanDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreatePlanRequest;
use App\Http\Requests\UpdatePlanRequest;
use App\Models\Plan;
use App\Repositories\Admin\PlanRepository;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    protected $repository;

    public function __construct(PlanRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(PlanDataTable $repository)
    {
        return $this->repository->index($repository);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        return $this->repository->create($request);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreatePlanRequest $request)
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
    public function update(UpdatePlanRequest $request, $id)
    {
        return $this->repository->update($request, $id);
    }

    public function status(Request $request, $id)
    {
        return $this->repository->status($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Plan $plan)
    {
        return $this->repository->destroy($plan->id);
    }
}
