<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use Illuminate\Http\JSONResponse;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JSONResponse
     */
    public function index(Request $request): JSONResponse
    {
        $query = Article::select("name", "description", "category", "price", "currency");

        $name = $request->query("name");
        if (isset($name)) { $query->where("name", "like", "%".$name."%"); }

        $category = $request->query("category");
        if (isset($category)) { $query->where("category", "=", $category); }

        $articles = $query->get();

        $articles = ArticleResource::collection($articles);

        return response()->json($articles);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreArticleRequest $request
     * @return JSONResponse
     */
    public function store(StoreArticleRequest $request): JSONResponse
    {
        $article = Article::create([
            "name" => $request->input("name"),
            "description" => $request->input("description"),
            "category" => $request->input("category"),
            "price" => $request->input("price"),
            "currency" => $request->input("currency"),
        ]);

        $article = new ArticleResource($article);
        return response()->json($article);
    }

    /**
     * Display the specified resource.
     *
     * @param int $article_id
     * @return JSONResponse
     */
    public function show(int $article_id): JSONResponse
    {
        $article = Article::find($article_id);

        if ($article) {
            return response()->json($article);
        }
        return response()->json()->setStatusCode(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Article $article
     * @return JSONResponse
     */
    public function update(Request $request, int $article_id): JSONResponse
    {
        $article = Article::find($article_id);

        if ($article) {
            $article->name = $request->input("name");
            $article->description = $request->input("description");
            $article->category = $request->input("category");
            $article->price = $request->input("price");
            $article->currency = $request->input("currency");
            $article->save();
            return response()->json($article);
        }
        return response()->json()->setStatusCode(409);
    }
}
