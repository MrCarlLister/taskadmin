@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit task</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form action="{{route('tasks.update', $task->id)}}" method="post">
                        {{ csrf_field() }}
                        {{method_field('PUT')}}
                        <div class="form-group">
                            <label>Description</label>
                            <input type="text" class="form-control" name="description" value="{{$task->description}}">
                        </div>

                        <div class="form-group">
                            <label>Command</label>
                            <input type="text" class="form-control" name="command" value="{{$task->command}}">
                        </div>

                        <div class="form-group">
                            <label>Cron Expression</label>
                            <input type="text" class="form-control" name="expression" value="{{ $task->expression ?: '* * * * *' }}">
                        </div>

                        <div class="form-group">
                            <label>Email address</label>
                            <input type="text" class="form-control" name="notification_email" value="{{$task->notification_email}}">
                        </div>

                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="dont_overlap" value="1" {{$task->dont_overlap ? 'checked' : ''}}>
                            <label class="form-check-label">Don't overlap</label>
                        </div>

                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="run_in_maintenance" value="1" {{$task->run_in_maintenance ? 'checked' : ''}}>
                            <label class="form-check-label">Run in maintenance</label>
                        </div>
                        <div class="row">
                            <div class="col-12 text-right">
                                <button type="submit" class="btn btn-primary">Update Task</button>
                                <a href="{{route('tasks.index')}}" class="class btn btn-danger">Cancel</a>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
