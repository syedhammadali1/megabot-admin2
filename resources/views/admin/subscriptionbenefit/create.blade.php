@extends('admin.layouts.master')

@section('title', __('static.subscription_benefit.create_subscription_benefit'))

@section('content')
    <div class="row">
        <div class="col-sm-10 col-xxl-8 mx-auto">
            <div class="card tab2-card">
                <div class="card-header">
                    <h5>{{ __('static.subscription_benefit.create_subscription_benefit') }}</h5>
                </div>
                {!! Form::open([
                    'route' => 'subscriptionbenefit.store',
                    'method' => 'POST',
                    'class' => 'needs-validation user-add',
                ]) !!}
                <div class="card-body">
                    <div class="form-group row">
                        {!! Form::label('Advantage', __('static.subscription_benefit.advantage') . ' <span>*</span>', ['class' => 'col-xl-3 col-md-4'], false) !!}
                        <div class="col-xl-9 col-md-8">
                            {!! Form::text('advantage', old('advantage'), ['class' => 'form-control']) !!}
                            @error('advantage')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        {!! Form::label('free', __('static.subscription_benefit.free_status') . ' <span>*</span>', ['class' => 'col-xl-3 col-md-4 col-4'], false) !!}
                        <div class="col-xl-9 col-md-8 col-8">
                            <div class="form-check form-switch justify-content-md-start justify-content-end">
                                <input class="form-check-input" name="free" type="checkbox" value="1"
                                    id="free">
                                @error('free')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        {!! Form::label('pro', __('static.subscription_benefit.pro_status') . ' <span>*</span>', ['class' => 'col-xl-3 col-md-4 col-4'], false) !!}
                        <div class="col-xl-9 col-md-8 col-8">
                            <div class="form-check form-switch justify-content-md-start justify-content-end">
                                <input class="form-check-input" name="pro" type="checkbox" value="1"
                                    id="pro">
                                @error('pro')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <div class="col-sm-12 text-end">
                            {!! Form::submit(__('static.save'), ['class' => 'btn btn-primary']) !!}
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
