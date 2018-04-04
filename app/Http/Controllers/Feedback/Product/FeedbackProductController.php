<?php

namespace App\Http\Controllers\Feedback\Product;

use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FeedbackProductController extends Controller
{
    public function index() {
        return view('feedback.product.feedback_product_index');
    }

    public function show($systemId) {
        $product = Product::findOrFail($systemId);
        return view('feedback.product.feedback_product_show', compact('product'));
    }
}
