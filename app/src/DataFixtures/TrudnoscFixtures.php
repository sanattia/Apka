<?php
/**
 * Trudnosc fixture.
 */

namespace App\DataFixtures;

use App\Entity\Trudnosc;
use Doctrine\Persistence\ObjectManager;

/**
 * Class TrudnoscFixtures.
 */
class TrudnoscFixtures extends AbstractBaseFixtures
{
    /**
     * Load data.
     *
     * @param \Doctrine\Persistence\ObjectManager $manager Object manager
     */
    public function loadData(ObjectManager $manager): void
    {
        $this->createMany(10, 'trudnosci', function ($i) {
            $trudnosc = new Trudnosc();
            $trudnosc->setName($this->faker->word);

            return $trudnosc;
        });

        $manager->flush();
    }
}

