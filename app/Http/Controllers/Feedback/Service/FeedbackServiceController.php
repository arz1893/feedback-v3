<?php

namespace App\Http\Controllers\Feedback\Service;

use App\ComplaintService;
use App\FeedbackService;
use App\Http\Resources\Feedback\FeedbackServiceCollection;
use App\Service;
use App\Tenant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Webpatser\Uuid\Uuid;
use Intervention\Image\ImageManagerStatic as InterventionImage;


class FeedbackServiceController extends Controller
{
    public function index() {
        return view('feedback.service.feedback_service_index');
    }

    public function show($service_id) {
        $service = Service::findOrFail($service_id);
        return view('feedback.service.feedback_service_show', compact('service'));
    }

    /* API Section */
    public function addFeedbackService(Request $request, $tenant_id) {
        $id = Uuid::generate(4);
        $tenant = Tenant::findOrFail($tenant_id);

        if($request->feedbackService['image'] != '') {
            $file_name = $id . '_' . $request->feedbackService['fileName'];
            if(!file_exists(public_path('attachment/' . $tenant->email . '/feedback_service/' . $id . '/'))) {
                mkdir(public_path('attachment/' . $tenant->email . '/feedback_service/' . $id . '/'), 0775, true);
            }
            InterventionImage::make($request->feedbackService['image'])->save(public_path('attachment/' . $tenant->email . '/feedback_service/' . $id . '/' . $file_name));
            FeedbackService::create([
                'systemId' => $id,
                'customer_rating' => $request->feedbackService['rating'],
                'customer_feedback' => $request->feedbackService['feedback'],
                'is_need_call' => $request->feedbackService['need_call'],
                'is_urgent' => $request->feedbackService['is_urgent'],
                'customerId' => $request->feedbackService['customer']['systemId'],
                'serviceId' => $request->serviceId,
                'serviceCategoryId' => $request->serviceCategoryId,
                'tenantId' => $tenant_id,
                'attachment' => 'attachment/' . $tenant->email . '/feedback_service/' . $id . '/' . $file_name,
                'syscreator' => $request->creator
            ]);
        } else {
            FeedbackService::create([
                'systemId' => $id,
                'customer_rating' => $request->feedbackService['rating'],
                'customer_feedback' => $request->feedbackService['feedback'],
                'is_need_call' => $request->feedbackService['need_call'],
                'is_urgent' => $request->feedbackService['is_urgent'],
                'customerId' => $request->feedbackService['customer']['systemId'],
                'serviceId' => $request->serviceId,
                'serviceCategoryId' => $request->serviceCategoryId,
                'tenantId' => $tenant_id,
                'syscreator' => $request->creator
            ]);
        }

        return ['message' => 'success'];
    }

    public function getFeedbackServiceList($tenant_id){
        $from = date('Y-m-d 00:00:00');
        $to = date('Y-m-d H:i:s');
        $feedbackServices = FeedbackService::where('tenantId', $tenant_id)->whereBetween('created_at', [$from, $to])->orderBy('created_at', 'desc')->paginate(15);
        return new FeedbackServiceCollection($feedbackServices);
    }

    public function getFeedbackService($feedback_id) {
        $feedbackService = FeedbackService::findOrFail($feedback_id);
        return new FeedbackServiceCollection($feedbackService);
    }

    public function filterByService(Request $request, $tenant_id, $service_id) {
        $filteredFeedbackServices = FeedbackService::where('tenantId', $tenant_id)->where('serviceId', $service_id)->orderBy('created_at', 'desc')->paginate(15);
        return new FeedbackServiceCollection($filteredFeedbackServices);
    }

    public function filterByDate($tenant_id, $start_date, $end_date) {
        $from = date('Y-m-d H:i:s', strtotime($start_date . ' 00:00:00'));
        $to = date('Y-m-d H:i:s', strtotime($end_date . ' 23:59:59'));

        if($from > $to) {
            $filteredFeedbackServices = FeedbackService::where('tenantId', $tenant_id)->whereDate('created_at', [$to, $from])->orderBy('created_at', 'desc')->paginate(15);
            return new FeedbackServiceCollection($filteredFeedbackServices);
        }

        $filteredFeedbackServices = FeedbackService::where('tenantId', $tenant_id)->whereBetween('created_at', [$from, $to])->orderBy('created_at', 'desc')->paginate(15);
        return new FeedbackServiceCollection($filteredFeedbackServices);
    }
}
