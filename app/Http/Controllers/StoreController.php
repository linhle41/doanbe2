<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StoreController extends Controller
{
    //view store
    public function getProductStore(){
       
        return view('frontend.store');
    }
}
