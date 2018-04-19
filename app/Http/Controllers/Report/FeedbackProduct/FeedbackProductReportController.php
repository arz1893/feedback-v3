<?php

namespace App\Http\Controllers\Report\FeedbackProduct;

use App\FeedbackProduct;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FeedbackProductReportController extends Controller
{
    public function index() {
        return view('report.feedback_product.feedback_product_report_index');
    }

    public function showAllReport() {
        return view('report.feedback_product.feedback_product_report_all_yearly');
    }

    public function showAllReportMonthly() {
        return view('report.feedback_product.feedback_product_report_all_monthly');
    }

    /* API Section */
    public function getAllReportYearly($tenant_id, $customer_rating, $year, $count) {
        $feedbackProducts = FeedbackProduct::where('tenantId', $tenant_id)->where('customer_rating', $customer_rating)->whereYear('created_at', $year)->orderBy('created_at', 'asc')->get();
        $tempLabels = [];
        $tempDatas = array();

        if(count($feedbackProducts) > 0) {
            foreach ($feedbackProducts as $feedbackProduct) {
                if(!in_array($feedbackProduct->product->name, $tempLabels)) {
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
                    }
                }
            }

            return ['labels' => array_slice($tempLabels, 0, $count), 'data' => array_slice($tempDatas, 0, $count)];
        } else {
            return ['error' => 'not found'];
        }
    }

    public function getAllReportMonthly($tenant_id, $customer_rating, $year, $month, $count) {
        $feedbackProducts = FeedbackProduct::where('tenantId', $tenant_id)->where('customer_rating', $customer_rating)->whereYear('created_at', $year)->whereMonth('created_at', $month)->orderBy('created_at', 'asc')->get();

        $tempLabels = [];
        $tempDatas = array();

        if(count($feedbackProducts) > 0) {
            foreach ($feedbackProducts as $feedbackProduct) {
                if(!in_array($feedbackProduct->product->name, $tempLabels)) {
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
                    }
                }
            }

            return ['labels' => array_slice($tempLabels, 0, $count), 'data' => array_slice($tempDatas, 0, $count)];
        } else {
            return ['error' => 'not found'];
        }
    }
}
