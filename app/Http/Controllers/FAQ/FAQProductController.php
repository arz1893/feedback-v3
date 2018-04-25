<?php

namespace App\Http\Controllers\FAQ;

use App\Http\Requests\FAQ\FAQProductRequest;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FAQProductController extends Controller
{
    public function index() {
        return view('faq.product.faq_product_index');
    }

    public function show($product_id) {
        $product = Product::findOrFail($product_id);
        return view('faq.product.faq_product_show', compact('product'));
    }

    public function store(FAQProductRequest $request) {

    }
}
