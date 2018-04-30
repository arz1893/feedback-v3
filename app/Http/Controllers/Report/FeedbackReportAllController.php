<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FeedbackReportAllController extends Controller
{
    public function showTopFeedbackProductReportYearly() {
        return view('report.all.product.top_feedback_product_all_yearly');
    }

    public function showTopFeedbackProductReportMonthly() {
        return view('report.all.product.top_feedback_product_all_monthly');
    }

    public function showTopFeedbackServiceReportYearly() {
        return view('report.all.service.top_feedback_service_all_yearly');
    }

    public function showTopFeedbackServiceReportMonthly() {
        return view('report.all.service.top_feedback_service_all_monthly');
    }
}
