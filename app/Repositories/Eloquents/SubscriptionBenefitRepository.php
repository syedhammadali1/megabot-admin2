<?php

namespace App\Repositories\Eloquents;

use App\Exceptions\ExceptionHandler;
use App\Models\SubscriptionBenefit;
use Exception;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Eloquent\BaseRepository;

class SubscriptionBenefitRepository extends BaseRepository
{
    protected $fields = [
        'pro',
        'free',
        'advantage',
    ];

    public function model()
    {
        return SubscriptionBenefit::class;
    }

    public function index()
    {
        try {
            $subscriptionBenefits = $this->model->all();

            $formattedBenefits = $subscriptionBenefits->map(function ($benefit) {
                return [
                    'id' => $benefit->id,
                    'advantage' => $benefit->advantage,
                    'free' => boolval($benefit->free),
                    'pro' => boolval($benefit->pro),
                    'created_at' => $benefit->created_at,
                    'updated_at' => $benefit->updated_at,
                ];
            });

            return response()->json([
                'subscriptionBenefits' => $formattedBenefits,
            ]);

        } catch (Exception $e) {

            DB::rollback();
            throw new ExceptionHandler($e->getMessage(), $e->getCode());
        }
    }
}
