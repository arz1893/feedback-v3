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

    public function showAllGlobalFeedbackYearly() {
        return view('report.all.global.all_global_feedback_yearly');
    }

    public function showAllTopSatisfactionYearly() {
        return view('report.all.satisfaction.all_top_satisfaction_yearly');
    }

    public function showAllTopSatisfactionMonthly() {
        return view('report.all.satisfaction.all_top_satisfaction_monthly');
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

    /* API Section Global Feedback */
    public function getAllGlobalFeedbackYearly($tenant_id, $year) {

        $i = 1;
        $labels = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        $allDatas = [];
        $nullCounter = 0;

        while($i <= 12) {
            $feedbackProducts = FeedbackProduct::where('tenantId', $tenant_id)->whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $i)->get();
            $feedbackServices = FeedbackService::where('tenantId', $tenant_id)->whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $i)->get();

            if(count($feedbackProducts) > 0 || count($feedbackServices) > 0) {
                $allDatas[$i-1] = count($feedbackProducts) + count($feedbackServices);
            } else {
                $allDatas[$i-1] = 0;
                $nullCounter++;
            }
            $i++;
        }

        if($nullCounter < 12) {
            return ['labels' => $labels, 'allDatas' => $allDatas];
        } else {
            return ['error' => 'There is no data in current year'];
        }
    }

    /* API Section Satisfaction */
    public function getAllTopSatisfactionYearly($tenant_id, $customer_rating, $year, $count) {
        $feedbackProducts = FeedbackProduct::where('tenantId', $tenant_id)->where('customer_rating', $customer_rating)->whereYear('created_at', '=', $year)->orderBy('created_at', 'desc')->get();
        $feedbackServices = FeedbackService::where('tenantId', $tenant_id)->where('customer_rating', $customer_rating)->whereYear('created_at', '=', $year)->orderBy('created_at', 'desc')->get();

        $productLabels = [];
        $productDatas = [];
        $productIds = [];
        $productMarker = [];
        $serviceLabels = [];
        $serviceDatas = [];
        $serviceIds = [];
        $serviceMarker = [];

        if(count($feedbackProducts) > 0) {
            foreach ($feedbackProducts as $feedbackProduct) {
                array_push($productIds, $feedbackProduct->product->systemId);
                array_push($productLabels, $feedbackProduct->product->name);
                array_push($productDatas, 0);
                array_push($productMarker, 1);
            }

            foreach ($feedbackProducts as $feedbackProduct) {
                $index = array_search($feedbackProduct->product->name, $productLabels);
                $productDatas[$index] += 1;
            }

            for($i=0;$i<count($productDatas);$i++) {
                $val = $productDatas[$i];
                for($j=$i;$j<count($productDatas);$j++) {
                    if($productDatas[$j] > $val) {
                        $val = $productDatas[$j];
                        $productDatas[$j] = $productDatas[$i];
                        $productDatas[$i] = $val;

                        $label = $productLabels[$j];
                        $productLabels[$j] = $productLabels[$i];
                        $productLabels[$i] = $label;

                        $id = $productIds[$j];
                        $productIds[$j] = $productIds[$i];
                        $productIds[$i] = $id;
                    }
                }
            }

            foreach ($productDatas as $key=>$productData) {
                if($productDatas[$key] == 0) {
                    unset($productDatas[$key]);
                    unset($productIds[$key]);
                    unset($productLabels[$key]);
                    unset($productMarker[$key]);
                }
            }

            $productIds = array_slice($productIds, 0, $count);
            $productLabels = array_slice($productLabels, 0, $count);
            $productDatas = array_slice($productDatas, 0, $count);
        }

        if(count($feedbackServices) > 0) {
            foreach ($feedbackServices as $feedbackService) {
                array_push($serviceIds, $feedbackService->service->systemId);
                array_push($serviceLabels, $feedbackService->service->name);
                array_push($serviceDatas, 0);
                array_push($serviceMarker, 0);
            }

            foreach ($feedbackServices as $feedbackService) {
                $index = array_search($feedbackService->service->name, $serviceLabels);
                $serviceDatas[$index] += 1;
            }

            for($i=0;$i<count($serviceDatas);$i++) {
                $val = $serviceDatas[$i];
                for($j=$i;$j<count($serviceDatas);$j++) {
                    if($serviceDatas[$j] > $val) {
                        $val = $serviceDatas[$j];
                        $serviceDatas[$j] = $serviceDatas[$i];
                        $serviceDatas[$i] = $val;

                        $label = $serviceLabels[$j];
                        $serviceLabels[$j] = $serviceLabels[$i];
                        $serviceLabels[$i] = $label;

                        $id = $serviceIds[$j];
                        $serviceIds[$j] = $serviceIds[$i];
                        $serviceIds[$i] = $id;
                    }
                }
            }

            foreach ($serviceDatas as $key=>$serviceData) {
                if($serviceDatas[$key] == 0) {
                    unset($serviceDatas[$key]);
                    unset($serviceIds[$key]);
                    unset($serviceLabels[$key]);
                    unset($serviceMarker[$key]);
                }
            }

            $serviceIds = array_slice($serviceIds, 0, $count);
            $serviceLabels = array_slice($serviceLabels, 0, $count);
            $serviceDatas = array_slice($serviceDatas, 0, $count);
        }

        if(count($productDatas) > 0 && count($serviceDatas) > 0) {
            $allIds = array_merge($productIds, $serviceIds);
            $allLabels = array_merge($productLabels, $serviceLabels);
            $allDatas = array_merge($productDatas, $serviceDatas);
            $allMarkers = array_merge($productMarker, $serviceMarker);

            for($i=0;$i<count($allDatas);$i++) {
                $val = $allDatas[$i];
                for($j=$i;$j<count($allDatas);$j++) {
                    if($allDatas[$j] > $val) {
                        $val = $allDatas[$j];
                        $allDatas[$j] = $allDatas[$i];
                        $allDatas[$i] = $val;

                        $label = $allLabels[$j];
                        $allLabels[$j] = $allLabels[$i];
                        $allLabels[$i] = $label;

                        $id = $allIds[$j];
                        $allIds[$j] = $allIds[$i];
                        $allIds[$i] = $id;

                        $marker = $allMarkers[$j];
                        $allMarkers[$j] = $allMarkers[$i];
                        $allMarkers[$i] = $marker;
                    }
                }
            }
            return ['allIds' => array_slice($allIds, 0, $count), 'allLabels' => array_slice($allLabels, 0, $count), 'allDatas' => array_slice($allDatas, 0, $count), 'allMarkers' => array_slice($allMarkers, 0, $count)];
        } else {
            return ['error' => 'There is no data for the current selected year'];
        }
    }

    public function getAllTopSatisfactionMonthly($tenant_id, $customer_rating, $year, $month, $count) {
        $feedbackProducts = FeedbackProduct::where('tenantId', $tenant_id)->where('customer_rating', $customer_rating)->whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $month)->orderBy('created_at', 'desc')->get();
        $feedbackServices = FeedbackService::where('tenantId', $tenant_id)->where('customer_rating', $customer_rating)->whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $month)->orderBy('created_at', 'desc')->get();

        $productLabels = [];
        $productDatas = [];
        $productIds = [];
        $productMarker = [];
        $serviceLabels = [];
        $serviceDatas = [];
        $serviceIds = [];
        $serviceMarker = [];

        if(count($feedbackProducts) > 0) {
            foreach ($feedbackProducts as $feedbackProduct) {
                array_push($productIds, $feedbackProduct->product->systemId);
                array_push($productLabels, $feedbackProduct->product->name);
                array_push($productDatas, 0);
                array_push($productMarker, 1);
            }

            foreach ($feedbackProducts as $feedbackProduct) {
                $index = array_search($feedbackProduct->product->name, $productLabels);
                $productDatas[$index] += 1;
            }

            for($i=0;$i<count($productDatas);$i++) {
                $val = $productDatas[$i];
                for($j=$i;$j<count($productDatas);$j++) {
                    if($productDatas[$j] > $val) {
                        $val = $productDatas[$j];
                        $productDatas[$j] = $productDatas[$i];
                        $productDatas[$i] = $val;

                        $label = $productLabels[$j];
                        $productLabels[$j] = $productLabels[$i];
                        $productLabels[$i] = $label;

                        $id = $productIds[$j];
                        $productIds[$j] = $productIds[$i];
                        $productIds[$i] = $id;
                    }
                }
            }

            foreach ($productDatas as $key=>$productData) {
                if($productDatas[$key] == 0) {
                    unset($productDatas[$key]);
                    unset($productIds[$key]);
                    unset($productLabels[$key]);
                    unset($productMarker[$key]);
                }
            }

            $productIds = array_slice($productIds, 0, $count);
            $productLabels = array_slice($productLabels, 0, $count);
            $productDatas = array_slice($productDatas, 0, $count);
        }

        if(count($feedbackServices) > 0) {
            foreach ($feedbackServices as $feedbackService) {
                array_push($serviceIds, $feedbackService->service->systemId);
                array_push($serviceLabels, $feedbackService->service->name);
                array_push($serviceDatas, 0);
                array_push($serviceMarker, 0);
            }

            foreach ($feedbackServices as $feedbackService) {
                $index = array_search($feedbackService->service->name, $serviceLabels);
                $serviceDatas[$index] += 1;
            }

            for($i=0;$i<count($serviceDatas);$i++) {
                $val = $serviceDatas[$i];
                for($j=$i;$j<count($serviceDatas);$j++) {
                    if($serviceDatas[$j] > $val) {
                        $val = $serviceDatas[$j];
                        $serviceDatas[$j] = $serviceDatas[$i];
                        $serviceDatas[$i] = $val;

                        $label = $serviceLabels[$j];
                        $serviceLabels[$j] = $serviceLabels[$i];
                        $serviceLabels[$i] = $label;

                        $id = $serviceIds[$j];
                        $serviceIds[$j] = $serviceIds[$i];
                        $serviceIds[$i] = $id;
                    }
                }
            }

            foreach ($serviceDatas as $key=>$serviceData) {
                if($serviceDatas[$key] == 0) {
                    unset($serviceDatas[$key]);
                    unset($serviceIds[$key]);
                    unset($serviceLabels[$key]);
                    unset($serviceMarker[$key]);
                }
            }

            $serviceIds = array_slice($serviceIds, 0, $count);
            $serviceLabels = array_slice($serviceLabels, 0, $count);
            $serviceDatas = array_slice($serviceDatas, 0, $count);
        }

        if(count($productDatas) > 0 || count($serviceDatas) > 0) {
            $allIds = array_merge($productIds, $serviceIds);
            $allLabels = array_merge($productLabels, $serviceLabels);
            $allDatas = array_merge($productDatas, $serviceDatas);
            $allMarkers = array_merge($productMarker, $serviceMarker);

            for($i=0;$i<count($allDatas);$i++) {
                $val = $allDatas[$i];
                for($j=$i;$j<count($allDatas);$j++) {
                    if($allDatas[$j] > $val) {
                        $val = $allDatas[$j];
                        $allDatas[$j] = $allDatas[$i];
                        $allDatas[$i] = $val;

                        $label = $allLabels[$j];
                        $allLabels[$j] = $allLabels[$i];
                        $allLabels[$i] = $label;

                        $id = $allIds[$j];
                        $allIds[$j] = $allIds[$i];
                        $allIds[$i] = $id;

                        $marker = $allMarkers[$j];
                        $allMarkers[$j] = $allMarkers[$i];
                        $allMarkers[$i] = $marker;
                    }
                }
            }
            return ['allIds' => array_slice($allIds, 0, $count), 'allLabels' => array_slice($allLabels, 0, $count), 'allDatas' => array_slice($allDatas, 0, $count), 'allMarkers' => array_slice($allMarkers, 0, $count)];
        } else {
            return ['error' => 'There is no data for the current selected year'];
        }
    }
}
