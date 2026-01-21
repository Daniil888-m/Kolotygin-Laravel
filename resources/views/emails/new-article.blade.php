<h2>Добавлена новая статья</h2>

<p><b>Заголовок:</b> {{ $article->title }}</p>
<p><b>Дата публикации:</b> {{ $article->date_public }}</p>

<p><b>Текст:</b></p>
<p>{{ $article->text }}</p>

<p>
    Ссылка (если есть роут show):
    <a href="{{ route('article.show', $article->id) }}">Открыть статью</a>
</p>
