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
    public function getAllReportYearly($tenant_id, $customer_rating, $year, $count) {
        $feedbackServices = FeedbackService::where('tenantId', $tenant_id)->where('customer_rating', $customer_rating)->whereYear('created_at', $year)->orderBy('created_at', 'asc')->get();
        $tempLabels = [];
        $tempDatas = array();

        if(count($feedbackServices) > 0) {
            foreach ($feedbackServices as $feedbackService) {
                if(!in_array($feedbackService->service->name, $tempLabels)) {
                    array_push($tempLabels, $feedbackService->service->name);
                    array_push($tempDatas, 0);
                }
            }

            foreach ($feedbackServices as $feedbackService) {
                $index = array_search($feedbackService->service->name, $tempLabels);
                $tempDatas[$index] += 1;
            }

            for($i=0;$i<count($tempDatas);$i++) {
                $val = $tempDatas[$i];
                for($j=$i;$j<count($tempDatas);$j++) {
                    if($tempDatas[$j] > $val) {
                        $val = $tempDatas[$j];
                        $tempDatas[$j] = $tempDatas[$i];
                        $tempDatas[$i] = $val;

                        $label = $tempLabels[$j];
                        $tempLabels[$j] = $tempLabels[$i];
                        $tempLabels[$i] = $label;
                    }
                }
            }

            return ['labels' => array_slice($tempLabels, 0, $count), 'data' => array_slice($tempDatas, 0, $count)];
        } else {
            return ['error' => 'not found'];
        }
    }

    public function getAllReportMonthly($tenant_id, $customer_rating, $year, $month, $count) {
        $feedbackServices = FeedbackService::where('tenantId', $tenant_id)->where('customer_rating', $customer_rating)->whereYear('created_at', $year)->whereMonth('created_at', $month)->orderBy('created_at', 'asc')->get();

        $tempLabels = [];
        $tempDatas = array();

        if(count($feedbackServices) > 0) {
            foreach ($feedbackServices as $feedbackService) {
                if(!in_array($feedbackService->service->name, $tempLabels)) {
                    array_push($tempLabels, $feedbackService->service->name);
                    array_push($tempDatas, 0);
                }
            }

            foreach ($feedbackServices as $feedbackService) {
                $index = array_search($feedbackService->service->name, $tempLabels);
                $tempDatas[$index] += 1;
            }

            for($i=0;$i<count($tempDatas);$i++) {
                $val = $tempDatas[$i];
                for($j=$i;$j<count($tempDatas);$j++) {
                    if($tempDatas[$j] > $val) {
                        $val = $tempDatas[$j];
                        $tempDatas[$j] = $tempDatas[$i];
                        $tempDatas[$i] = $val;

                        $label = $tempLabels[$j];
                        $tempLabels[$j] = $tempLabels[$i];
                        $tempLabels[$i] = $label;
                    }
                }
            }

            return ['labels' => array_slice($tempLabels, 0, $count), 'data' => array_slice($tempDatas, 0, $count)];
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
