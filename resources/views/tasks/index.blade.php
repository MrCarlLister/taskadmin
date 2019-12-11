@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between"><h3>Tasks</h3><a href="{{route('tasks.create')}}" class="btn btn-primary">Create task</a></div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <table class="table">
                    <thead>
                        <tr>
                            <th>Description</th>
                            <th>Last run</th>
                            <th>Average Runtime</th>
                            <th>Next run</th>
                            <th>On/Off</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tasks as $task)
                    <tr class="table-{{$task->is_active ? '' : 'secondary'}}">
                            <td>{{$task->description}} | <a href="{{ route('tasks.edit',$task->id)}}">Edit</a></td>
                            <td>{{$task->last_run}}</td>
                            <td>{{$task->average_runtime}}</td>
                            <td>{{$task->next_run}}</td>
                            <td>
                                <form action="{{ route('tasks.toggle',$task->id)}}" id="toggle-form-{{ $task->id}}" method="post">
                                    {{csrf_field()}}
                                    {{ method_field('PUT')}}
                                    <input type="checkbox" {{$task->is_active ? 'checked' : '' }} onchange="getElementById('toggle-form-{{$task->id}}').submit();" data-toggle="toggle" data-offstyle="secondary">
                                </form>
                            </td>
                            <td>
                                <form action="{{ route('tasks.destroy',$task->id)}}" method="post" id="delete-form-{{$task->id}}">
                                    {{csrf_field()}}
                                    {{ method_field('DELETE')}}

                                    <button type="button" class="btn-sm btn-danger" onclick="if(confirm('Are you sure?')) getElementById('delete-form-{{$task->id}}').submit();">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    </table>
                    <a href="{{route('tasks.create')}}" class="btn btn-primary btn-sm">Create task</a>


                </div>
            </div>
        </div>
    </div>
</div>
@endsection
