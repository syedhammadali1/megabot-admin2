<?php

namespace App\Repositories\Eloquents;

use App\Exceptions\ExceptionHandler;
use App\Models\Plan;
use App\Models\Transaction;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class PlanRepositoryEloquent.
 */
class TransactionRepository extends BaseRepository
{
    protected $plan;

    protected $fields = [
        'total',
        'status',
        'plan_id',
        'user_id',
        'payment_id',
        'payment_method',
        'plan_expires',
    ];

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        $this->plan = new Plan();

        return Transaction::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function store($request)
    {
        DB::beginTransaction();
        try {
            $plan = $this->plan->find($request->plan_id);
            $expirationDurations = config('enums.durations');
            $expires = null;

            if (array_key_exists($plan->plan_type, config('enums.durations'))) {
                $durationInterval = $expirationDurations[$plan->plan_type];
                $expires = $durationInterval !== null ? Carbon::parse($durationInterval)->format('Y-m-d H:i:s') : null;
            }
            $transaction = $this->model->create([
                'total' => $request->total,
                'status' => $request->status,
                'plan_id' => $request->plan_id,
                'user_id' => $request->user_id,
                'payment_id' => $request->payment_id,
                'payment_method' => $request->payment_method,
                'plan_expires' => $expires,
            ]);

            DB::commit();

            return [
                'transaction' => $transaction,
                'success' => true,
            ];

        } catch (Exception $e) {

            DB::rollback();
            throw new ExceptionHandler($e->getMessage(), $e->getCode());
        }
    }
}
