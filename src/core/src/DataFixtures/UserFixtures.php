<?php

namespace App\DataFixtures;

use App\Api\Domain\User\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

/**
 * Base class designed for data fixtures so they don't have to extend and
 * implement different classes/interfaces according to their needs.
 *
 */
class UserFixtures extends Fixture implements OrderedFixtureInterface
{
    public const TEST_USER = 'test-user';

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        $user = new User();
        $user->setUsername($faker->userName);
        $user->setEmail('admin@example.com');
        $user->setPassword(sha1('root'));

        $manager->persist($user);
        $manager->flush();

        $this->addReference(self::TEST_USER, $user);
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder(): int
    {
        return 1;
    }
}
