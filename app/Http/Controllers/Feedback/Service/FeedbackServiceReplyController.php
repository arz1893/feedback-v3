<?php

namespace App\Http\Controllers\Feedback\Service;

use App\FeedbackServiceReply;
use App\Http\Resources\Feedback\FeedbackServiceReplyCollection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Webpatser\Uuid\Uuid;

class FeedbackServiceReplyController extends Controller
{
    public function addFeedbackServiceReply(Request $request) {
        FeedbackServiceReply::create([
            'systemId' => Uuid::generate(4),
            'reply_content' => $request->reply_content,
            'customerId' => $request->customerId,
            'feedbackServiceId' => $request->feedbackServiceId,
            'syscreator' => $request->syscreator
        ]);

        return ['message' => 'success'];
    }

    public function getFeedbackServiceReplies($feedback_service_id) {
        $feedbackServiceReplies = FeedbackServiceReply::where('feedbackServiceId', $feedback_service_id)->orderBy('created_at', 'asc')->get();
        return new FeedbackServiceReplyCollection($feedbackServiceReplies);
    }

    public function deleteFeedbackServiceReply($reply_id) {
        $feedbackServiceReply = FeedbackServiceReply::findOrFail($reply_id);
        $feedbackServiceReply->delete();
        return ['message' => 'success'];
    }
}
