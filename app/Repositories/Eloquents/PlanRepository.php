<?php

namespace App\Repositories\Eloquents;

use App\Models\Plan;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class PlanRepositoryEloquent.
 */
class PlanRepository extends BaseRepository
{
    protected $fields = [
        'name',
        'amount',
        'status',
        'plan_type',
        'offertime',
    ];

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Plan::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function index()
    {
        return $this->model->where('status', true)->get();
    }
}
