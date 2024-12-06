@extends('layouts.app')
@section('title')
    {{ __('messages.front_cms') }}
@endsection
@section('content')
    <div class="container-fluid">
        @include('flash::message')
        @include('layouts.errors')
        <div class="d-flex flex-column">
            <div class="card">
                {{ Form::hidden('terms_condition_data',$cmsData['terms_conditions'],['id' => 'termConditionData']) }}
                {{ Form::hidden('privacy_policy_data',$cmsData['privacy_policy'],['id' => 'privacyPolicyData']) }}
                <div class="card-body">
                    {{ Form::open(['route' => 'front.cms.update', 'id' => 'addCMSForm','files' => true]) }}
                        @include('fronts.cms.fields')
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@endsection
