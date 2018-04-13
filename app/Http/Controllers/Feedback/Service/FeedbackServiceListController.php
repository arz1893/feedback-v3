<?php

namespace App\Http\Controllers\Feedback\Service;

use App\FeedbackService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FeedbackServiceListController extends Controller
{
    public function index() {
        return view('feedback.service.list.feedback_service_list_index');
    }

    public function edit($feedback_service_id) {
        $feedbackService = FeedbackService::findOrFail($feedback_service_id);
        return view('feedback.service.list.feedback_service_list_edit', compact('feedbackService'));
    }
}
