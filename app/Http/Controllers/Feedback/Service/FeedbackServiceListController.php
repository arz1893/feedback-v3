<?php

namespace App\Http\Controllers\Feedback\Service;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FeedbackServiceListController extends Controller
{
    public function index() {
        return view('feedback.service.list.feedback_service_list_index');
    }


}
