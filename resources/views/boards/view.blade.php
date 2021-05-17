@extends('layout.main')

@section('content')
<section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Board view</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{route('boards.all')}}">Boards</a></li>
                        <li class="breadcrumb-item active">Board</li>
                    </ol>
                </div>
            </div>
        </div>
</section>

<section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{$board->name}}</h3>
            </div>

            <div class="card-body">
                <select class="custom-select rounded-0" id="changeBoard">
                    @foreach($boards as $selectBoard)
                        <option @if ($selectBoard->id === $board->id) selected="selected" @endif value="{{$selectBoard->id}}">{{$selectBoard->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>

    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Tasks list</h3>
            </div>

            @if (session('success'))
                <div class="alert alert-success" role="alert">{{session('success')}}</div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger" role="alert">{{session('error')}}</div>
            @endif

            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Assignment</th>
                            <th>Status</th>
                            <th>Date of creation</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tasks as $task)
                            <tr>
                                <td>{{$task->id}}</td>
                                <td>{{$task->name}}</td>
                                <td>{{$task->description}}</td>
                                <td>{{$task->assignment}}</td>
                                <td>{{$task->status}}</td>
                                <td>{{now()->format('Y-m-d')}}</td>
                                <td>
                                    <div class="btn-group">
                                        <button class="btn btn-xs btn-primary"
                                                type="button"
                                                data-task="{{json_encode($task)}}"
                                                data-toggle="modal"
                                                data-target="#taskEditModal">
                                            <i class="fas fa-edit"></i></button>
                                        <button class="btn btn-xs btn-default"
                                                type="button"
                                                data-task="{{json_encode($task)}}"
                                                data-toggle="modal"
                                                data-target="#taskEditModalAjax">
                                            <i class="fas fa-edit"></i></button>
                                        <button class="btn btn-xs btn-danger"
                                                type="button"
                                                data-task="{{json_encode($task)}}"
                                                data-toggle="modal"
                                                data-target="#taskDeleteModal">
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
                    @if ($tasks->currentPage() > 1)
                        <li class="page-item"><a class="page-link" href="{{$tasks->previousPageUrl()}}">&laquo;</a></li>
                        <li class="page-item"><a class="page-link" href="{{$tasks->url(1)}}">1</a></li>
                    @endif

                    @if ($tasks->currentPage() > 3)
                        <li class="page-item"><span class="page-link page-active">...</span></li>
                    @endif
                    @if ($tasks->currentPage() >= 3)
                        <li class="page-item"><a class="page-link" href="{{$tasks->url($tasks->currentPage() - 1)}}">{{$tasks->currentPage() - 1}}</a></li>
                    @endif

                    <li class="page-item"><span class="page-link page-active">{{$tasks->currentPage()}}</span></li>

                    @if ($tasks->currentPage() <= $tasks->lastPage() - 2)
                        <li class="page-item"><a class="page-link" href="{{$tasks->url($tasks->currentPage() + 1)}}">{{$tasks->currentPage() + 1}}</a></li>
                    @endif

                    @if ($tasks->currentPage() < $tasks->lastPage() - 2)
                        <li class="page-item"><span class="page-link page-active">...</span></li>
                    @endif

                    @if ($tasks->currentPage() < $tasks->lastPage() )
                        <li class="page-item"><a class="page-link" href="{{$tasks->url($tasks->lastPage())}}">{{$tasks->lastPage()}}</a></li>
                        <li class="page-item"><a class="page-link" href="{{$tasks->nextPageUrl()}}">&raquo;</a></li>
                    @endif
                </ul>
            </div>
        </div>
    </section>

    <div class="modal fade" id="taskEditModal">
            <div class="modal-dialog">
                <form action="{{route('tasks.update')}}" method="POST">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Edit task</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="id" id="taskEditId" value="" />
                            <div class="container">
                                <div class="row">
                                    <div class="col py-2">
                                        <input id="taskEditName" class="form-control">
                                    </div>
                                    <div class="col py-2">
                                        <input id="taskEditDescription" class="form-control">
                                    </div>
                                    <div class="col py-2 ">
                                        <input id="taskEditAssignment" class="form-control">
                                    </div>
                                </div>  
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="taskEditButton">Save changes</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="modal fade" id="taskEditModalAjax">
            <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Edit task</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="alert alert-danger" id="taskEditAlert"></div>
                            <div class="container">
                                <div class="row">
                                    <div class="col py-2">
                                        <input id="taskEditNameAjax" class="form-control">
                                    </div>
                                    <div class="col py-2">
                                        <input id="taskEditDescriptionAjax" class="form-control">
                                    </div>
                                    <div class="col py-2 ">
                                        <input id="taskEditAssignmentAjax" class="form-control">
                                    </div>
                                </div>  
                            </div>
                            
                            <input type="hidden" id="taskEditIdAjax" />
                            <div class="form-group">
                                <b>Members select: to be implemented...</b>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="taskEditButtonAjax">Save changes</button>
                        </div>
                    </div>
            </div>
        </div>

        <div class="modal fade" id="taskDeleteModal">
            <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                
                <form action="{{ route('tasks.delete', $task->id) }}" method="post">
                        @csrf
                        <div class="modal-body text-center">
                            <div id="taskDeleteAlert"></div>
                            <input type="hidden" id="taskDeleteId" value="" />
                            <p>Are you sure you want to delete: <span id="taskDeleteName"></span>?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-danger" id="taskDeleteButton">Yes, Delete</button>
                        </div>
                </form>
            </div>
            </div>
        </div>




</section>
@endsection