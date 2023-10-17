<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    private $faker;
    public function __construct()
    {
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager): void
    {
        $this->loadArticle($manager);
    }

    private function loadArticle(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 20; $i++) {
            $article = new Article();
            $article->setTitle("Заголовок статьи $i");
            $article->setPreview("Превью статьи $i");
            $article->setText($this->faker->text(250));
            $article->setViews(0);
            $article->setCreatedAt($this->faker->dateTime());

            $manager->persist($article);
        }
        $manager->flush();
    }
}
