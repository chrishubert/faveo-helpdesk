@extends('themes.default1.admin.layout.admin')

@section('Manage')
    class="nav-link active"
@stop

@section('manage-menu-parent')
    class="nav-item menu-open"
@stop

@section('manage-menu-open')
    class="nav nav-treeview menu-open"
@stop

@section('sla')
    class="nav-link active"
@stop

@section('HeadInclude')
@stop
<!-- header -->
@section('PageHeader')
    <h1>{!! Lang::get('lang.sla_plan') !!}</h1>
@stop
<!-- /header -->
<!-- breadcrumbs -->
@section('breadcrumbs')
    <ol class="breadcrumb">
    </ol>
@stop
<!-- /breadcrumbs -->
<!-- content -->
@section('content')
    <!-- open a form -->
    {!! Form::open(['action' => 'Admin\helpdesk\SlaController@store', 'method' => 'post']) !!}
    @if(Session::has('errors'))
        <?php //dd($errors); ?>
        <div class="alert alert-danger alert-dismissable">
            <i class="fa fa-ban"></i>
            <b>Alert!</b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <br/>
            @if($errors->first('name'))
                <li class="error-message-padding">{!! $errors->first('name', ':message') !!}</li>
            @endif
            @if($errors->first('grace_period'))
                <li class="error-message-padding">{!! $errors->first('grace_period', ':message') !!}</li>
            @endif
            @if($errors->first('status'))
                <li class="error-message-padding">{!! $errors->first('status', ':message') !!}</li>
            @endif
            @if($errors->first('business_hours'))
                <li class="error-message-padding">{!! $errors->first('business_hours', ':message') !!}</li>
            @endif
        </div>
    @endif
    <div class="card card-light">
        <div class="card-header">
            <h3 class="card-title">{{Lang::get('lang.create')}}</h3>
        </div>
        <div class="card-body">
            <!-- <table class="table table-hover" style="overflow:hidden;"> -->
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                        {!! Form::label('name',Lang::get('lang.name')) !!} <span class="text-red"> *</span>
                        {!! Form::text('name',null,['class' => 'form-control']) !!}
                    </div>
                </div>
                <!-- Grace Period text form Required -->
                <div class="col-md-4">
                    <div class="form-group {{ $errors->has('grace_period') ? 'has-error' : '' }}">
                        {!! Form::label('grace_period',Lang::get('lang.grace_period')) !!}
                        {!! Form::select('grace_period',Config::get('faveo.sla.grace_periods'),null,['class' => 'form-control']) !!}
                    </div>
                </div>
                <!-- status radio: required: Active|Dissable -->
                <div class="col-md-4">
                    <div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
                        {!! Form::label('status',Lang::get('lang.status')) !!}&nbsp;<br/>
                        {!! Form::radio('status','1',true) !!} {{Lang::get('lang.active')}}&nbsp;&nbsp;
                        {!! Form::radio('status','0') !!} {{Lang::get('lang.inactive')}}
                    </div>
                </div>
            </div>
            <!-- Admin Note  : Textarea :  -->
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        {!! Form::label('admin_note',Lang::get('lang.admin_notes')) !!}
                        {!! Form::textarea('admin_note',null,['class' => 'form-control','size' => '30x5']) !!}
                    </div>
                </div>
            </div>

            <!-- Business Hours  : Textarea :  -->
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group {{ $errors->has('business_hours') ? 'has-error' : '' }}">
                        {!! Form::label('business_hours',Lang::get('lang.business_hours_field_title')) !!}
                        {!! Form::textarea('business_hours',null,['class' => 'plaintextarea form-control','size' => '30x5']) !!}
                    </div>
                </div>
            </div>

        </div>
        <div class="card-footer">
            {!! Form::submit(Lang::get('lang.submit'),['class'=>'btn btn-primary'])!!}
        </div>
    </div>
    <!-- close form -->
    {!! Form::close() !!}
@stop