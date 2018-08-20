@extends('adminlte::page')

@section('title', 'Winspector | ' . $title )

@section('content_header')
    <h1>Tasks</h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Tasks</li>
    </ol>
@stop

@section('content')
    <div class="box">
        <div class="box-body">
            <table id="upcomingTasks" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <!-- <th class="text-center"><input type="checkbox" class="minimal"></th> -->
                        <th class="text-center">No.</th>
                        <th class="text-center">Task Number</th>
                        <th class="text-center">Owner Email</th>
                        <th class="text-center">Inspector Email</th>
                        <th class="text-center">Task Item</th>
                        <th class="text-center">Location</th>
                        <th class="text-center">Shop</th>
                        <th class="text-center">Expire Date</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($tasks as $key => $task)
                    <tr>
                        <!-- <td class="text-center"><input type="checkbox" class="minimal" data-id="{{ $task->id }}"></td> -->
                        <td class="text-center">{{ $key + 1 }}</td>
                        <td class="text-center">#{{ $task->number }}</td>
                        <td class="text-center">{{ $task->owner->email }}</td>
                        <td class="text-center">{{ $task->inspector->email }}</td>
                        <td class="text-center">{{ $task->item }}</td>
                        <td class="text-center">{{ $task->location }}</td>
                        <td class="text-center">{{ $task->shop }}</td>
                        <td class="text-center h4">
                            <span class="label label-danger">
                            @if( $task->due_date == date('Y-m-d'))
                                Today
                            @else
                                @php
                                    echo date('j M', strtotime($task->due_date));
                                @endphp
                            @endif
                            </span>
                        </td>
                        <td class="text-center h4">
                            @switch($task->status)
                                @case(0)
                                    <span class="label label-primary">Available</span>
                                    @break

                                @case(1)
                                    <span class="label label-success">Taken</span>
                                    @break

                                @case(2)
                                    <span class="label label-warning">Check</span>
                                    @break

                                @case(3)
                                    <span class="label label-default">Finish</span>
                                    @break

                                @default
                                    <span>Something went wrong, please try again</span>
                            @endswitch
                        </td>
                        <td class="text-center text-red h4">
                            <i class="fa fa-trash pointer delete-task" data-id="{{ $task->id }}"></i>
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
    <link rel="stylesheet" type="text/css" href="{{ asset('css/tasks.css') }}">
@endpush

@push('js')
    <!-- Common JS -->
    <script src="{{ asset('js/common.js') }}"></script>
    <!-- Custom JS -->
    <script src="{{ asset('js/tasks.js') }}"></script>
@endpush