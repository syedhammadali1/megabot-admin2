@extends('admin.layouts.master')

@section('title', __('static.plan.edit_plan'))

@section('content')
    <div class="row">
        <div class="col-sm-10 col-xxl-8 mx-auto">
            <div class="card tab2-card">
                <div class="card-header">
                    <h5>{{ __('static.plan.edit_plan') }}</h5>
                </div>
                {!! Form::open([
                    'route' => ['plan.update',$plan->id],
                    'method' => 'PUT',
                    'class' => 'needs-validation user-add',
                ]) !!}
                <div class="card-body">
                    <div class="form-group row">
                        {!! Form::label('name', __('static.name') . ' <span>*</span>', ['class' => 'col-xl-3 col-md-4'], false) !!}
                        <div class="col-xl-9 col-md-8">
                            {!! Form::text('name',isset($plan->name)? $plan->name : old('name'), ['class' => 'form-control']) !!}
                            @error('name')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        {!! Form::label('plan_type', __('static.plan.plan_type') . ' <span>*</span>', ['class' => 'col-xl-3 col-md-4'], false) !!}
                        <div class="col-xl-9 col-md-8">
                            <select class="form-control" id="plan_type" name="plan_type">
                                <option value="">Select Category</option>
                                    <option value="weekly" @if($plan->plan_type == 'weekly') selected @endif>{{ __('weekly')}}</option>
                                    <option value="monthly" @if($plan->plan_type == 'monthly') selected @endif>{{__('monthly')}}</option>
                                    <option value="lifetime" @if($plan->plan_type == 'lifetime') selected @endif>{{__('lifetime')}}</option>
                            </select>
                            @error('plan_type')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                    </div>
                    <div class="form-group row">
                            {!! Form::label('offertime', __('static.plan.offer_time') . ' <span>*</span>', ['class' => 'col-xl-3 col-md-4'], false) !!}
                            <div class="col-xl-9 col-md-8">
                                {!! Form::text('offertime', isset($plan->offertime)? $plan->offertime : old('android_plan_Key'), ['class' => 'form-control']) !!}
                                @error('offertime')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>

                    </div>
                    <div class="form-group row">
                        {!! Form::label('amount', __('static.plan.amount') . ' <span>*</span>', ['class' => 'col-xl-3 col-md-4'], false) !!}
                        <div class="col-xl-9 col-md-8">
                            {!! Form::text('amount',isset($plan->amount)? $plan->amount : old('amount'), ['class' => 'form-control']) !!}
                            @error('amount')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12 text-end">
                        {!! Form::submit(__('static.save'), ['class' => 'btn btn-primary']) !!}
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
