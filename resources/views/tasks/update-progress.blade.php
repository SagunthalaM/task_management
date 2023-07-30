<!-- resources/views/tasks/update-progress.blade.php -->

@extends('layouts.app')

@section('content')
    <h2>Update Progress for Task: {{ $task->task }}</h2>

    <form action="{{ route('tasks.update-progress', $task->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="progress">Progress:</label>
            <input type="number" name="progress" id="progress" min="0" max="100" value="{{ $task->progress }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Update Progress</button>
    </form>
@endsection
