<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Color;
use App\Models\Taille;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TestController extends Controller
{
    public function index(){
        $cats=[
            'Soutiens-gorges',
            'Slips',
            'Robes',
            'Culottes',
            'Collants',
            'Bain',
            'Accessoire'
        ];
        $tailles=['XS/S', 'S', 'S/M', 'S-M', 'M', 'M/L', 'M-L', 'L', 'L/XL', 'L-XL', 'XL', 'XXL', 'XXXL', 'XXXXL', '0 long', '3 Ans', '3X', '4', '4X', '5 Ans', '5XL', '22',
            '32 A', '34', '34K', '36', '36 D', '38', '38 A', '38 B', '38 D', '38/85D', '40', '40 D', '40/90D', '42', '42 D', '42/95D', '44', '44 D', '46 D', '46/105D',
            '70 A', '70B', '75A', '75B', '75C', '75D', '75E', '75H', '80B', '80C', '80D', '80E', '80F', '85B', '85C', '85D', '85E', '85F', '90B', '90C', '90D', '90E', '90F', '90I', '95A', '95B', '95C', '95D', '95E', '95F', '100A', '100B', '100C', '100D', '100I', '100K', '105C', '105D', '110C', 'Bonnet B', 'EU 36', 'EU 38', 'EU L', 'EU L/XL', 'EU XL', 'Noir', 'Non Défini', 'ONE SIZE FITS ALL', 'Taille Unique', 'UK 18-20', 'UK L/XL', 'Unique', 'US L/XL', 'US M/L', 'XL/2XL', 'XL/XXL', 'XXL/XXXL', 'XXXL/XXXXL'];
        $colors = [
            'white' => '#FFFFFF',
            'pink' => '#FFC0CB',
            'red' => '#FF0000',
            'black' => '#000000',
            'beige' => '#F5F5DC',
            'marron' => '#800000',
            'blue' => '#0000FF',
            'violet' => '#8A2BE2',
        ];
        foreach ($cats as $cat) {
            Categorie::query()->create(['name'=>$cat]);
        }
        foreach ($colors as $color =>$code) {
            Color::query()->create(['code'=>$code,'name'=>$color]);
        }
        foreach ($tailles as $taille) {
            Taille::query()->create(['name'=>$taille]);
        }
        User::query()->create([
            'name'=>'admin',
            'email'=>'admin@gmail.com',
            'password'=>Hash::make('password')

        ]);
    }
}
