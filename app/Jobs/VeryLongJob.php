<?php

namespace App\Jobs;

use App\Mail\NewArticleMail;
use App\Models\Article;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class VeryLongJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public Article $article)
    {
        // Article будет сериализован, а потом восстановлен из БД по id
    }

    public function handle(): void
    {
        // Кому отправлять — для лабы можно захардкодить, как у тебя в комментариях
        $to = 'daniil.kolotygin80@gmail.com';

        Mail::to($to)->send(new NewArticleMail($this->article));
    }
}
