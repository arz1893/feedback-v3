<?php

namespace App\Http\Controllers\Feedback\Product;

use App\FeedbackProductReply;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Webpatser\Uuid\Uuid;

class FeedbackProductReplyController extends Controller
{
    public function index() {

    }

    /* API Section */
    public function addFeedbackProductReply(Request $request) {
        FeedbackProductReply::create([
            'systemId' => Uuid::generate(4),
            'reply_content' => $request->reply_content,
            'customerId' => $request->customerId,
            'feedbackProductId' => $request->feedbackProductId,
            'syscreator' => $request->syscreator
        ]);

        return ['message' => 'success'];
    }

    public function getFeedbackProductReplies($feedback_product_id) {

    }
}
