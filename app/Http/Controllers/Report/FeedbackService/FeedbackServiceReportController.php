<?php

namespace App\Http\Controllers\Report\FeedbackService;

use App\FeedbackService;
use App\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FeedbackServiceReportController extends Controller
{
    public function index() {
        return view('report.feedback_service.feedback_service_report_index');
    }

    public function showAllReportYearly() {
        return view('report.feedback_service.feedback_service_report_all_yearly');
    }

    public function showAllReportMonthly() {
        return view('report.feedback_service.feedback_service_report_all_monthly');
    }

    public function showFeedbackServiceReportYearly($service_id) {
        $service = Service::findOrFail($service_id);
        return view('report.feedback_service.detail.feedback_service_report_detail_yearly', compact('service'));
    }

    public function showFeedbackServiceReportMonthly($service_id) {
        $service = Service::findOrFail($service_id);
        return view('report.feedback_service.detail.feedback_service_report_detail_monthly', compact('service'));
    }

    /* API Section */
    public function getAllReportYearly($tenant_id, $year) {
        $tempLabels = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        $tempDatas = [];
        $nullCounter = 0;

        for($i=1;$i<=12;$i++) {
            $totalFeedback = count($feedbackProducts = FeedbackService::where('tenantId', $tenant_id)->whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $i)->get());
            $tempDatas[$i-1] = $totalFeedback;
            if($totalFeedback == 0) {
                $nullCounter++;
            }
        }

        if($nullCounter < 12) {
            return ['labels' => $tempLabels, 'data' => $tempDatas];
        } else {
            return ['error' => 'not found'];
        }
    }

    public function getAllReportMonthly($tenant_id, $year, $month) {
        $tempLabels = [];
        $tempDatas = [];
        $nullCounter = 0;
        $daysOfMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);

        for($i=0;$i<$daysOfMonth;$i++) {
            $tempLabels[$i] = $i+1;
            $totalFeedback = count(FeedbackService::where('tenantId', $tenant_id)->whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $month)->whereDay('created_at', '=', $i+1)->get());
            $tempDatas[$i] = $totalFeedback;

            if($totalFeedback == 0) {
                $nullCounter++;
            }
        }

        if($nullCounter != $daysOfMonth) {
            return ['labels' => $tempLabels, 'data' => $tempDatas];
        } else {
            return ['error' => 'not found'];
        }
    }

    public function getReportDetailYearly($service_id, $year) {
        $rating = ['not satisfied', 'neutral', 'satisfied'];
        $ratingValue = [0,0,0];

        $feedbackServices = FeedbackService::where('serviceId', $service_id)->whereYear('created_at', $year)->get();

        if(count($feedbackServices) > 0) {
            foreach ($feedbackServices as $feedbackService) {
                if($feedbackService->customer_rating === 1) {
                    $ratingValue[0] += 1;
                } else if($feedbackService->customer_rating === 2 ) {
                    $ratingValue[1] += 1;
                } else if($feedbackService->customer_rating === 3) {
                    $ratingValue[2] += 1;
                }
            }

            return ['rating' => $rating, 'rating_value' => [$ratingValue]];
        } else {
            return ['error' => 'data not found'];
        }
    }

    public function getReportDetailMonthly($service_id, $year, $month) {
        $rating = ['not satisfied', 'neutral', 'satisfied'];
        $ratingValue = [0,0,0];

        $feedbackServices = FeedbackService::where('serviceId', $service_id)->whereYear('created_at', $year)->whereMonth('created_at', $month)->get();

        if(count($feedbackServices) > 0) {
            foreach ($feedbackServices as $feedbackService) {
                if($feedbackService->customer_rating === 1) {
                    $ratingValue[0] += 1;
                } else if($feedbackService->customer_rating === 2 ) {
                    $ratingValue[1] += 1;
                } else if($feedbackService->customer_rating === 3) {
                    $ratingValue[2] += 1;
                }
            }

            return ['rating' => $rating, 'rating_value' => [$ratingValue]];
        } else {
            return ['error' => 'data not found'];
        }
//        return ['service_id' => $service_id, 'year' => $year, 'month' => $month];
    }
}
