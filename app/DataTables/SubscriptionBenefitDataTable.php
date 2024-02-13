<?php

namespace App\DataTables;

use App\Models\SubscriptionBenefit;
use Yajra\DataTables\Services\DataTable;

class SubscriptionBenefitDataTable extends DataTable
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
            ->addColumn('free', function ($row) {
                return view('admin.inc.action', [
                    'free_status' => 'admin.subscriptionbenefit.edit',
                    'data' => $row,
                ]);
            })
            ->addColumn('pro', function ($row) {
                return view('admin.inc.action', [
                    'pro_status' => 'admin.subscriptionbenefit.edit',
                    'data' => $row,
                ]);
            })
            ->addColumn('action', function ($row) {
                return view('admin.inc.action', [
                    'edit' => 'subscriptionbenefit.edit',
                    'delete' => 'subscriptionbenefit.destroy',
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
    public function query(SubscriptionBenefit $model)
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
            ->setTableId('subscriptionbenefit-table')
            ->addColumn(['data' => 'advantage', 'title' => 'Advantage'])
            ->addColumn(['data' => 'free', 'title' => 'Free Status'])
            ->addColumn(['data' => 'pro', 'title' => 'Pro Status'])
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
        return 'SubscriptionBenefit_'.date('YmdHis');
    }
}
