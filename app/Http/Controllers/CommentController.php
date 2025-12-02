<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Сохранение нового комментария
     */
    public function store(Request $request)
    {
        // Валидация
        $request->validate([
            'text' => 'required|min:3|max:500',
            'articles_id' => 'required|exists:articles,id'
        ]);

        // Создаем комментарий
        Comment::create([
    'text' => $request->text,
    'articles_id' => $request->articles_id,
    'user_id' => Auth::id(), // Добавляем автора!
]);

        // Возвращаемся на страницу статьи с сообщением
        return redirect()
            ->route('article.show', $request->articles_id)
            ->with('message', 'Комментарий добавлен!');
    }

	public function edit(Comment $comment)
    {
        // Проверка прав: редактировать может только автор
        if ($comment->user_id != Auth::id()) {
            return redirect()->back()->with('error', 'Вы не можете редактировать чужой комментарий');
        }

        return view('comment.edit', ['comment' => $comment]);
    }

    /**
     * Обновление комментария
     */
    public function update(Request $request, Comment $comment)
    {
        // Проверка прав
        if ($comment->user_id != Auth::id()) {
            return redirect()->back()->with('error', 'Нет прав');
        }

        $request->validate([
            'text' => 'required|min:3|max:500'
        ]);

        $comment->update([
            'text' => $request->text
        ]);

        return redirect()
            ->route('article.show', $comment->articles_id) 
            ->with('message', 'Комментарий обновлен!');
    }

    /**
     * Удаление комментария
     */
    public function destroy(Comment $comment)
    {
        // Удалять может автор ИЛИ админ (если у вас есть роли) ИЛИ владелец статьи
        if ($comment->user_id != Auth::id()) {
            return redirect()->back()->with('error', 'Вы не можете удалить чужой комментарий');
        }

        $articleId = $comment->articles_id; // Сохраняем ID статьи перед удалением
        $comment->delete();

        return redirect()
            ->route('article.show', $articleId)
            ->with('message', 'Комментарий удален');
    }
}
