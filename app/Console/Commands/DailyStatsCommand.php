<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ArticleView;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class DailyStatsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stats:daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): int
{
    // 1) Считаем просмотры статей за сегодня
    $viewsToday = ArticleView::whereDate('created_at', today())->count();

    // 2) Считаем комментарии за сегодня
    $commentsToday = Comment::whereDate('created_at', today())->count();

    // 3) Находим модераторов (у тебя в users есть поле role)
    $moderators = User::where('role', 'moderator')->get();

    // 4) Если модераторов нет — просто выходим (чтобы не падало)
    if ($moderators->isEmpty()) {
        $this->warn('No moderators found.');
        return self::SUCCESS;
    }

    // 5) Отправляем письмо каждому модератору
    foreach ($moderators as $moderator) {
        Mail::raw(
            "Статистика за " . now()->toDateString() . "\n" .
            "Просмотры статей: $viewsToday\n" .
            "Новые комментарии: $commentsToday\n",
            function ($message) use ($moderator) {
                $message->to($moderator->email)
                    ->subject('Статистика сайта за день');
            }
        );
    }

    $this->info("Sent stats: views=$viewsToday, comments=$commentsToday");
    return self::SUCCESS;
}
}
