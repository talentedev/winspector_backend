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
            <table id="users_table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <!-- <th class="text-center"><input type="checkbox" class="minimal"></th> -->
                        <th class="text-center">No.</th>
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
                @foreach ($users as $key => $user)
                    <tr>
                        <!-- <td class="text-center"><input type="checkbox" class="minimal" data-id="{{ $user->id }}"></td> -->
                        <td class="text-center">{{ $key + 1 }}</td>
                        <td class="text-center">{{ $user->name }}</td>
                        <td class="text-center">{{ $user->email }}</td>
                        <td class="text-center">{{ $user->phone }}</td>
                        <td class="text-center">{{ $user->address }}</td>
                        <td class="text-center">{{ $user->promtpay_id }}</td>
                        <td class="text-center h4">
                            <span class="label {{ $user->verified == 0 ? 'label-danger' : 'label-success' }}">
                            @if( $user->verified )
                                Verified
                            @else
                                Not verified
                            @endif
                            </span>
                        </td>
                        <td class="text-center h4">
                            <i class="fa fa-edit pointer text-orange edit-user" data-user="{{ $user }}"></i>
                            <i class="fa fa-trash pointer text-red delete-user" data-id="{{ $user->id }}"></i>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <!-- <button class="btn btn-primary" id="removeTasks">Remove</button> -->
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->

    <!-- Add/Edit User Modal -->
    <div class="modal fade" id="user_modal" tabindex="-1" role="dialog" aria-labelledby="userModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="userModalLabel">Edit user</h4>
                </div>
                <div class="modal-body">
                    <form id="user_form" data-toggle="validator" role="form">
                        <input type="hidden" id="user_id">
                        <div class="form-group">
                            <label for="user_name">User Name</label>
                            <input type="text" class="form-control" id="user_name" required>
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group">
                            <label for="user_email">Email</label>
                            <input type="email" class="form-control" id="user_email" required>
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group">
                            <label for="phone_number">Phone number</label>
                            <input type="number" class="form-control" id="phone_number">
                        </div>
                        <div class="form-group">
                            <label for="address">Adress</label>
                            <input type="text" class="form-control" id="address">
                        </div>
                        <div class="form-group">
                            <label for="promtpay_id">PromtPay ID</label>
                            <input type="text" class="form-control" id="promtpay_id" required>
                            <div class="help-block with-errors"></div>
                        </div>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="btn_save_user">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirm Modal -->
    <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="delete_confirm_modal">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Are you sure to delete the customer?</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="btn_delete_user">Yes</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                </div>
            </div>
        </div>
    </div>
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