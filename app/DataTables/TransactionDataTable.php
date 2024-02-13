<?php

namespace App\DataTables;

use App\Models\Transaction;
use Yajra\DataTables\Services\DataTable;

class TransactionDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param  mixed  $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addIndexColumn()
            ->addColumn('created_at', function ($row) {
                return $row->created_at->diffForHumans();
            })
            ->addColumn('user_name', function ($row) {
                return $row->user->name;
            })
            ->addColumn('plan_name', function ($row) {
                return $row->plan->name;
            })
            ->addColumn('action', function ($row) {
                return view('admin.inc.action', [
                    'delete' => 'transaction.destroy',
                    'data' => $row,
                ]);
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param  \App\Models\User  $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Transaction $model)
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('transaction-table')
            ->addColumn(['data' => 'user_name', 'title' => 'User Name'])
            ->addColumn(['data' => 'total', 'title' => 'Total Amount'])
            ->addColumn(['data' => 'payment_method', 'title' => 'Payment Method'])
            ->addColumn(['data' => 'payment_id', 'title' => 'Payment ID'])
            ->addColumn(['data' => 'plan_name', 'title' => 'Plan'])
            ->addColumn(['data' => 'status', 'title' => 'Status'])
            ->addColumn(['data' => 'action', 'title' => 'Action'])
            ->minifiedAjax()
            ->orderBy(1)
            ->parameters(['stateSave' => true]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [];
    }

    /**
     * Get filename for export.
     */
    protected function filename(): string
    {
        return 'Transaction_'.date('YmdHis');
    }
}
