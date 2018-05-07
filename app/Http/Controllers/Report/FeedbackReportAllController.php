<?php

namespace App\Http\Controllers\Report;

use App\FeedbackProduct;
use App\FeedbackService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FeedbackReportAllController extends Controller
{
    public function showAllRatingYearly() {
        return view('report.all.rating.all_feedback_rating_yearly');
    }

    /* API Section Rating */
    public function getAllFeedbackRatingYearly($tenant_id, $year) {
        $i = 1;
        $nullCounter = 0;
        $labels = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        $dissatisfied = [0,0,0,0,0,0,0,0,0,0,0,0];
        $neutral = [0,0,0,0,0,0,0,0,0,0,0,0];
        $satisfied = [0,0,0,0,0,0,0,0,0,0,0,0];
        while($i <= 12) {
            $feedbackProducts = FeedbackProduct::where('tenantId', $tenant_id)->whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $i)->get();
            $feedbackServices = FeedbackService::where('tenantId', $tenant_id)->whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $i)->get();

            if(count($feedbackProducts) == 0 && count($feedbackServices) == 0) {
                $nullCounter++;
            } else {
                foreach ($feedbackProducts as $feedbackProduct) {
                    switch ($feedbackProduct->customer_rating) {
                        case 1: {
                            $dissatisfied[$i-1] += 1;
                            break;
                        }
                        case 2: {
                            $neutral[$i-1] += 1;
                            break;
                        }
                        case 3: {
                            $satisfied[$i-1] += 1;
                            break;
                        }
                    }
                }

                foreach ($feedbackServices as $feedbackService) {
                    switch ($feedbackService->customer_rating) {
                        case 1: {
                            $dissatisfied[$i-1] += 1;
                            break;
                        }
                        case 2: {
                            $neutral[$i-1] += 1;
                            break;
                        }
                        case 3: {
                            $satisfied[$i-1] += 1;
                            break;
                        }
                    }
                }
            }

            $i++;
        }

        if($nullCounter < 12) {
            return ['labels' => $labels, 'dissatisfied' => $dissatisfied, 'neutral' => $neutral, 'satisfied' => $satisfied];
        }
        else {
            return ['message' => 'there is no data at the current year'];
        }
    }
}
