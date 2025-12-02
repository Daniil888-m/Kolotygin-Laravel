@extends('layout')

@section('content')
    <div class="container mt-5">
        <h3>Редактирование комментария</h3>

        <form action="{{ route('comment.update', $comment->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <textarea name="text" class="form-control" rows="3" required>{{ $comment->text }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary mt-2">Сохранить</button>
            <a href="{{ route('article.show', $comment->articles_id) }}" class="btn btn-secondary mt-2">Отмена</a>
        </form>
    </div>
@endsection
