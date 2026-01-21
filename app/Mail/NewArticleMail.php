<?php

namespace App\Mail;

use App\Models\Article;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewArticleMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Article $article)
    {
    }

    public function build()
    {
        return $this->subject('Добавлена новая статья: ' . $this->article->title)
            ->view('emails.new-article');
    }
}
