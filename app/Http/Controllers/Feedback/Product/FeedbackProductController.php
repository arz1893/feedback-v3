<?php

namespace App\Http\Controllers\Feedback\Product;

use App\ComplaintProduct;
use App\Customer;
use App\FeedbackProduct;
use App\Http\Resources\Feedback\FeedbackProductCollection;
use App\Http\Resources\Feedback\FeedbackProduct as FeedbackProductResource;
use App\Product;
use App\Tenant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Webpatser\Uuid\Uuid;
use Intervention\Image\ImageManagerStatic as InterventionImage;

class FeedbackProductController extends Controller
{
    public function index() {
        return view('feedback.product.feedback_product_index');
    }

    public function show($systemId) {
        $product = Product::findOrFail($systemId);
        return view('feedback.product.feedback_product_show', compact('product'));
    }

    public function portDatabase() {
        $complaintProducts = ComplaintProduct::all();
        foreach ($complaintProducts as $complaintProduct) {
            if($complaintProduct->customer_rating < 3) {
                $complaintProduct->customer_rating = 1;
                $complaintProduct->update();
            } else if($complaintProduct->customer_rating == 3) {
                $complaintProduct->customer_rating = 2;
                $complaintProduct->update();
            } else if($complaintProduct->customer_rating > 3) {
                $complaintProduct->customer_rating = 3;
                $complaintProduct->update();
            }
        }
        foreach ($complaintProducts as $complaintProduct) {
            FeedbackProduct::create([
                'systemId' => $complaintProduct->systemId,
                'customer_rating' => $complaintProduct->customer_rating,
                'customer_feedback' => $complaintProduct->customer_complaint,
                'is_need_call' => $complaintProduct->is_need_call,
                'is_urgent' => $complaintProduct->is_urgent,
                'productId' => $complaintProduct->productId,
                'productCategoryId' => $complaintProduct->productCategoryId,
                'tenantId' => $complaintProduct->tenantId,
                'is_answered' => $complaintProduct->is_answered,
                'attachment' => $complaintProduct->attachment,
                'syscreator' => $complaintProduct->syscreator,
                'sysupdater' => $complaintProduct->sysupdater,
                'created_at' => $complaintProduct->created_at,
                'updated_at' => $complaintProduct->updated_at,
            ]);
        }
    }

    /* API Section */
    public function addFeedbackProduct(Request $request, $tenant_id) {
        $id = Uuid::generate(4);
        $tenant = Tenant::findOrFail($tenant_id);

        if($request->feedbackProduct['fileName'] != '') {
            $file_name = $id . '_' . $request->feedbackProduct['fileName'];
            if(!file_exists(public_path('attachment/' . $tenant->email . '/feedback_product/' . $id . '/'))) {
                mkdir(public_path('attachment/' . $tenant->email . '/feedback_product/' . $id . '/'), 0775, true);
            }
            InterventionImage::make($request->feedbackProduct['image'])->save(public_path('attachment/' . $tenant->email . '/feedback_product/' . $id . '/' . $file_name));
            FeedbackProduct::create([
                'systemId' => $id,
                'customer_rating' => $request->feedbackProduct['rating'],
                'customer_feedback' => $request->feedbackProduct['feedback'],
                'is_need_call' => $request->feedbackProduct['need_call'],
                'is_urgent' => $request->feedbackProduct['is_urgent'],
                'customerId' => $request->feedbackProduct['customer']['systemId'],
                'productId' => $request->productId,
                'productCategoryId' => $request->productCategoryId,
                'tenantId' => $tenant_id,
                'attachment' => 'attachment/' . $tenant->email . '/feedback_product/' . $id . '/' . $file_name,
                'syscreator' => $request->creator
            ]);
        } else {
            FeedbackProduct::create([
                'systemId' => $id,
                'customer_rating' => $request->feedbackProduct['rating'],
                'customer_feedback' => $request->feedbackProduct['feedback'],
                'is_need_call' => $request->feedbackProduct['need_call'],
                'is_urgent' => $request->feedbackProduct['is_urgent'],
                'customerId' => $request->feedbackProduct['customer']['systemId'],
                'productId' => $request->productId,
                'productCategoryId' => $request->productCategoryId,
                'tenantId' => $tenant_id,
                'syscreator' => $request->creator
            ]);
        }

        return ['message' => 'success'];
    }

    public function getFeedbackProductList($tenant_id){
        $from = date('Y-m-d 00:00:00');
        $to = date('Y-m-d H:i:s');
        $feedbackProducts = FeedbackProduct::where('tenantId', $tenant_id)->whereBetween('created_at', [$from, $to])->orderBy('created_at', 'desc')->paginate(15);
        return new FeedbackProductCollection($feedbackProducts);
    }

    public function getFeedbackProduct($feedback_id) {
        $feedbackProduct = FeedbackProduct::findOrFail($feedback_id);
        return new FeedbackProductResource($feedbackProduct);
    }

    public function getProductCustomerFeedbackYearly($product_id, $customer_rating, $year) {
        $feedbackProducts = FeedbackProduct::where('productId', '=' ,$product_id)->where('customer_rating', '=', $customer_rating)->whereYear('created_at', '=', $year)->orderBy('created_at', 'asc')->get();
        $allFeedback = [];
        foreach ($feedbackProducts as $feedbackProduct) {
            $feedback = [
                'systemId' => $feedbackProduct->systemId,
                'customer_name' => ($feedbackProduct->customer == null ? 'Anonymous':$feedbackProduct->customer->name),
                'customer_feedback' => $feedbackProduct->customer_feedback,
                'created_at' => $feedbackProduct->created_at->format('d M Y H:iA')
            ];
            array_push($allFeedback, $feedback);
        }
        return ['allFeedback' => $allFeedback];
    }

    public function getProductCustomerFeedbackMonthly($product_id, $customer_rating, $month, $year) {
        $feedbackProducts = FeedbackProduct::where('productId', '=' ,$product_id)->where('customer_rating', '=', $customer_rating)->whereMonth('created_at', '=', $month)->whereYear('created_at', '=', $year)->orderBy('created_at', 'asc')->get();
        $allFeedback = [];
        foreach ($feedbackProducts as $feedbackProduct) {
            $feedback = [
                'systemId' => $feedbackProduct->systemId,
                'customer_name' => ($feedbackProduct->customer == null ? 'Anonymous':$feedbackProduct->customer->name),
                'customer_feedback' => $feedbackProduct->customer_feedback,
                'created_at' => $feedbackProduct->created_at->format('d M Y H:iA')
            ];
            array_push($allFeedback, $feedback);
        }
        return ['allFeedback' => $allFeedback];
    }

    public function generateSelectedCustomer($feedback_id) {
        $selectOption = array();
        $feedbackProduct = FeedbackProduct::findOrFail($feedback_id);
        if($feedbackProduct->customer != null) {
            $selectedCustomer = $feedbackProduct->customer;
            array_push($selectOption, ['systemId' => utf8_encode($selectedCustomer->systemId), 'name' => utf8_encode($selectedCustomer->name)]);
            return $selectOption;
        } else {
            return null;
        }
    }

    public function filterByProduct($tenant_id, $start_date, $end_date, $product_id) {
        $from = date('Y-m-d H:i:s', strtotime($start_date . ' 00:00:00'));
        $to = date('Y-m-d H:i:s', strtotime($end_date . ' 23:59:59'));

        if($from > $to) {
            $filteredFeedbackProducts = FeedbackProduct::where('tenantId', $tenant_id)->where('productId', $product_id)->whereBetween('created_at', [$to, $from])->orderBy('created_at', 'desc')->paginate(15);
            return new FeedbackProductCollection($filteredFeedbackProducts);
        }

        $filteredFeedbackProducts = FeedbackProduct::where('tenantId', $tenant_id)->where('productId', $product_id)->whereBetween('created_at', [$from, $to])->orderBy('created_at', 'desc')->paginate(15);
        return new FeedbackProductCollection($filteredFeedbackProducts);
//        return ['start_date' => $from, 'end_date' => $to, 'tenant_id' => $tenant_id, 'product_id' => $product_id];
    }

    public function filterByDate($tenant_id, $start_date, $end_date) {
        $from = date('Y-m-d H:i:s', strtotime($start_date . ' 00:00:00'));
        $to = date('Y-m-d H:i:s', strtotime($end_date . ' 23:59:59'));

        if($from > $to) {
            $filteredFeedbackProducts = FeedbackProduct::where('tenantId', $tenant_id)->whereBetween('created_at', [$to, $from])->orderBy('created_at', 'desc')->paginate(15);
            return new FeedbackProductCollection($filteredFeedbackProducts);
        }

        $filteredFeedbackProducts = FeedbackProduct::where('tenantId', $tenant_id)->whereBetween('created_at', [$from, $to])->orderBy('created_at', 'desc')->paginate(15);
        return new FeedbackProductCollection($filteredFeedbackProducts);
    }

    public function updateFeedbackProduct(Request $request) {
        $feedbackProduct = FeedbackProduct::findOrFail($request->feedbackProduct['systemId']);
        $tenant = Tenant::findOrFail($feedbackProduct->tenantId);
        if($request->feedbackProduct['image'] == null) {
            if($feedbackProduct->attachment != null) {
                if(file_exists(public_path($feedbackProduct->attachment))) {
                    unlink(public_path($feedbackProduct->attachment));
                }
            }
            $feedbackProduct->update([
                'customer_rating' => $request->feedbackProduct['rating'],
                'customer_feedback' => $request->feedbackProduct['feedback'],
                'is_need_call' => $request->feedbackProduct['need_call'],
                'is_urgent' => $request->feedbackProduct['is_urgent'],
                'customerId' => $request->feedbackProduct['customer']['systemId'],
                'sysupdater' => $request->updater,
                'attachment' => ($request->feedbackProduct['image'] == null ? null:$request->feedbackProduct['image'])
            ]);

        } else if($request->feedbackProduct['image'] != null){
            if($request->feedbackProduct['fileName'] != null) {
                $file_name = $feedbackProduct->systemId . '_' . $request->feedbackProduct['fileName'];
                if($feedbackProduct->attachment != null) {
                    if(file_exists(public_path($feedbackProduct->attachment))) {
                        unlink(public_path($feedbackProduct->attachment));
                    }
                    InterventionImage::make($request->feedbackProduct['image'])->save(public_path('attachment/' . $tenant->email . '/feedback_product/' . $feedbackProduct->systemId . '/' . $file_name));
                    $feedbackProduct->update([
                        'customer_rating' => $request->feedbackProduct['rating'],
                        'customer_feedback' => $request->feedbackProduct['feedback'],
                        'is_need_call' => $request->feedbackProduct['need_call'],
                        'is_urgent' => $request->feedbackProduct['is_urgent'],
                        'customerId' => $request->feedbackProduct['customer']['systemId'],
                        'sysupdater' => $request->updater,
                        'attachment' => 'attachment/' . $tenant->email . '/feedback_product/' . $feedbackProduct->systemId . '/' . $file_name,
                    ]);
                } else {
                    if(!file_exists(public_path('attachment/' . $tenant->email . '/feedback_product/' . $feedbackProduct->systemId . '/'))) {
                        mkdir(public_path('attachment/' . $tenant->email . '/feedback_product/' . $feedbackProduct->systemId . '/'), 0775, true);
                    }
                    InterventionImage::make($request->feedbackProduct['image'])->save(public_path('attachment/' . $tenant->email . '/feedback_product/' . $feedbackProduct->systemId . '/' . $file_name));
                    $feedbackProduct->update([
                        'customer_rating' => $request->feedbackProduct['rating'],
                        'customer_feedback' => $request->feedbackProduct['feedback'],
                        'is_need_call' => $request->feedbackProduct['need_call'],
                        'is_urgent' => $request->feedbackProduct['is_urgent'],
                        'customerId' => $request->feedbackProduct['customer']['systemId'],
                        'sysupdater' => $request->updater,
                        'attachment' => '/attachment/' . $tenant->email . '/feedback_product/' . $feedbackProduct->systemId . '/' . $file_name
                    ]);
                }
            } else {
                return ['message' => 'success'];
            }
        }
        return ['message' => 'success'];
//        return ['all_request' => $request->all()];
    }

    public function deleteFeedbackProduct(Request $request) {
        $feedbackProduct = FeedbackProduct::findOrFail($request->feedback_id);
        if($feedbackProduct->attachment != null) {
            if(file_exists(public_path($feedbackProduct->attachment))) {
                unlink(public_path($feedbackProduct->attachment));
            }
        }
        $feedbackProduct->delete();

        return ['message' => 'success'];
    }
}
