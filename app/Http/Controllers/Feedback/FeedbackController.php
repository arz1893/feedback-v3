<?php

namespace App\Http\Controllers\Feedback;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FeedbackController extends Controller
{
    public function index() {
        return view('feedback.feedback_selection');
    }
}
