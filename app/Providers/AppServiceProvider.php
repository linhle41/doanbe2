<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        //
        $typeList = DB::table('products')
        ->select('protypes.id','protypes.type_name', DB::raw('count(*) as count'))
        ->join('protypes', 'products.type_id', '=', 'protypes.id')
        ->groupBy('protypes.type_name')
        ->take(5)->get();
        $viewData = [
            'typeList' => $typeList,
        ];
        view()->share($viewData);
    }
}
