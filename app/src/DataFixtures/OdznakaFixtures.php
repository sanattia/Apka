<?php
/**
 * Odznaka fixtures.
 */

namespace App\DataFixtures;

use App\Entity\Odznaka;
use Doctrine\Persistence\ObjectManager;

/**
 * Class OdznakaFixtures.
 */
class OdznakaFixtures extends AbstractBaseFixtures
{
    /**
     * Load data.
     *
     * @param ObjectManager $manager Persistence object manager
     */
    public function loadData(ObjectManager $manager): void
    {
        $this->createMany(10, 'odznaki', function ($i) {
            $odznaka = new Odznaka();
            $odznaka->setTitle($this->faker->word);

            return $odznaka;
        });

        $manager->flush();
    }
}