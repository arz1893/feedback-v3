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

    public function showAllRatingMonthly() {
        return view('report.all.rating.all_feedback_rating_monthly');
    }

    public function showAllCompareYearly() {
        return view('report.all.compare.all_feedback_compare_yearly');
    }

    public function showAllCompareMonthly() {
        return view('report.all.compare.all_feedback_compare_monthly');
    }

    /* API Section Rating */
    public function getAllFeedbackRatingYearly($tenant_id, $year) {
        $i = 1;
        $nullCounter = 0;
        $labels = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        $dissatisfied = array_fill(0, 12, 0);
        $neutral =  array_fill(0, 12, 0);
        $satisfied = array_fill(0, 12, 0);
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

    public function getAllFeedbackRatingMonthly($tenant_id, $year, $month) {
        $i = 1;
        $nullCounter = 0;
        $totalDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $labels = [];
        $dissatisfied = array_fill(0, $totalDays, 0);
        $neutral = array_fill(0, $totalDays, 0);
        $satisfied = array_fill(0, $totalDays, 0);



        while($i <= $totalDays) {
            $feedbackProducts = FeedbackProduct::where('tenantId', $tenant_id)->whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $month)->whereDay('created_at', '=', $i)->get();
            $feedbackServices = FeedbackService::where('tenantId', $tenant_id)->whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $month)->whereDay('created_at', '=', $i)->get();
            $labels[$i-1] = 'Day ' . $i;

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

        if($nullCounter < $totalDays) {
            return ['labels' => $labels, 'dissatisfied' => $dissatisfied, 'neutral' => $neutral, 'satisfied' => $satisfied];
        } else {
            return ['message' => 'There is no data at the current month and year'];
        }
    }

    /* API Section Compare */
    public function getAllFeedbackCompareYearly($tenant_id, $year) {
        $i = 1;
        $nullCounter = 0;
        $labels = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        $dissatisfied = array_fill(0, 12, 0);
        $neutral = array_fill(0, 12, 0);
        $satisfied = array_fill(0, 12, 0);

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
                    switch($feedbackService->customer_rating) {
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
        } else {
            return ['message' => 'There is no data in the current year'];
        }
    }

    public function getAllFeedbackCompareMonthly($tenant_id, $year, $month) {
        $i = 1;
        $nullCounter = 0;
        $totalDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $labels = [];
        $dissatisfied = array_fill(0, $totalDays, 0);
        $neutral = array_fill(0, $totalDays, 0);
        $satisfied = array_fill(0, $totalDays, 0);



        while($i <= $totalDays) {
            $feedbackProducts = FeedbackProduct::where('tenantId', $tenant_id)->whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $month)->whereDay('created_at', '=', $i)->get();
            $feedbackServices = FeedbackService::where('tenantId', $tenant_id)->whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $month)->whereDay('created_at', '=', $i)->get();
            $labels[$i-1] = $i;

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

        if($nullCounter < $totalDays) {
            return ['labels' => $labels, 'dissatisfied' => $dissatisfied, 'neutral' => $neutral, 'satisfied' => $satisfied];
        } else {
            return ['message' => 'There is no data at the current month and year'];
        }
    }
}
