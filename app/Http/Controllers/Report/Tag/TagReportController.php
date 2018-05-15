<?php

namespace App\Http\Controllers\Report\Tag;

use App\FeedbackProduct;
use App\FeedbackService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TagReportController extends Controller
{
    public function showTopTagRatingYearly() {
        return view('report.tag.rating.top_tag_rating_yearly');
    }

    /* API Section */
    public function getTopTagRatingYearly($tenant_id, $year) {
        $feedbackProducts = FeedbackProduct::where('tenantId', $tenant_id)->whereYear('created_at', '=', $year)->get();
        $feedbackServices = FeedbackService::where('tenantId', $tenant_id)->whereYear('created_at', '=', $year)->get();
    }
}
