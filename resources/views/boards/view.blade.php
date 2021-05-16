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
                                                data-board="{{json_encode($board)}}"
                                                data-toggle="modal"
                                                data-target="#boardEditModal">
                                            <i class="fas fa-edit"></i></button>
                                        <button class="btn btn-xs btn-default"
                                                type="button"
                                                data-board="{{json_encode($board)}}"
                                                data-toggle="modal"
                                                data-target="#boardEditModalAjax">
                                            <i class="fas fa-edit"></i></button>
                                        <button class="btn btn-xs btn-danger"
                                                type="button"
                                                data-board="{{json_encode($board)}}"
                                                data-toggle="modal"
                                                data-target="#boardDeleteModal">
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
</section>
@endsection