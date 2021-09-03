<?php
/**
 * Tag fixtures.
 */

namespace App\DataFixtures;

use App\Entity\Tag;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

/**
 * Class TagFixtures.
 */
class TagFixtures extends AbstractBaseFixtures
{
    /**
     * Load data.
     *
     * @param ObjectManager $manager Persistence object manager
     */
    public function loadData(ObjectManager $manager): void
    {
        $this->createMany(50, 'tags', function ($i) {
            $tag = new Tag();
            $tag->setTitle($this->faker->word);
            $tag->setCreatedAt($this->faker->dateTimeBetween('-100 days', '-1 days'));
            $tag->setUpdatedAt($this->faker->dateTimeBetween('-100 days', '-1 days'));


            return $tag;
        });

        $manager->flush();
    }
}