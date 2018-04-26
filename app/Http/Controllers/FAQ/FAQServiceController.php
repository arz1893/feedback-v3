<?php

namespace App\Http\Controllers\FAQ;

use App\FaqService;
use App\Http\Resources\FAQ\FAQServiceCollection;
use App\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Webpatser\Uuid\Uuid;

class FAQServiceController extends Controller
{
    function index() {
        return view('faq.service.faq_service_index');
    }

    function show($service_id) {
        $service = Service::findOrFail($service_id);
        return view('faq.service.faq_service_show', compact('service'));
    }

    /* API Section */
    public function getFaqServices($service_id) {
        $faqServices = FaqService::where('serviceId', $service_id)->orderBy('created_at', 'asc')->get();
        return new FAQServiceCollection($faqServices);
    }

    public function getFaqService($faq_id) {
        $faqService = FaqService::findOrFail($faq_id);
        return new FAQServiceCollection($faqService);
    }

    public function addFaqService(Request $request) {
        FaqService::create([
            'systemId' => Uuid::generate(4),
            'question' => $request->faqService['question'],
            'answer' => $request->faqService['answer'],
            'serviceId' => $request->serviceId,
            'syscreator' => $request->user
        ]);
        return ['message' => 'success'];
    }

    public function updateFaqService(Request $request) {
        $faqService = FaqService::findOrFail($request->faqService['systemId']);
        $faqService->update([
            'question' => $request->faqService['question'],
            'answer' => $request->faqService['answer'],
            'syslastupdater' => $request->user,
        ]);
        return ['message' => 'success'];
    }

    public function deleteFaqService(Request $request) {
        $faqService = FaqService::findOrFail($request->faqId);
        $faqService->delete();
        return ['message' => 'success'];
    }
}
