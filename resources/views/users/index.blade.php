@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        {{-- <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div> --}}
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    <form class="form-horizontal" method="get" action="{{route('users')}}">
                    <div class="form-group">
                        <div class="row">

                            <div class="col-md-2">
                                <div class="form-group">
                                    <input type="date" class="form-control" placeholder="Y-md-d"
                                    name="start_date" value="{{request('start_date')}}">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <input type="date" class="form-control" placeholder="Y-md-d" name="end_date"
                                            value="{{request('end_date')}}">
                                </div>
                            </div>
                            <div class="col-md-8">
                                <button type="submit" class="btn btn-success">
                                    Filter
                                </button>
                            </div>
                        </div>
                    </div>
                    </form>
                    <br>

                    {{$dataTable->table(['class' => 'table table-sm table-striped table-bordered',
                    'style'=>'width:100%'], true)}}



                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('styles')

@endsection
@push('scripts')
{{$dataTable->scripts()}}

@endpush
