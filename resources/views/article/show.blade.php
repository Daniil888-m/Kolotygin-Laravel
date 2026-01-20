@extends('layout')
@section('content')
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h1>{{ $article->title }}</h1>
                <p class="text-muted">
                    Опубликовано: {{ $article->date_public }} |
                    Автор: {{ $article->user->name ?? 'Неизвестен' }}
                </p>
            </div>
            <div class="card-body">
                <p>{{ $article->text }}</p>
            </div>
        </div>

        <!-- РАЗДЕЛ КОММЕНТАРИЕВ -->
        <div class="mt-5">
            @php
                $acceptedComments = $article->comments->where('accept', 1);
            @endphp

            <h3>Комментарии ({{ $acceptedComments->count() }})</h3>

            @if ($acceptedComments->isEmpty())
                <div class="alert alert-info">
                    Пока нет комментариев. Будьте первым!
                </div>
            @else
                @foreach ($acceptedComments as $comment)
                    <div class="card mb-3">
                        <div class="card-body">
                            <p class="mb-2">{{ $comment->text }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">
                                    Автор: {{ $comment->user->name ?? 'Аноним' }} |
                                    {{ $comment->created_at->format('d.m.Y H:i') }}
                                </small>

                                <!-- Кнопки только для автора -->
                                @auth
                                    @can('comment', $comment)
                                        <div>
                                            <a href="{{ route('comment.edit', $comment->id) }}"
                                                class="btn btn-sm btn-outline-warning">
                                                Редактировать
                                            </a>

                                            <form action="{{ route('comment.destroy', $comment->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                                    onclick="return confirm('Удалить?')">
                                                    Удалить
                                                </button>
                                            </form>
                                        </div>
                                    @endcan
                                @endauth
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        <!-- ФОРМА ДОБАВЛЕНИЯ КОММЕНТАРИЯ (для авторизованных) -->
        @auth
            <div class="mt-4">
                <h4>Добавить комментарий</h4>
                <form action="{{ route('comment.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="articles_id" value="{{ $article->id }}">

                    <div class="form-group">
                        <textarea name="text" class="form-control @error('text') is-invalid @enderror" rows="3"
                            placeholder="Ваш комментарий..." required></textarea>
                        @error('text')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary mt-2">Отправить</button>
                </form>
            </div>
        @else
            <div class="alert alert-warning mt-4">
                Чтобы оставить комментарий, <a href="{{ route('login') }}">войдите в систему</a>
            </div>
        @endauth

        <!-- КНОПКИ ДЕЙСТВИЙ -->
        <div class="mt-4">
            <a href="{{ route('article.index') }}" class="btn btn-secondary">Назад к статьям</a>

            @auth
                @can('moderator')
                    <a href="{{ route('article.edit', $article->id) }}" class="btn btn-warning">Редактировать</a>

                    <form action="{{ route('article.destroy', $article->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Удалить статью?')">
                            Удалить
                        </button>
                    </form>
                @endcan
            @endauth
        </div>
    </div>
@endsection
