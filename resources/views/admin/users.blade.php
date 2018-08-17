@extends('adminlte::page')

@section('title', 'Winspector | ' . $title )

@section('content_header')
    <h1>Users</h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Users</li>
    </ol>
@stop

@section('content')
    <div class="box">
        <div class="box-body">
            <table id="upcomingTasks" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th class="text-center"><input type="checkbox" class="minimal"></th>
                        <th class="text-center">Name</th>
                        <th class="text-center">Email</th>
                        <th class="text-center">Phone No.</th>
                        <th class="text-center">Address</th>
                        <th class="text-center">PromtPay ID</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td class="text-center"><input type="checkbox" class="minimal" data-id="{{ $user->id }}"></td>
                        <td class="text-center">{{ $user->name }}</td>
                        <td class="text-center">{{ $user->email }}</td>
                        <td class="text-center">{{ $user->phone }}</td>
                        <td class="text-center">{{ $user->address }}</td>
                        <td class="text-center">{{ $user->promtpay_id }}</td>
                        <td class="text-center h4">
                            <span class="label label-danger">
                            @if( $user->verified )
                                Verified
                            @else
                                Not verified
                            @endif
                            </span>
                        </td>
                        <td class="text-center text-red h4">
                            <i class="fa fa-trash pointer delete-task" data-id="{{ $user->id }}"></i>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <button class="btn btn-primary" id="removeTasks">Remove</button>
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->
@stop

@push('css')
    <!-- iCheck -->
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/adminlte/plugins/iCheck/all.css') }}">
    <!-- custom styles -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/common.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/users.css') }}">
@endpush

@push('js')
    <!-- Common JS -->
    <script src="{{ asset('js/common.js') }}"></script>
    <!-- Custom JS -->
    <script src="{{ asset('js/users.js') }}"></script>
@endpush