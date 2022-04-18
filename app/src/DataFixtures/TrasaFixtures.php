<?php
/**
 * Trasa fixtures.
 */

namespace App\DataFixtures;

use App\Entity\Trasa;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

/**
 * Class TrasaFixtures.
 */
class TrasaFixtures extends AbstractBaseFixtures implements DependentFixtureInterface
{
    /**
     * Load data.
     *
     * @param ObjectManager $manager Persistence object manager
     */
    public function loadData(ObjectManager $manager): void
    {
        $this->createMany(50, 'trasy', function ($i) {
            $trasa = new Trasa();
            $trasa->setName($this->faker->word);
            $trasa->setPunktKoncowy($this->faker->word);
            $trasa->setPunktStartowy($this->faker->word);
            $trasa->setTrudnosc($this->getRandomReference('trudnosci'));
            $trasa->setRegion($this->getRandomReference('regiony'));
            $trasa->setPoints($this->faker->randomDigit);
            $trasa->setCzas($this->faker->dateTime);
            $trasa->setCreatedAt($this->faker->dateTimeBetween('-100 days', '-1 days'));
            $trasa->setUpdatedAt($this->faker->dateTimeBetween('-100 days', '-1 days'));
            $tags = $this->getRandomReferences(
                'tags',
                $this->faker->numberBetween(0, 5)
            );

            foreach ($tags as $tag) {
                $trasa->addTag($tag);
            }

            return $trasa;
        });

        $manager->flush();
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on.
     *
     * @return array<class-string<FixtureInterface>>
     */
    public function getDependencies(): array
    {
        return [RegionFixtures::class, TrudnoscFixtures::class, TagFixtures::class];
    }
}
