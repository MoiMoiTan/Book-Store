<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    /**
     * Show the application welcome page with a list of products.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Lấy tất cả sản phẩm từ cơ sở dữ liệu
        $products = Product::with('category')->paginate(10);

        // Trả về view welcome.blade.php và truyền danh sách sản phẩm vào view
        return view('welcome', compact('products'));
    }
}
