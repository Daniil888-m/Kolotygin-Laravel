<?php

namespace App\Notifications;

use App\Models\Article;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewArticleNotification extends Notification
{
    use Queueable;

    public function __construct(public Article $article)
    {
    }

    public function via($notifiable): array
    {
        return ['database'];
    }

    // ВАЖНО: в лабе просят toDatabase (а не toArray)
    public function toDatabase($notifiable): array
    {
        return [
            'article_id' => $this->article->id,
            'title'      => $this->article->title,
            'author_id'  => $this->article->users_id,
        ];
    }
}
