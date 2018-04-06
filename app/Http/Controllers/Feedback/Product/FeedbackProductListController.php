<?php

namespace App\Http\Controllers\Feedback\Product;

use App\FeedbackProduct;
use App\Http\Resources\Feedback\FeedbackProductCollection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FeedbackProductListController extends Controller
{
    public function index() {
        return view('feedback.product.list.feedback_product_list_index');
    }
}
