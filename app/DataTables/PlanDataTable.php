<?php

namespace App\DataTables;

use App\Models\Plan;
use Yajra\DataTables\Services\DataTable;

class PlanDataTable extends DataTable
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
            })->addColumn('status', function ($row) {
                return view('admin.inc.action', [
                    'plan_status' => 'admin.plan.edit',
                    'data' => $row,
                ]);
            })->addColumn('action', function ($row) {
                return view('admin.inc.action', [
                    'edit' => 'plan.edit',
                    'delete' => 'plan.destroy',
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
    public function query(Plan $model)
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
            ->setTableId('plans-table')
            ->addColumn(['data' => 'name', 'title' => 'Name'])
            ->addColumn(['data' => 'plan_type', 'title' => 'Plan Type'])
            ->addColumn(['data' => 'offertime', 'title' => 'Offer Time'])
            ->addColumn(['data' => 'amount', 'title' => 'Amount'])
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
        return 'Plan_'.date('YmdHis');
    }
}
