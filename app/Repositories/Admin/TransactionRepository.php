<?php

namespace App\Repositories\Admin;

use App\DataTables\TransactionDatatable;
use App\Models\Transaction;
use Exception;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Eloquent\BaseRepository;

class TransactionRepository extends BaseRepository
{
    protected $fields = [
        'total',
        'status',
        'plan_id',
        'user_id',
        'payment_id',
        'payment_method',
    ];

    public function model()
    {
        return Transaction::class;
    }

    public function index(TransactionDatatable $dataTable)
    {
        return $dataTable->render('admin.transaction.index');
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {

            $this->model->destroy($id);
            DB::commit();

            return redirect()->route('transaction.index')->with('message', __('static.response.transaction_deleted_successfully'));

        } catch (Exception $e) {

            DB::rollback();

            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
