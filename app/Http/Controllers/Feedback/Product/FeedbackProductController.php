<?php

namespace App\Http\Controllers\Feedback\Product;

use App\FeedbackProduct;
use App\Http\Resources\Feedback\FeedbackProductCollection;
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

    /* API Section */
    public function addFeedbackProduct(Request $request, $tenant_id) {
        $id = Uuid::generate(4);
        $tenant = Tenant::findOrFail($tenant_id);

        if($request->feedbackProduct['image'] != '') {
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
        $feedbackProducts = FeedbackProduct::where('tenantId', $tenant_id)->orderBy('created_at', 'desc')->paginate(15);
        return new FeedbackProductCollection($feedbackProducts);
    }

    public function filterByProduct(Request $request, $tenant_id, $products) {
        $feedbackProducts = FeedbackProduct::where('tenantId', $tenant_id)->whereHas('product', function ($q) use ($products) {
            $q->whereIn('productId', $products);
        })->orderBy('created_at', 'desc')->paginate(15);
        return new FeedbackProductCollection($feedbackProducts);
    }
}
