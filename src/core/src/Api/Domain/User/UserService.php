<?php

namespace App\Api\Domain\User;

use App\Api\Domain\User\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use League\Fractal\Pagination\PagerfantaPaginatorAdapter;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

class UserService
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var UserTransformer
     */
    private $userTransformer;

    /**
     * UserService constructor.
     *
     * @param EntityManagerInterface $entityManager
     * @param UserTransformer        $userTransformer
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        UserTransformer $userTransformer
    ) {
        $this->entityManager = $entityManager;
        $this->userTransformer = $userTransformer;
    }

    /**
     * @param Request         $request
     * @param RouterInterface $router
     *
     * @return Collection
     */
    public function listUsers(Request $request, RouterInterface $router): Collection
    {
        $page = null !== $request->get('page') ? (int)$request->get('page') : 1;
        $perPage = null !== $request->get('per_page') ? (int)$request->get('per_page') : 10;

        $users = $this->entityManager->getRepository(User::class);

        $doctrineAdapter = new DoctrineORMAdapter($users->getUsers());
        $paginator = new Pagerfanta($doctrineAdapter);
        $paginator->setCurrentPage($page);
        $paginator->setMaxPerPage($perPage);

        $filteredResults = $paginator->getCurrentPageResults();

        $paginatorAdapter = new PagerfantaPaginatorAdapter(
            $paginator,
            function (int $page) use ($request, $router) {
                $route = $request->attributes->get('_route');
                $inputParams = $request->attributes->get('_route_params');
                $newParams = array_merge($inputParams, $request->query->all());
                $newParams['page'] = $page;

                return $router->generate($route, $newParams, 0);
            }
        );

        $resource = new Collection($filteredResults, $this->userTransformer, 'user');
        $resource->setPaginator($paginatorAdapter);

        return $resource;
    }

    /**
     * @param $id
     *
     * @return Item
     * @throws EntityNotFoundException
     */
    public function getUserById($id): Item
    {
        $user = $this->entityManager->getRepository(User::class)->find($id);

        if (!$user) {
            throw new EntityNotFoundException('user not found');
        }

        return new Item($user, $this->userTransformer, 'user');
    }
}
