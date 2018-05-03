<?php

namespace App\Http\Controllers\Report\FeedbackProduct;

use App\FeedbackProduct;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FeedbackProductReportController extends Controller
{
    public function index() {
        return view('report.feedback_product.feedback_product_report_index');
    }

    public function showTopProductReportYearly() {
        return view('report.feedback_product.all.top_feedback_product_all_yearly');
    }

    public function showTopProductReportMonthly() {
        return view('report.feedback_product.all.top_feedback_product_all_monthly');
    }

    public function showAllReportYearly() {
        return view('report.feedback_product.all.feedback_product_report_all_yearly');
    }

    public function showAllReportMonthly() {
        return view('report.feedback_product.all.feedback_product_report_all_monthly');
    }

    public function showFeedbackProductReportYearly($product_id) {
        $product = Product::findOrFail($product_id);
        return view('report.feedback_product.detail.feedback_product_report_detail_yearly', compact('product'));
    }

    public function showFeedbackProductReportMonthly($product_id) {
        $product = Product::findOrFail($product_id);
        return view('report.feedback_product.detail.feedback_product_report_detail_monthly', compact('product'));
    }

    /* API Section */
    public function getTopProductReportYearly($tenant_id, $customer_rating, $year, $count) {
        $feedbackProducts = FeedbackProduct::where('tenantId', $tenant_id)->where('customer_rating', $customer_rating)->whereYear('created_at', $year)->orderBy('created_at', 'asc')->get();
        $tempLabels = [];
        $tempDatas = [];
        $tempIds = [];

        if(count($feedbackProducts) > 0) {
            foreach ($feedbackProducts as $feedbackProduct) {
                if(!in_array($feedbackProduct->product->name, $tempLabels)) {
                    array_push($tempIds, $feedbackProduct->product->systemId);
                    array_push($tempLabels, $feedbackProduct->product->name);
                    array_push($tempDatas, 0);
                }
            }

            foreach ($feedbackProducts as $feedbackProduct) {
                $index = array_search($feedbackProduct->product->name, $tempLabels);
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

    public function getTopProductReportMonthly($tenant_id, $customer_rating, $year, $month, $count) {
        $feedbackProducts = FeedbackProduct::where('tenantId', $tenant_id)->where('customer_rating', $customer_rating)->whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $month)->orderBy('created_at', 'asc')->get();

        $tempLabels = [];
        $tempDatas = [];
        $tempIds = [];

        if(count($feedbackProducts) > 0) {
            foreach ($feedbackProducts as $feedbackProduct) {
                if(!in_array($feedbackProduct->product->name, $tempLabels)) {
                    array_push($tempLabels, $feedbackProduct->product->name);
                    array_push($tempDatas, 0);
                    array_push($tempIds, $feedbackProduct->product->systemId);
                }
            }

            foreach ($feedbackProducts as $feedbackProduct) {
                $index = array_search($feedbackProduct->product->name, $tempLabels);
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
            $totalFeedback = count($feedbackProducts = FeedbackProduct::where('tenantId', $tenant_id)->whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $i)->get());
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
            $totalFeedback = count(FeedbackProduct::where('tenantId', $tenant_id)->whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $month)->whereDay('created_at', '=', $i+1)->get());
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

    public function getReportDetailYearly($product_id, $year) {
        $rating = ['not satisfied', 'neutral', 'satisfied'];
        $ratingValue = [0,0,0];

        $feedbackProducts = FeedbackProduct::where('productId', $product_id)->whereYear('created_at', $year)->get();

        if(count($feedbackProducts) > 0) {
            foreach ($feedbackProducts as $feedbackProduct) {
                if($feedbackProduct->customer_rating === 1) {
                    $ratingValue[0] += 1;
                } else if($feedbackProduct->customer_rating === 2 ) {
                    $ratingValue[1] += 1;
                } else if($feedbackProduct->customer_rating === 3) {
                    $ratingValue[2] += 1;
                }
            }

            return ['rating' => $rating, 'rating_value' => [$ratingValue]];
        } else {
            return ['error' => 'data not found'];
        }
    }

    public function getReportDetailMonthly($product_id, $year, $month) {
        $rating = ['not satisfied', 'neutral', 'satisfied'];
        $ratingValue = [0,0,0];

        $feedbackProducts = FeedbackProduct::where('productId', $product_id)->whereMonth('created_at', '=' ,$month)->whereYear('created_at', '=' ,$year)->get();

        if(count($feedbackProducts) > 0) {
            foreach ($feedbackProducts as $feedbackProduct) {
                if($feedbackProduct->customer_rating === 1) {
                    $ratingValue[0] += 1;
                } else if($feedbackProduct->customer_rating === 2 ) {
                    $ratingValue[1] += 1;
                } else if($feedbackProduct->customer_rating === 3) {
                    $ratingValue[2] += 1;
                }
            }

            return ['rating' => $rating, 'rating_value' => [$ratingValue]];
        } else {
            return ['error' => 'data not found'];
        }
    }
}
