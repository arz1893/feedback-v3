<?php

namespace App\Http\Controllers\FAQ;

use App\FaqProduct;
use App\Http\Requests\FAQ\FAQProductRequest;
use App\Http\Resources\FAQ\FAQProductCollection;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Webpatser\Uuid\Uuid;

class FAQProductController extends Controller
{
    public function index() {
        return view('faq.product.faq_product_index');
    }

    public function show($product_id) {
        $product = Product::findOrFail($product_id);
        return view('faq.product.faq_product_show', compact('product'));
    }

    /* API Section */
    public function getFaqProducts($product_id) {
        $faqProducts = FaqProduct::where('productId', $product_id)->get();
        return new FAQProductCollection($faqProducts);
    }

    public function addFaqProduct() {

    }
}
