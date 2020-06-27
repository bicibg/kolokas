<?php

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
            'Atıştırmalık',
            'Balık',
            'Börek',
            'Çorba',
            'Diyet',
            'Diyet Tatlı',
            'Ekmek/Çörek',
            'Et',
            'Glutensiz',
            'Hamur İşi',
            'İçecek',
            'Kahvaltılık',
            'Kek',
            'Kızartma',
            'Kurabiye',
            'Makarna',
            'Mama',
            'Mangal/Kebap',
            'Meyveli Tatlı',
            'Meze',
            'Pasta',
            'Pide',
            'Pilav',
            'Pizza',
            'Reçel',
            'Salata',
            'Sos',
            'Sulu Yemek',
            'Tatlı',
            'Tavuk',
            'Vegan',
            'Vejetaryen',
        ];

        foreach ($categories as $cat) {
            \App\Category::create([
                'name' => $cat
            ]);
        }
    }
}
