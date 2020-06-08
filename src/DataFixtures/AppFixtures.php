<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Produit;
use App\Entity\Categorie;
use App\Entity\Promotion;
use App\Entity\SousCategorie;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');
        // Créer 5 catégorie
        for($i=0; $i <= 5; $i++){
            $categorie = new Categorie();
            $titre = ['Forge','Travail du Cuir','Fauconnerie','Cuisine','Calligraphie','Archerie'];

            $categorie->setTitre($titre[$i]);
            $manager->persist($categorie);

        // créer entre 3 et 5 sous categorie pour chaque categorie
        for($j=1; $j <= mt_rand(3, 5); $j++){
            $sousCategorie = new SousCategorie();

            $sousCategorie->setTitre($faker->word())
                        ->setCategorie($categorie);
            $manager->persist($sousCategorie);
        
        // créer entre 6 et 10 produit pour chaque sous categorie
        for($k=1; $k <= mt_rand(6, 10); $k++){
            $produit = new Produit();

            $description = '<p>'. join($faker->paragraphs(2),'<p></p>').'</p>';
            $titre = $faker->word(1);
            $public = ['f','m','mixte'];
            $taille = ['S','M','L'];
            $indice = rand(0,2);

            $produit->setTitre($titre)
                    ->setCouleur($faker->sentence(1))
                    ->setPublic($public[$indice])
                    ->setDescription($description)
                    ->setphoto('5ede4521d52e3829267052.jpg')
                    ->setPrix($faker->randomNumber(2))
                    ->setStock($faker->randomDigit())
                    ->setTaille($taille[$indice])
                    ->setSousCategorie($sousCategorie);
                    $manager->persist($produit);

                    $promotion = new Promotion();
                    $indice = rand(15,100);
                    $promotion->setPrix($indice)
                            ->setProduit($produit);
                            $manager->persist($promotion);
                }
            }
        }  
        // créer entre 6 et 10 produit pour chaque sous categorie
        $manager->flush();
    }
}