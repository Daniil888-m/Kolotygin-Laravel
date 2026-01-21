<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index()
    {
        // можно paginate, чтобы было как раньше
        $articles = Article::latest()->paginate(5);

        return response()->json($articles);
    }

    public function show(Article $article)
    {
        return response()->json($article);
    }

    public function store(Request $request)
{
    $data = $request->validate([
        'title' => ['required', 'string', 'max:255'],
        'text' => ['required', 'string'],
        'date_public' => ['nullable', 'date'],
    ]);

    $data['users_id'] = $request->user()->id;

    // 👇 ВАЖНО
    if (!isset($data['date_public'])) {
        $data['date_public'] = now();
    }

    $article = Article::create($data);

    return response()->json([
        'message' => 'Created',
        'article' => $article,
    ], 201);
}


    public function update(Request $request, Article $article)
    {
        $data = $request->validate([
            'title' => ['sometimes', 'required', 'string', 'max:255'],
            'text' => ['sometimes', 'required', 'string'],
            'date_public' => ['nullable', 'date'],
        ]);

        $article->update($data);

        return response()->json([
            'message' => 'Updated',
            'article' => $article,
        ]);
    }

    public function destroy(Article $article)
    {
        $article->delete();

        return response()->json([
            'message' => 'Deleted',
        ]);
    }
}
