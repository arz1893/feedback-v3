<?php

namespace App\Http\Controllers\FAQ;

use App\FaqProduct;
use App\Http\Requests\FAQ\FAQProductRequest;
use App\Http\Resources\FAQ\FAQProductCollection;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Webpatser\Uuid\Uuid;
use App\Http\Resources\FAQ\FAQProduct as FaqProductResource;

class FAQProductController extends Controller
{
    public function index() {
        return view('faq.product.faq_product_index');
    }

    public function show($product_id) {
        $product = Product::findOrFail($product_id);
        return view('faq.product.faq_product_show', compact('product'));
    }

    /* API Section */
    public function getFaqProducts($product_id) {
        $faqProducts = FaqProduct::where('productId', $product_id)->orderBy('created_at', 'asc')->get();
        return new FAQProductCollection($faqProducts);
    }

    public function getFaqProduct($faq_id) {
        $faqProduct = FaqProduct::findOrFail($faq_id);
        return new FaqProductResource($faqProduct);
    }

    public function addFaqProduct(Request $request) {
        FaqProduct::create([
            'systemId' => Uuid::generate(4),
            'question' => $request->faqProduct['question'],
            'answer' => $request->faqProduct['answer'],
            'productId' => $request->productId,
            'syscreator' => $request->user
        ]);
        return ['message' => 'success'];
    }

    public function updateFaqProduct(Request $request) {
        $faqProduct = FaqProduct::findOrFail($request->faqProduct['systemId']);
        $faqProduct->update([
            'question' => $request->faqProduct['question'],
            'answer' => $request->faqProduct['answer'],
            'syslastupdater' => $request->user,
        ]);
        return ['message' => 'success'];
    }

    public function deleteFaqProduct(Request $request) {
        $faqProduct = FaqProduct::findOrFail($request->faqId);
        $faqProduct->delete();
        return ['message' => 'success'];
    }
}
