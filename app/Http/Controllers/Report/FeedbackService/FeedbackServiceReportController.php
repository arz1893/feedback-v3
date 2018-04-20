<?php

namespace App\Http\Controllers\Report\FeedbackService;

use App\FeedbackService;
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
}
