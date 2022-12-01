<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $query = Article::select("name", "description", "category", "price", "currency");

        $name = $request->query("name");
        if (isset($name)) {
            $query->where("name", "like", "%".$name."%");
        }

        $category = $request->query("category");
        if (isset($category)) {
            $query->where("category", "=", $category);
        }

        $articles = $query->get();

        return response()->json($articles, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JSONResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            "name" => ["required", "string", "max:64"],
            "description" => ["required", "string", "max:2048"],
            "category" => ["required", "string", "max:64"],
            "price" => ["required", "min:0.00"],
            "currency" => ["nullable"],
        ]);

        $article = Article::create([
            "name" => $request->input("name"),
            "description" => $request->input("description"),
            "category" => $request->input("category"),
            "price" => $request->input("price"),
            "currency" => $request->input("currency"),
        ]);

        if ($article) {
            return response()->json($article, 200);
        } else {
            return response()->json(['message' => 'Conflict'], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\JSONResponse
     */
    public function show(int $article_id)
    {
        $article = Article::find($article_id);

        if ($article) {
            return response()->json($article, 200);
        } else {
            return response()->json(['message' => 'Not Found'], 404);
        }
    }

    /**
     * Updates the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\JSONResponse
     */
    public function update(Request $request, int $article_id)
    {
        $article = Article::find($article_id);

        if ($article) {
            $article->name = $request->input("name");
            $article->description = $request->input("description");
            $article->category = $request->input("category");
            $article->price = $request->input("price");
            $article->currency = $request->input("currency");
            $article->save();
            return response()->json($article, 200);
        } else {
            return response()->json(['message' => 'Conflict'], 409);
        }
    }
}
