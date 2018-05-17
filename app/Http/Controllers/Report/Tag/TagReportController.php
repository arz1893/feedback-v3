<?php

namespace App\Http\Controllers\Report\Tag;

use App\FeedbackProduct;
use App\FeedbackService;
use App\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TagReportController extends Controller
{
    public function showTopTagSatisfactionYearly() {
        return view('report.tag.rating.top_tag_satisfaction_yearly');
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
}
