<?php
/**
 * Region fixture.
 */

namespace App\DataFixtures;

use App\Entity\Region;
use Doctrine\Persistence\ObjectManager;

/**
 * Class RegionFixtures.
 */
class RegionFixtures extends AbstractBaseFixtures
{
    /**
     * Load data.
     *
     * @param \Doctrine\Persistence\ObjectManager $manager Object manager
     */
    public function loadData(ObjectManager $manager): void
    {
        $this->createMany(10, 'regiony', function ($i) {
            $region = new Region();
            $region->setName($this->faker->word);

            return $region;
        });

        $manager->flush();
    }
}

