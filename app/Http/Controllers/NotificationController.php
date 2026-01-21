<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function open(string $id)
    {
        $notification = auth()->user()->notifications()->findOrFail($id);

        // отметим прочитанным
        $notification->markAsRead();

        // достанем article_id и перекинем на статью
        $articleId = $notification->data['article_id'] ?? null;

        if (!$articleId) {
            return redirect()->back();
        }

        return redirect()->route('article.show', $articleId);
    }
}
