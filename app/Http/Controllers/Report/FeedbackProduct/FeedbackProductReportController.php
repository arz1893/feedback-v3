<?php

namespace App\Http\Controllers\Report\FeedbackProduct;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FeedbackProductReportController extends Controller
{
    public function index() {
        return view('report.feedback_product.feedback_product_report_index');
    }
}
