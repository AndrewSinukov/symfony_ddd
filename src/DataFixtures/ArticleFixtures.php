<?php

namespace App\DataFixtures;

use App\Api\Domain\Article\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use \Faker\Factory;

/**
 * Base class designed for data fixtures so they don't have to extend and
 * implement different classes/interfaces according to their needs.
 *
 */
class ArticleFixtures extends Fixture implements OrderedFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        for ($i = 0; $i <= 50; $i++) {
            $article = new Article();

            $article->setContributors(
                new ArrayCollection([$this->getReference(UserFixtures::TEST_USER)])
            );

            $article->setAuthor($this->getReference(UserFixtures::TEST_USER));
            $article->setBody($faker->paragraph);
            $article->setTitle($faker->sentence);

            $manager->persist($article);
            $manager->flush();
        }
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder(): int
    {
        return 2;
    }
}
