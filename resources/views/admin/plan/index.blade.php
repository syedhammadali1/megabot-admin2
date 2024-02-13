@extends('admin.layouts.master')

@section('title', __('static.plan.all_plans'))

@section('content')
    <div class="card">
        <div class="card-header d-flex flex-sm-row flex-column gap-sm-0 gap-2 align-items-sm-center">
            <h5>{{ __('static.plan.all_plans') }}</h5>
            <div class="btn-popup ms-sm-auto ms-0 mb-0">
                <a href="{{ route('plan.create') }}" class="btn btn-primary">{{ __('Create') }}</a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                {!! $dataTable->table() !!}
            </div>
        </div>
    </div>
@endsection

@push('js')
    {!! $dataTable->scripts() !!}
@endpush
