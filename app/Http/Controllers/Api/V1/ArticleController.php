<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\StoreMultipleArticlesRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use Illuminate\Http\JSONResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            $article = new ArticleResource($article);
            return response()->json($article);
        }
        return response()->json()->setStatusCode(404);
    }

    /**
     * Store a number of newly created resources in storage.
     *
     * @param StoreMultipleArticlesRequest $request
     * @return JSONResponse
     */
    public function storeConcurrent(StoreMultipleArticlesRequest $request): JSONResponse
    {
        $articles = collect();
        DB::transaction(function () use ($request, $articles) {
            foreach ($request->all() as $item) {
                $article = Article::create([
                    "name" => $item["name"],
                    "description" => $item["description"],
                    "category" => $item["category"],
                    "price" => $item["price"],
                    "currency" => $item["currency"] ?? null,
                ]);
                $articles->push($article);
            }
        });

        $articles = ArticleResource::collection($articles);
        return response()->json($articles);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateArticleRequest $request
     * @param int $article_id
     * @return JSONResponse
     */
    public function update(UpdateArticleRequest $request, int $article_id): JSONResponse
    {
        $article = Article::find($article_id);

        if ($article) {
            $article->name = $request->input("name");
            $article->description = $request->input("description");
            $article->category = $request->input("category");
            $article->price = $request->input("price");
            $article->currency = $request->input("currency");
            if (!$this->checkForUpdateConflict($article)) {
                $article->save();
                $article = new ArticleResource($article);
                return response()->json($article);
            }
            return response()->json()->setStatusCode(409);
        }
        return response()->json()->setStatusCode(404);
    }

    /**
     * Check if the loaded record hasn't been updated by another user.
     *
     * @param Article $article
     * @return bool true if conflict exists
     */
    public function checkForUpdateConflict(Article $article): bool
    {
        if (Article::find($article->article_id)->updated_at == $article->updated_at) {
            return false;
        }
        return true; // conflict found
    }
}
