@extends('master')
@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col text-left">
                @include('components.greetings')
            </div>
            <div class="col text-center">
                <h1 class="todo-title">To-Do List</h1>
            </div>
            <div class="col text-end">
                @include('components.auth_buttons')
            </div>
        </div>
        <hr>
        <div class="container">
            <div class="mx-5">
                <form action="{{ route('task.store') }}" method="POST">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="text" name="title" class="form-control" placeholder="Enter a new task">
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                    <div>
                        <p style="color: red">{{ $errors->first('title') }}</p>
                    </div>
                </form>

                <ul class="list-group">
                    @foreach ($tasks as $task)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>{{ $task->title }}</span>
                            <div>
                                <form action="{{ route('task.update', $task->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="completed" value="{{ $task->completed ? 0 : 1 }}">
                                    <button type="submit"
                                        class="btn btn-sm {{ $task->completed ? 'btn-success' : 'btn-outline-success' }}">
                                        {{ $task->completed ? 'Completed' : 'Mark as Complete' }}
                                    </button>
                                </form>
                                {{-- <form action="{{ route('task.delete', $task->id) }}" method="POST" class="d-inline"
                                    onclick="return confirm('Are you sure to Delete?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form> --}}
                                <form id="delete-form-{{ $task->id }}" action="{{ route('task.delete', $task->id) }}"
                                    method="POST" class="d-inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-danger delete-btn"
                                        data-task-id="{{ $task->id }}">
                                        Delete
                                    </button>

                                </form>

                            </div>
                        </li>
                    @endforeach
                </ul>

            </div>
        </div>
    </div>
@endsection
