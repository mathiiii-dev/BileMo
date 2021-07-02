<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $productsInfo = [
            [
                'name' => 'Samsung Galaxy S21 Ultra',
                'description' => "Le Samsung Galaxy S21 Ultra est le fleuron de la marque 2021 succède au S20 Ultra. Il est équipé du SoC maison Exynos 2100 gravé en 5 nm, d'un écran WQHD+ en 120 Hz adaptatif, d'une batterie de 5000 mAh compatible charge rapide et sans fil et de 4 capteurs photo : le principal à 108 mégapixels (de deuxième génération) capable de filmer jusqu'en 8K, un ultra grand-angle de 12 mégapixels et deux téléobjectifs de 10 mégapixels pour des zooms optiques x3 et x10.",
                'brand' => 'Samsung',
            ],
            [
                'name' => 'Oppo Find X3 Pro',
                'description' => 'L\'Oppo Find X3 Pro est la version la plus haut de gamme de la série Find X3 annoncée en mars 2021. Ce modèle est muni un écran AMOLED QHD+ et un taux de rafraîchissement de 120 Hz adaptatif. Il est équipé d\'un SoC Qualcomm Snapdragon 888 couplé à 12 Go de RAM et 256 Go de stockage. Il possède 4 capteurs photo à l\'arrière : le principal et l\'ultra grand-angle de 50 mégapixels chacun, un téléobjectif de 13 mégapixels (zoom optique x2 et hybride x5) et un objectif microscope de 3 mégapixels. Il a une batterie de 4500 mAh compatible charge rapide (65 W) et sans fil (30 W). Enfin, il est certifié IP68.',
                'brand' => 'Oppo',
            ],
            [
                'name' => 'Apple iPhone 12 Pro Max',
                'description' => 'L\'iPhone 12 Pro Max est le modèle grand-format haut de gamme de la 14e génération de smartphone d\'Apple annoncé le 13 octobre 2020. Il est équipé d\'un écran de 6,7 pouces OLED HDR 60 Hz, d\'un triple capteur photo avec ultra grand-angle et téléobjectif (x5 optique) et d\'un SoC Apple A14 Bionic compatible 5G (sub-6 GHz).',
                'brand' => 'Apple',
            ],
            [
                'name' => 'OnePlus 9 Pro',
                'description' => 'Le OnePlus 9 Pro est la version incurvée de la famille "OnePlus 9" : il est équipé sensiblement des mêmes caractéristiques que la version non incurvée : SoC Snapdragon 888, 12 Go de RAM, jusqu\'à 256 Go de stockage. Ses différences résident dans le capteur supplémentaire de 8 mégapixels, la compatibilité charge sans fil et la certification IP68.',
                'brand' => 'OnePlus',
            ],
            [
                'name' => 'Xiaomi Mi 11',
                'description' => 'Le Xiaomi Mi 11 est le smartphone principal de la gamme Mi 11 de Xiaomi annoncé en 2021. Il est équipé d\'un SoC Qualcomm Snapdragon 888 épaulé par 8 ou 12 Go de RAM et d\'un triple capteur photo de 108 + 13 + 5 mégapixels. Il dispose également d\'un écran AMOLED de 6,81 pouces cadencé à 120 hz.',
                'brand' => 'Xiaomi',
            ],
            [
                'name' => 'Google Pixel 5',
                'description' => 'Le Google Pixel 5 est un smartphone annoncé le 30 septembre 2020. Il s\'agit du premier smartphone de Google a être compatible 5G et à disposer d\'Android 11. Il est équipé d\'un SoC Snapdragon 765G épaulé par 8 Go de RAM, d\'un écran de 6 pouces OLED et d\'un double capteur photo arrière avec ultra grand-angle.',
                'brand' => 'Google',
            ],
            [
                'name' => 'Apple iPhone 12 mini',
                'description' => 'L\'iPhone 12 mini est le modèle le plus compact de la 14e génération de smartphone d\'Apple annoncé le 13 octobre 2020. Il est équipé d\'un écran de 5,4 pouces OLED HDR 60 Hz, d\'un double capteur photo avec ultra grand-angle et d\'un SoC Apple A14 Bionic compatible 5G (sub-6 GHz).',
                'brand' => 'Apple',
            ],
            [
                'name' => 'OnePlus Nord',
                'description' => 'Le OnePlus Nord est un smartphone de milieu de gamme annoncé en juillet 2020. Il tente d\'offrir un positionnement orienté autour du rapport qualité/prix comme les premiers produits de la marque. Il est équipé d\'un SoC Qualcomm Snapdragon 765 épaulé par 8 à 12 Go de RAM, un écran AMOLED de 6,44 pouces Full HD+ et 90 Hz et un quadruple capteur photo de 48+8+5+2 mégapixels.',
                'brand' => 'OnePlus',
            ],
            [
                'name' => 'Google Pixel 4a',
                'description' => 'Le Google Pixel 4a est un smartphone milieu de gamme équipé d\'un SoC Qualcomm Snapdragon 730G, épaulé par 6 Go de RAM et 128 Go de stockage, non extensible. Il bénéficie d\'un capteur photo principal de 12.2 mégapixels. Il possède une batterie de 3140 mAh rechargeable via son port USB C et d\'un port jack.',
                'brand' => 'Google',
            ],
            [
                'name' => 'Xiaomi Redmi Note 10 Pro',
                'description' => 'Le Xiaomi Redmi Note 10 Pro est un smartphone 4G de la famille « Redmi Note 10 » annoncé en mars 2021. Tourné autour de la photographie, il est équipé d\'un capteur principal de 108 mégapixels épaulé par 3 capteurs secondaires de 8+5+2 mégapixels. Il est équipé d\'un SoC Qualcomm Snapdragon 732G, d\'une batterie de 5020 mAh et d\'un écran Super AMOLED Full HD+ 120 Hz.',
                'brand' => 'Xiaomi',
            ],
            [
                'name' => 'Xiaomi Redmi Note 10',
                'description' => 'Le Xiaomi Redmi Note 10 est un smartphone 4G de la famille « Redmi Note 10 » annoncé en mars 2021. Premier prix de la gamme, il est équipé d\'un SoC Snapdragon 678 de Qualcomm et d\'un capteur photo principal de 48 mégapixels. Il est également équipé d\'une batterie de 5000 mAh et d\'un écran Super AMOLED.',
                'brand' => 'Xiaomi',
            ],
            [
                'name' => 'Realme 7i',
                'description' => 'Annoncé en novembre 2020, le Realme 7i existe en deux versions. En Chine, c\'est un smartphone milieu de gamme équipé d\'un SoC Qualcomm Snapdragon 662 couplé à 4 Go de RAM et 64 ou 128 Go de stockage, extensible via microSD, ainsi qu\'une batterie de 5000 mAh. En France, il est équipé d\'un SoC MediaTek Helio G85 avec une capacité de batterie de 6000 mah.',
                'brand' => 'Realme',
            ],
            [
                'name' => 'Xiaomi Poco M3',
                'description' => 'Le Xiaomi Poco M3 Est un smartphone annoncé le 24 novembre 2020. Il est équipé d\'un écran LCD de 6,53 pouces Full HD+, d\'un SoC Qualcomm Snapdragon 662, d\'une batterie de 6000 mAh et d\'un triple capteur photo arrière. Il est annoncé avec Android 10 et les services google.',
                'brand' => 'Xiaomi',
            ],
            [
                'name' => 'Samsung Galaxy A12',
                'description' => 'Le Samsung Galaxy A12 est un smartphone entrée de gamme équipé d\'un SoC Mediatek couplé à 3, 4 ou 6 Go de RAM et 32, 64 ou 128 Go de stockage, extensible via microSD. Il possède 4 capteurs photo à l\arrière : le principal à 48 mégapixels, un ultra grand-angle à 5 mégapixels, un objectif macro et un capteur de profondeur. Il a une batterie de 5000 mAh compatible charge rapide (15 W).',
                'brand' => 'Samsung',
            ],
            [
                'name' => 'Xiaomi Redmi 9T',
                'description' => 'Annoncé en 2021, le Redmi 9T est un modèle entrée de gamme de Xiaomi embarquant un SoC Qualcomm Snapdragon 662 couplé à 4 Go de RAM et 64 ou 128 Go de stockage, extensible via microSD. Il possède 4 capteurs photo au dos : le principal à 48 mégapixels, un ultra grand-angle à 8 mégapixels et un objectif macro ainsi qu\'un capteur de profondeur de 2 mégapixels. Il a une batterie de 6000 mAh compatible charge rapide (18 W).',
                'brand' => 'Xiaomi',
            ],
            [
                'name' => 'Huawei Mate 40 Pro',
                'description' => 'La Huawei Mate 40 Pro est un smartphone haut de gamme annoncé le 22 octobre 2020. Il est équipé d\'un écran OLED de 6,76 pouces, d\'un SoC Kirin 9000 épaulé et d\'un triple capteur photo polyvalent avec TOF à l\'arrière. Il fait tourner à son lancement Android 10 avec l\'interface EMUI sans les applications Google dont le Play Store.',
                'brand' => 'Huawei',
            ],
            [
                'name' => 'Vivo X60 Pro',
                'description' => 'Le Vivo X60 Pro est la variante haut de gamme de la gamme X60 de Vivo. Il se différencie de la version de base par un capteur supplémentaire de 8 mégapixels et un zoom périscopique de 5 mégapixels pouvant monter jusqu\'à un zoom numérique x60, une batterie légèrement plus petite (4200 mAh), son design (bords incurvés) et la technologie Gimball sur le capteur principal de 48 mégapixels (faisant office de stabilisateur optique). Il est compatible 5G.',
                'brand' => 'Vivo',
            ],
            [
                'name' => 'Realme GT',
                'description' => 'Le Realme GT est un smartphone annoncé le 15 juin 2021. Il est équipé d\'un SoC Qualcomm Snapdragon 888 épaulé par 8 ou 12 Go de RAM et 128/256 Go de stockage. Il est également équipé d\'un triple capteur photo et d\'une batterie de 4500 mAh.',
                'brand' => 'Realme',
            ],
            [
                'name' => 'OnePlus Nord CE',
                'description' => 'Le OnePlus Nord CE est un modèle 5G de la marque embarquant un processeur Qualcomm Snapdragon 750G couplé jusqu\'à 12 Go de RAM et 256 Go de stockage. Il bénéficie d\'un triple module photo à l\'arrière : le principal de 64 mégapixels, un ultra-grand angle de 8 mégapixels et un capteur de profondeur (2 mégapixels). Il a une batterie de 4500 mAh compatible charge rapide (30 W) qui lui permet de récupérer 70 % de son énergie en 30 minutes de charge.',
                'brand' => 'OnePlus',
            ],
            [
                'name' => 'Xiaomi Mi 10T',
                'description' => 'Le Xiaomi Mi 10T est un smartphone annoncé par Xiaomi le 30 septembre 2020. Il est équipé d\'un écran de 6,67 pouces LCD Full HD+ avec une fréquence de rafraichissement de 144 Hz, un SoC Qualcomm Snapdragon 865 compatible 5G épaulé par 8 Go de RAM et un triple capteur photo avec ultra grand-angle de 64+13+5 mégapixels.',
                'brand' => 'Xiaomi',
            ],
            [
                'name' => 'Apple iPhone SE 2020',
                'description' => 'L\'iPhone SE (2020) est un smartphone de milieu de gamme annoncé le 15 avril 2020. Il représente l\'entrée de gamme de la marque à la pomme sur l\'année 2020 à côté des iPhone 11. Considéré comme l\'héritier de l\'iPhone 8, il reprend le célèbre formfactor de la série avant l\'arrivée de FaceID avec un écran compact de 4,7 pouces avec des bordures importantes et un unique bouton central également utilisé pour Touch ID. Il est équipé d\'un SoC Apple A13 Bionic qui le rend aussi performant qu\'un iPhone 11 et d\'un simple capteur photo de 12 mégapixels à l\'arrière.',
                'brand' => 'Apple',
            ],
            [
                'name' => 'Samsung Galaxy A52 5G',
                'description' => 'Le Samsung Galaxy A52 5G est une des deux versions du Galaxy A52 annoncé en mars 2021. Il est équipé d\'un SoC Qualcomm Snapdragon 750G couplé à 6 ou 8 Go de RAM et 128 ou 256 Go de stockage, extensible via microSD. Il possède 4 capteurs photo à l\'arrière : le principal à 64 mégapixels, l\'ultra grand-angle de 12 mégapixels, le capteur de profondeur et l\'objectif macro de 5 mégapixels chacun. Il a une batterie de 4500 mAh et il est certifié IP67.',
                'brand' => 'Samsung',
            ],
            [
                'name' => 'Samsung Galaxy A72',
                'description' => 'Le Samsung Galaxy A72 est un modèle milieu de gamme de a marque abritant un SoC Qualcomm Snapdragon 720G couplé à 6 ou 8 Go de RAM et 128 ou 256 Go de stockage, extensible via microSD. A l\'arrière se trouvent 4 capteurs photo : le principal de 64 mégapixels, un ultra grand-angle de 12 mégapixels, un téléobjectif de 8 mégapixels avec un zoom optique x3 et un objectif macro de 5 mégapixels. Il a une batterie de 5000 mAh compatible charge rapide (jusqu\'à 25 W). Enfin il est certifié IP67.',
                'brand' => 'Samsung',
            ],
        ];
        $faker = new Factory();

        foreach ($productsInfo as $productInfo) {
            $product = new Product();
            $product->setProduct($productInfo['name'])
                ->setReference($faker::create()->isbn10)
                ->setColor($faker::create()->safeColorName)
                ->setBrand($productInfo['brand'])
                ->setPrice($faker::create()->randomFloat(2, 200, 1300))
                ->setStock($faker::create()->numberBetween(0, 9000))
                ->setDescription($productInfo['description'])
                ->setReleaseDate($faker::create()->dateTimeThisDecade);
            $manager->persist($product);
        }

        $manager->flush();
    }
}
