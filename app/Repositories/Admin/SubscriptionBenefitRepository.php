<?php

namespace App\Repositories\Admin;

use App\DataTables\SubscriptionBenefitDataTable;
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

    public function index(SubscriptionBenefitDataTable $dataTable)
    {
        return $dataTable->render('admin.subscriptionbenefit.index');
    }

    public function create($repository)
    {
        return view('admin.subscriptionbenefit.create')->with('message', __('static.response.subscription_benefit_added_successfully'));
    }

    public function store($request)
    {
        DB::beginTransaction();
        try {
            $this->model->create([
                'advantage' => $request->advantage,
                'free' => $request->free == true ? true : false,
                'pro' => $request->pro == true ? true : false,
            ]);

            DB::commit();

            return redirect()->route('subscriptionbenefit.index')->with('message', __('static.response.subscription_benefit_added_successfully'));

        } catch (\Exception $e) {

            DB::rollback();

            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function edit($id)
    {
        return view('admin.subscriptionbenefit.edit', ['subscriptionbenefit' => $this->model->find($id)]);
    }

    public function update($request, $id)
    {
        DB::beginTransaction();
        try {

            $this->model->findOrFail($id)->update($request->all());

            DB::commit();

            return redirect()->route('subscriptionbenefit.index')->with('message', __('static.response.subscription_benefit_updated_successfully'));

        } catch (\Exception $e) {

            DB::rollback();

            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {

            $this->model->destroy($id);

            DB::commit();

            return redirect()->route('subscriptionbenefit.index')->with('message', __('static.response.subscription_benefit_deleted_successfully'));

        } catch (Exception $e) {

            DB::rollback();

            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function FreeStatus($request, $id)
    {
        DB::beginTransaction();
        try {

            $subscriptionbenefit = $this->model->findOrFail($id);
            $subscriptionbenefit->update(['free' => $request->status]);

            DB::commit();

        } catch (Exception $e) {

            DB::rollback();
            throw $e;
        }
    }

    public function ProStatus($request, $id)
    {
        DB::beginTransaction();
        try {

            $subscriptionbenefit = $this->model->findOrFail($id);
            $subscriptionbenefit->update(['pro' => $request->status]);

            DB::commit();

        } catch (Exception $e) {

            DB::rollback();
            throw $e;
        }
    }
}
