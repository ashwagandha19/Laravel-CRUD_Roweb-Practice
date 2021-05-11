@extends('layout.main')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Blank Page</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Blank Page</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Bordered Table</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th class="user-name">Name</th>
                            <th>Email</th>
                            <th>Is Verified</th>
                            <th style="width: 100px">Role</th>
                            <th style="width: 40px">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="user-table-body">
                        @foreach ($users as $user)
                            <tr data-id="{{ $user->id }}">
                                <td>{{$user->id}}</td>
                                <td class="user-name">{{$user->name}}</td>
                                <td>{{$user->email}}</td>
                                <td>
                                    @if ($user->email_verified_at)
                                        <span class="badge bg-primary">Verified</span>
                                    @else
                                        <span class="badge bg-warning">Unverified</span>
                                    @endif
                                </td>
                                <td class="user-role">{{$user->role === \App\Models\User::ROLE_ADMIN ? 'Admin' : 'User'}}</td>
                                <td>
                                    <div class="btn-group">
                                        <button class="btn btn-xs btn-primary edit" type="button" data-user="{{json_encode($user)}}" data-toggle="modal" data-target="#edit-modal">
                                            <i class="fas fa-edit"></i></button>
                                        <button class="btn btn-xs btn-danger delete" type="button" data-user="{{json_encode($user)}}" data-toggle="modal" data-target="#delete-modal">
                                            <i class="fas fa-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- /.card-body -->
            <div class="card-footer clearfix">
                <ul class="pagination pagination-sm m-0 float-right">
                    @if ($users->currentPage() > 1)
                        <li class="page-item"><a class="page-link" href="{{$users->previousPageUrl()}}">&laquo;</a></li>
                        <li class="page-item"><a class="page-link" href="{{$users->url(1)}}">1</a></li>
                    @endif

                    @if ($users->currentPage() < $users->lastPage() )
                        <li class="page-item"><a class="page-link" href="{{$users->url($users->lastPage())}}">{{$users->lastPage()}}</a></li>
                        <li class="page-item"><a class="page-link" href="{{$users->nextPageUrl()}}">&raquo;</a></li>
                    @endif
                </ul>
            </div>
        </div>
        <!-- /.card -->

        <div class="modal fade" id="edit-modal">
            <div class="modal-dialog">
                    <div class="modal-content">
                    <form action="" method="POST" id ="edit-user-form">
                        <div class="modal-header">
                            <h4 class="modal-title">Edit user</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div id="edit-user-message"></div>
                            <input type="hidden" name="editId" value="" />
                            <div class="form-group">    
                                <label for="">Enter the new name</label>
                                <input type="text" name="name" id="editName" value="{{old('name', $user->name)}}" />
                            </div>
                            
                            <div class="form-group">
                                <label for="editRole">Role</label>
                                <select name="role" class="custom-select rounded-0" id="editRole">
                                    <option  value="{{\App\Models\User::ROLE_USER}}">User</option>
                                    <option  value="{{\App\Models\User::ROLE_ADMIN}}">Admin</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                        </form>
                    </div>
                    <!-- /.modal-content -->               
            </div>
            <!-- /.modal-dialog -->
        </div>
                
            

    <div class="modal fade" id="delete-modal">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
          <form id="delete-user-form">
            <div class="modal-header">
            <h5 class="modal-title">Delete User</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body text-center">
                <div id="delete-user-message"></div>
                <h4>Are you you want to delete this?</h4>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-danger">Yes, Delete</button>
            </div>
        </form>
      </div>
    </div>
  </div>

    </section>
    <!-- /.content -->
@endsection