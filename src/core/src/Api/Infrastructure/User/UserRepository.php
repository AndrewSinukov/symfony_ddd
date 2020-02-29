<?php

namespace App\Api\Infrastructure\User;

use App\Api\Domain\User\Contract\UserRepositoryInterface;
use App\Api\App\Support\AppEntityRepository;

class UserRepository extends AppEntityRepository implements UserRepositoryInterface
{
    public function userDetails()
    {
    }

    public function getUsers()
    {
        return $this->createQueryBuilder('u')->getQuery();
    }
}
