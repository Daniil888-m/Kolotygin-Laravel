<?php

namespace App\Events;

use App\Models\Article;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ArticleCreated implements ShouldBroadcast
{
    use Dispatchable, SerializesModels;

    public Article $article;

    public function __construct(Article $article)
    {
        $this->article = $article;
    }

    // Канал вещания
    public function broadcastOn(): Channel
    {
        return new Channel('articles');
    }

    // Какие данные отправляем в браузер
    public function broadcastWith(): array
    {
        return [
            'id'    => $this->article->id,
            'title' => $this->article->title,
        ];
    }

    // Имя события (необязательно, но красиво)
    public function broadcastAs(): string
    {
        return 'article.created';
    }
}
