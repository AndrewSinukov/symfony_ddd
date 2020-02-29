<?php


namespace App\Api\Infrastructure\Article;

use App\Api\App\Support\AppEntityRepository;
use App\Api\Domain\Article\Entity\Article;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\Query;

class ArticleRepository extends AppEntityRepository
{
    /**
     * @return Query
     */
    public function getArticles(): Query
    {
        $qb = $this->createQueryBuilder('a');

        return $qb->getQuery();
    }

    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function searchArticle(Request $request)
    {
        $qb = $this->createQueryBuilder('a')
            ->where('a.title LIKE :query')
            ->orWhere('a.body LIKE :query')
            ->setParameter('query', "%{$request->get('query')}%");

        return $qb->getQuery()->getResult();
    }

    /**
     * @param Article $article
     */
    public function save(Article $article): void
    {
        $this->_em->persist($article);
        $this->_em->flush();
    }
}
