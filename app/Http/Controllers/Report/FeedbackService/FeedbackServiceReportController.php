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

    public function showTopServiceReportYearly() {
        return view('report.feedback_service.all.top_feedback_service_all_yearly');
    }

    public function showTopServiceReportMonthly() {
        return view('report.feedback_service.all.top_feedback_service_all_monthly');
    }

    public function showAllReportYearly() {
        return view('report.feedback_service.all.feedback_service_report_all_yearly');
    }

    public function showAllReportMonthly() {
        return view('report.feedback_service.all.feedback_service_report_all_monthly');
    }

    public function showFeedbackServiceReportYearly($service_id) {
        $service = Service::findOrFail($service_id);
        return view('report.feedback_service.detail.feedback_service_report_detail_yearly', compact('service'));
    }

    public function showFeedbackServiceReportMonthly($service_id) {
        $service = Service::findOrFail($service_id);
        return view('report.feedback_service.detail.feedback_service_report_detail_monthly', compact('service'));
    }

    public function showFeedbackServiceCompareYearly() {
        return view('report.feedback_service.all.feedback_service_compare_yearly');
    }

    public function showFeedbackServiceCompareMonthly() {
        return view('report.feedback_service.all.feedback_service_compare_monthly');
    }

    /* API Section */
    public function getTopServiceReportYearly($tenant_id, $customer_rating, $year, $count) {
        $feedbackServices = FeedbackService::where('tenantId', $tenant_id)->where('customer_rating', $customer_rating)->whereYear('created_at', $year)->orderBy('created_at', 'asc')->get();
        $tempLabels = [];
        $tempDatas = [];
        $tempIds = [];

        if(count($feedbackServices) > 0) {
            foreach ($feedbackServices as $feedbackService) {
                if(!in_array($feedbackService->service->name, $tempLabels)) {
                    array_push($tempIds, $feedbackService->service->systemId);
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

                        $id = $tempIds[$j];
                        $tempIds[$j] = $tempIds[$i];
                        $tempIds[$i] = $id;
                    }
                }
            }

            return ['id' => array_slice($tempIds, 0, $count),'labels' => array_slice($tempLabels, 0, $count), 'data' => array_slice($tempDatas, 0, $count)];
        } else {
            return ['error' => 'not found'];
        }
    }

    public function getTopServiceReportMonthly($tenant_id, $customer_rating, $year, $month, $count) {
        $feedbackServices = FeedbackService::where('tenantId', $tenant_id)->where('customer_rating', $customer_rating)->whereYear('created_at', $year)->whereMonth('created_at', $month)->orderBy('created_at', 'asc')->get();

        $tempLabels = [];
        $tempDatas = [];
        $tempIds = [];

        if(count($feedbackServices) > 0) {
            foreach ($feedbackServices as $feedbackService) {
                if(!in_array($feedbackService->service->name, $tempLabels)) {
                    array_push($tempIds, $feedbackService->service->systemId);
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

                        $id = $tempIds[$j];
                        $tempIds[$j] = $tempIds[$i];
                        $tempIds[$i] = $id;
                    }
                }
            }

            return ['id' => array_slice($tempIds, 0, $count),'labels' => array_slice($tempLabels, 0, $count), 'data' => array_slice($tempDatas, 0, $count)];
        } else {
            return ['error' => 'not found'];
        }
    }

    public function getAllReportYearly($tenant_id, $year) {
        $tempLabels = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        $tempDatas = [];
        $nullCounter = 0;

        for($i=1;$i<=12;$i++) {
            $totalFeedback = count(FeedbackService::where('tenantId', $tenant_id)->whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $i)->get());
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

    public function getFeedbackServiceCompareYearly($tenant_id, $year) {
        $i = 1;
        $nullCounter = 0;
        $labels = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        $dissatisfied = array_fill(0, 12, 0);
        $neutral = array_fill(0, 12, 0);
        $satisfied = array_fill(0, 12, 0);

        while($i <= 12) {
            $feedbackServices = FeedbackService::where('tenantId', $tenant_id)->whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $i)->get();

            if(count($feedbackServices) == 0) {
                $nullCounter++;
            } else {
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
        } else {
            return ['message' => 'There is no data in the current year'];
        }
    }

    public function getFeedbackServiceCompareMonthly($tenant_id, $year, $month) {
        $i = 1;
        $nullCounter = 0;
        $totalDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $labels = [];
        $dissatisfied = array_fill(0, $totalDays, 0);
        $neutral = array_fill(0, $totalDays, 0);
        $satisfied = array_fill(0, $totalDays, 0);



        while($i <= $totalDays) {
            $feedbackServices = FeedbackService::where('tenantId', $tenant_id)->whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $month)->whereDay('created_at', '=', $i)->get();
            $labels[$i-1] = $i;

            if(count($feedbackServices) == 0) {
                $nullCounter++;
            } else {
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
