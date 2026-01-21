<?php

namespace App\Http\Middleware;

use App\Models\ArticleView;
use Closure;
use Illuminate\Http\Request;

class LogArticleView
{
    public function handle(Request $request, Closure $next)
    {
        // берём параметр маршрута {article}
        $article = $request->route('article');

        // Если это реально модель Article (route model binding)
        if ($article && isset($article->id)) {
            ArticleView::create([
                'article_id' => $article->id,
                'url' => $request->fullUrl(),
            ]);
        }

        return $next($request);
    }
}
