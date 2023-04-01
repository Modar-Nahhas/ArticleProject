<?php

namespace App\Http\Controllers;

use App\Enum\PermissionsEnum;
use App\Enum\RolesEnum;
use App\Http\Requests\ArticleRequest;
use App\Models\Article;
use Illuminate\Http\JsonResponse;

class ArticleController extends Controller
{
    public function __construct()
    {
        $middleware = 'role_or_permission:' . RolesEnum::Admin->value . ',';
        $this->middleware($middleware . PermissionsEnum::ViewArticle->value)->only('index');
        $this->middleware($middleware . PermissionsEnum::ViewArticle->value)->only('show');
        $this->middleware($middleware . PermissionsEnum::AddArticle->value)->only('store');
        $this->middleware($middleware . PermissionsEnum::EditArticle->value)->only('update');
        $this->middleware($middleware . PermissionsEnum::DeleteArticle->value)->only('destroy');
    }

    public function index(ArticleRequest $request): JsonResponse
    {
        $data = $request->validated();
        $articles = Article::query()->applyAllFilters($data);
        return self::getJsonResponse('Success', $articles);
    }

    public function show(ArticleRequest $request, $articleId): JsonResponse
    {
        //The policy rules are not detailed in the task so I limited it to the permission
        $this->authorize('view', Article::class);
        $data = $request->validated();
        $data['where_id'] = $articleId;
        /** @var Article $article */
        $article = Article::query()->loadRelations($data)->filter($data)->firstOrFail();
        return self::getJsonResponse('Success', $article);
    }

    public function store(ArticleRequest $request): JsonResponse
    {
        $this->authorize('create', Article::class);
        $data = $request->validated();
        $data['user_id'] = auth()->id();
        /** @var Article $newArticle */
        $newArticle = Article::query()->create($data);
        return self::getJsonResponse('Success', $newArticle);
    }

    public function update(ArticleRequest $request, $articleId): JsonResponse
    {
        $data = $request->validated($request);
        $data['where_id'] = $articleId;
        /** @var Article $article */
        $article = Article::query()->filter($data)->firstOrFail();
        $this->authorize('update', $article);
        $article->update($data);
        return self::getJsonResponse('Success', $article);

    }

    public function destroy($articleId): JsonResponse
    {
        /** @var Article $article */
        $article = Article::query()->findOrFail($articleId);
        $this->authorize('delete', $article);
        $article->delete();
        return self::getJsonResponse('Success');
    }
}
