<?php

namespace App\Api\Http\Controller;

use App\Api\Domain\Article\ArticleService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Swagger\Annotations as SWG;

class SearchController
{
    /**
     * @var ArticleService
     */
    private $articleService;

    /**
     * SearchController constructor.
     *
     * @param ArticleService $articleService
     */
    public function __construct(ArticleService $articleService)
    {
        $this->articleService = $articleService;
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     * @SWG\Response(
     *     response=200,
     *     description="Returns the article collection"
     * )
     * @SWG\Parameter(
     *     name="query",
     *     in="query",
     *     type="string",
     *     description="search query"
     * )
     * @SWG\Tag(name="search")
     */
    public function index(Request $request): JsonResponse
    {
        $resource = $this->articleService->searchArticle($request);

        return new JsonResponse($resource);
    }
}
