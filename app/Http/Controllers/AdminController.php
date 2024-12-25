<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
     /**
     * Show the application welcome page with a list of products.
     *
     * @return \Illuminate\View\View
     */
        public function dashboard()
        {
        return view('admin.dashboard' );

        
        }
        public function products()
        {
        return app(ProductController::class)->index();
        }
        public function categories()
        {
        return app(CategoryController::class)->index();
        }
}
