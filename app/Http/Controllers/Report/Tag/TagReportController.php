<?php

namespace App\Http\Controllers\Report\Tag;

use App\FeedbackProduct;
use App\FeedbackService;
use App\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TagReportController extends Controller
{
    public function index() {
        return view('report.tag.tag_report_index');
    }

    public function showTopTagSatisfactionYearly() {
        return view('report.tag.satisfaction.top_tag_satisfaction_yearly');
    }

    public function showTopTagSatisfactionMonthly() {
        return view('report.tag.satisfaction.top_tag_satisfaction_monthly');
    }

    public function showTagDetailReportYearly($tag_id) {
        $tag = Tag::findOrFail($tag_id);
        return view('report.tag.detail.show_tag_detail_report_yearly', compact('tag'));
    }

    /* API Section */
    public function getTopSatisfactionYearly($tenant_id, $customer_rating, $year, $count) {
        $feedbackProducts = FeedbackProduct::where('tenantId', $tenant_id)->where('customer_rating', $customer_rating)->whereYear('created_at', '=', $year)->get();
        $feedbackServices = FeedbackService::where('tenantId', $tenant_id)->where('customer_rating', $customer_rating)->whereYear('created_at', '=', $year)->get();

        if(count($feedbackProducts) > 0 || count($feedbackServices) > 0) {
            $tags = Tag::where('recOwner', $tenant_id)->get();
            $allTags = [];
            $tagValues = array_fill(0, count($tags), 0);
            foreach ($tags as $tag) {
                array_push($allTags, $tag->name);
            }

            foreach ($feedbackProducts as $feedbackProduct) {
                $productTags = $feedbackProduct->product->tags;
                foreach ($productTags as $productTag) {
                    $key = array_search($productTag->name, $allTags);
                    $tagValues[$key] += 1;
                }
            }

            foreach ($feedbackServices as $feedbackService) {
                $serviceTags = $feedbackService->service->tags;
                foreach ($serviceTags as $serviceTag) {
                    $key = array_search($serviceTag->name, $allTags);
                    $tagValues[$key] += 1;
                }
            }

            for ($i=0; $i<count($tagValues);$i++) {
                $currentValue = $tagValues[$i];
                for($j=$i;$j<count($tagValues);$j++) {
                    if($tagValues[$j] > $currentValue) {
                        $currentValue = $tagValues[$j];
                        $tagValues[$j] = $tagValues[$i];
                        $tagValues[$i] = $currentValue;

                        $tempTag = $allTags[$j];
                        $allTags[$j] = $allTags[$i];
                        $allTags[$i] = $tempTag;
                    }
                }
            }

            foreach ($tagValues as $key=>$tagValue) {
                if($tagValue == 0) {
                    unset($tagValues[$key]);
                    unset($allTags[$key]);
                }
            }

            $allTags = array_slice($allTags, 0, $count);
            $tagValues = array_slice($tagValues, 0, $count);

            return ['allTags' => $allTags, 'tagValues' => $tagValues];
        } else {
            return ['error' => 'There is no report at the current year'];
        }
    }

    public function getTopSatisfactionMonthly($tenant_id, $customer_rating, $year, $month, $count) {
        $feedbackProducts = FeedbackProduct::where('tenantId', $tenant_id)->where('customer_rating', $customer_rating)->whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $month)->get();
        $feedbackServices = FeedbackService::where('tenantId', $tenant_id)->where('customer_rating', $customer_rating)->whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $month)->get();

        if(count($feedbackProducts) > 0 || count($feedbackServices) > 0) {
            $tags = Tag::where('recOwner', $tenant_id)->get();
            $allTags = [];
            $tagValues = array_fill(0, count($tags), 0);
            foreach ($tags as $tag) {
                array_push($allTags, $tag->name);
            }

            foreach ($feedbackProducts as $feedbackProduct) {
                $productTags = $feedbackProduct->product->tags;
                foreach ($productTags as $productTag) {
                    $key = array_search($productTag->name, $allTags);
                    $tagValues[$key] += 1;
                }
            }

            foreach ($feedbackServices as $feedbackService) {
                $serviceTags = $feedbackService->service->tags;
                foreach ($serviceTags as $serviceTag) {
                    $key = array_search($serviceTag->name, $allTags);
                    $tagValues[$key] += 1;
                }
            }

            for ($i=0; $i<count($tagValues);$i++) {
                $currentValue = $tagValues[$i];
                for($j=$i;$j<count($tagValues);$j++) {
                    if($tagValues[$j] > $currentValue) {
                        $currentValue = $tagValues[$j];
                        $tagValues[$j] = $tagValues[$i];
                        $tagValues[$i] = $currentValue;

                        $tempTag = $allTags[$j];
                        $allTags[$j] = $allTags[$i];
                        $allTags[$i] = $tempTag;
                    }
                }
            }

            foreach ($tagValues as $key=>$tagValue) {
                if($tagValue == 0) {
                    unset($tagValues[$key]);
                    unset($allTags[$key]);
                }
            }

            $allTags = array_slice($allTags, 0, $count);
            $tagValues = array_slice($tagValues, 0, $count);

            return ['allTags' => $allTags, 'tagValues' => $tagValues];
        } else {
            return ['error' => 'There is no report at the current year'];
        }
    }

    public function getTagReportDetailYearly($tag_id, $year) {
        $tag = Tag::findOrFail($tag_id);
        $values = [0,0,0];
        $labels = ['satisfied', 'neutral', 'dissatisfied'];
        $nullCounter = 0;

        if(count($tag->products) > 0) {
            $products = $tag->products;
            $totalProduct = count($tag->products);
            foreach ($products as $product) {
                $feedbackProducts = FeedbackProduct::where('productId', $product->systemId)->whereYear('created_at', '=', $year)->get();
                if(count($feedbackProducts) > 0) {
                    foreach ($feedbackProducts as $feedbackProduct) {
                        switch ($feedbackProduct->customer_rating) {
                            case 1: {
                                $values[2] += 1;
                                break;
                            }
                            case 2: {
                                $values[1] += 1;
                                break;
                            }
                            case 3: {
                                $values[0] += 1;
                                break;
                            }
                        }
                    }
                } else {
                    $nullCounter++;
                }
            }
            if($nullCounter < $totalProduct) {
                return ['values' => $values, 'labels' => $labels];
            } else {
                return ['error' => 'There is no feedback yet for this tag at this year'];
            }
        } else if(count($tag->services) > 0) {
            $services = $tag->services;
            foreach ($services as $service) {
                $feedbackServices = FeedbackService::where('serviceId', $service->systemId)->whereYear('created_at', '=', $year)->get();
                if(count($feedbackServices) > 0) {
                    foreach ($feedbackServices as $feedbackService) {
                        switch ($feedbackService->customer_rating) {
                            case 1: {
                                $values[2] += 1;
                                break;
                            }
                            case 2: {
                                $values[1] += 1;
                                break;
                            }
                            case 3: {
                                $values[0] += 1;
                                break;
                            }
                        }
                    }
                    return ['values' => $values, 'labels' => $labels];
                } else {
                    return ['error' => 'There is no feedback yet for this tag at this year'];
                }
            }
            return ['values' => $values, 'labels' => $labels];
        } else {
            return ['error' => 'There is no feedback yet for this tag at this year'];
        }
    }
}
