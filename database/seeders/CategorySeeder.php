<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                "tr" => "Atıştırmalık",
                "en" => "Snack",
                "el" => "Πρόχειρο φαγητό"
            ],
            [
                "tr" => "Balık",
                "en" => "Fish",
                "el" => "Το ψάρι"
            ],
            [
                "tr" => "Börek",
                "en" => "Patty",
                "el" => "Μπουρί"
            ],
            [
                "tr" => "Çorba",
                "en" => "Soup",
                "el" => "Σούπα"
            ],
            [
                "tr" => "Diyet",
                "en" => "Diet",
                "el" => "Διατροφή"
            ],
            [
                "tr" => "Diyet Tatlı",
                "en" => "Diet Dessert",
                "el" => "επιδόρπιο γυμναστικής"
            ],
            [
                "tr" => "Ekmek/Çörek",
                "en" => "Bread/Buns",
                "el" => "Ψωμί/ψωμάκια"
            ],
            [
                "tr" => "Et",
                "en" => "Meat",
                "el" => "Κρέας"
            ],
            [
                "tr" => "Glutensiz",
                "en" => "Gluten-free",
                "el" => "Χωρίς γλουτένη"
            ],
            [
                "tr" => "Hamur İşi",
                "en" => "Pastry",
                "el" => "Ζύμη"
            ],
            [
                "tr" => "İçecek",
                "en" => "Beverage",
                "el" => "Ποτό"
            ],
            [
                "tr" => "Kahvaltılık",
                "en" => "For breakfast",
                "el" => "Για πρωινό"
            ],
            [
                "tr" => "Kek",
                "en" => "Cake",
                "el" => "Κέικ"
            ],
            [
                "tr" => "Kızartma",
                "en" => "Fried",
                "el" => "Τηγάνισμα"
            ],
            [
                "tr" => "Kurabiye",
                "en" => "Cookie",
                "el" => "Κουλουράκι"
            ],
            [
                "tr" => "Makarna",
                "en" => "Pasta",
                "el" => "Ζυμαρικά"
            ],
            [
                "tr" => "Mama",
                "en" => "Baby food",
                "el" => "Τύπος"
            ],
            [
                "tr" => "Mangal/Kebap",
                "en" => "Grill/Kebab",
                "el" => "Γκριλ / κεμπάπ"
            ],
            [
                "tr" => "Meze",
                "en" => "Appetizer",
                "el" => "Ορεκτικό"
            ],
            [
                "tr" => "Pasta",
                "en" => "Cake",
                "el" => "Κέικ"
            ],
            [
                "tr" => "Pide",
                "en" => "Pitta",
                "el" => "Πίττα"
            ],
            [
                "tr" => "Pilav",
                "en" => "Rice",
                "el" => "Ρύζι"
            ],
            [
                "tr" => "Pizza",
                "en" => "Pizza",
                "el" => "Πίτσα"
            ],
            [
                "tr" => "Reçel",
                "en" => "Jam",
                "el" => "Μαρμελάδα"
            ],
            [
                "tr" => "Salata",
                "en" => "Salad",
                "el" => "Σαλάτα"
            ],
            [
                "tr" => "Sos",
                "en" => "Sauce",
                "el" => "Σάλτσα"
            ],
            [
                "tr" => "Sulu Yemek",
                "en" => "Slops",
                "el" => "Φθηνά ρούχα"
            ],
            [
                "tr" => "Tatlı",
                "en" => "Dessert",
                "el" => "Επιδόρπιο"
            ],
            [
                "tr" => "Tavuk",
                "en" => "Chicken",
                "el" => "Κοτόπουλο"
            ],
            [
                "tr" => "Vegan",
                "en" => "Vegan",
                "el" => "βίγκαν"
            ],
            [
                "tr" => "Vejetaryen",
                "en" => "Vegetarian",
                "el" => "Χορτοφάγος"
            ]
        ];

        foreach ($categories as $cat) {
            Category::create([
                'name_en' => $cat['en'],
                'name_tr' => $cat['tr'],
                'name_el' => $cat['el'],
            ]);
        }
    }
}
