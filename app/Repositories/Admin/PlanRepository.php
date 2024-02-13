<?php

namespace App\Repositories\Admin;

use App\DataTables\PlanDataTable;
use App\Models\Plan;
use Exception;
use Illuminate\Support\Facades\DB;
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

    public function index(PlanDataTable $dataTable)
    {
        return $dataTable->render('admin.plan.index');
    }

    public function create($repository)
    {
        return view('admin.plan.create')->with('message', __('static.response.plan_added_successfully'));
    }

    public function store($request)
    {
        DB::beginTransaction();
        try {
            $this->model->create([
                'name' => $request->name,
                'plan_type' => $request->plan_type,
                'offertime' => $request->offertime,
                'amount' => $request->amount,
            ]);

            DB::commit();

            return redirect()->route('plan.index')->with('message', __('static.response.plan_added_successfully'));

        } catch (\Exception $e) {

            DB::rollback();

            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function edit($id)
    {
        return view('admin.plan.edit', ['plan' => $this->model->find($id)]);
    }

    public function update($request, $id)
    {
        DB::beginTransaction();
        try {

            $this->model->findOrFail($id)->update($request->all());

            DB::commit();

            return redirect()->route('plan.index')->with('message', __('static.response.plan_updated_successfully'));

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

            return redirect()->route('plan.index')->with('message', __('static.response.plan_deleted_successfully'));

        } catch (Exception $e) {

            DB::rollback();

            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function status($request, $id)
    {
        DB::beginTransaction();
        try {

            $plan = $this->model->findOrFail($id);
            $plan->update(['status' => $request->status]);

            DB::commit();

        } catch (Exception $e) {

            DB::rollback();
            throw $e;
        }
    }
}
