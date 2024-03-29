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
use App\Http\Resources\Feedback\FeedbackService as FeedbackServiceResource;
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

    public function portDatabase() {
        $complaintServices = ComplaintService::all();
        foreach ($complaintServices as $complaintService) {
            if($complaintService->customer_rating < 3) {
                $complaintService->customer_rating = 1;
                $complaintService->update();
            } else if($complaintService->customer_rating == 3) {
                $complaintService->customer_rating = 2;
                $complaintService->update();
            } else if($complaintService->customer_rating > 3) {
                $complaintService->customer_rating = 3;
                $complaintService->update();
            }
        }
        foreach ($complaintServices as $complaintService) {
            FeedbackService::create([
                'systemId' => $complaintService->systemId,
                'customer_rating' => $complaintService->customer_rating,
                'customer_feedback' => $complaintService->customer_complaint,
                'is_need_call' => $complaintService->is_need_call,
                'is_urgent' => $complaintService->is_urgent,
                'serviceId' => $complaintService->serviceId,
                'serviceCategoryId' => $complaintService->serviceCategoryId,
                'tenantId' => $complaintService->tenantId,
                'is_answered' => $complaintService->is_answered,
                'attachment' => $complaintService->attachment,
                'syscreator' => $complaintService->syscreator,
                'sysupdater' => $complaintService->sysupdater,
                'created_at' => $complaintService->created_at,
                'updated_at' => $complaintService->updated_at,
            ]);
        }
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
        return new FeedbackServiceResource($feedbackService);
    }

    public function generateSelectedCustomer($feedback_id) {
        $selectOption = array();
        $feedbackService = FeedbackService::findOrFail($feedback_id);
        if($feedbackService->customer != null) {
            $selectedCustomer = $feedbackService->customer;
            array_push($selectOption, ['systemId' => utf8_encode($selectedCustomer->systemId), 'name' => utf8_encode($selectedCustomer->name)]);
            return $selectOption;
        } else {
            return null;
        }
    }

    public function getServiceCustomerFeedbackYearly($service_id, $customer_rating, $year) {
        $feedbackServices = FeedbackService::where('serviceId', '=', $service_id)->where('customer_rating', '=', $customer_rating)->whereYear('created_at', '=', $year)->orderBy('created_at', 'asc')->get();
        $allFeedback = [];
        foreach ($feedbackServices as $feedbackService) {
            $feedback = [
                'systemId' => $feedbackService->systemId,
                'customer_name' => ($feedbackService->customer == null ? 'Anonymous':$feedbackService->customer->name),
                'customer_feedback' => $feedbackService->customer_feedback,
                'created_at' => $feedbackService->created_at->format('d M Y H:iA'),
            ];
            array_push($allFeedback, $feedback);
        }
        return ['allFeedback' => $allFeedback];
    }

    public function getServiceCustomerFeedbackMonthly($service_id, $customer_rating, $month, $year) {
        $feedbackServices = FeedbackService::where('serviceId', '=', $service_id)->where('customer_rating', '=', $customer_rating)->whereMonth('created_at', '=', $month)->whereYear('created_at', '=', $year)->orderBy('created_at', 'asc')->get();
        $allFeedback = [];
        foreach ($feedbackServices as $feedbackService) {
            $feedback = [
                'systemId' => $feedbackService->systemId,
                'customer_name' => ($feedbackService->customer == null ? 'Anonymous':$feedbackService->customer->name),
                'customer_feedback' => $feedbackService->customer_feedback,
                'created_at' => $feedbackService->created_at->format('d M Y H:iA'),
            ];
            array_push($allFeedback, $feedback);
        }
        return ['allFeedback' => $allFeedback];
    }

    public function filterByService($tenant_id, $start_date, $end_date, $service_id) {
        $from = date('Y-m-d H:i:s', strtotime($start_date . ' 00:00:00'));
        $to = date('Y-m-d H:i:s', strtotime($end_date . ' 23:59:59'));

        if($from > $to) {
            $filteredFeedbackServices = FeedbackService::where('tenantId', $tenant_id)->where('serviceId', $service_id)->whereBetween('created_at', [$to, $from])->orderBy('created_at', 'desc')->paginate(15);
            return new FeedbackServiceCollection($filteredFeedbackServices);
        }

        $filteredFeedbackServices = FeedbackService::where('tenantId', $tenant_id)->where('serviceId', $service_id)->whereBetween('created_at', [$from, $to])->orderBy('created_at', 'desc')->paginate(15);
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

    public function updateFeedbackService(Request $request) {
        $feedbackService = FeedbackService::findOrFail($request->feedbackService['systemId']);
        $tenant = Tenant::findOrFail($feedbackService->tenantId);
        if($request->feedbackService['image'] == null) {
            if($feedbackService->attachment != null) {
                if(file_exists(public_path($feedbackService->attachment))) {
                    unlink(public_path($feedbackService->attachment));
                }
            }
            $feedbackService->update([
                'customer_rating' => $request->feedbackService['rating'],
                'customer_feedback' => $request->feedbackService['feedback'],
                'is_need_call' => $request->feedbackService['need_call'],
                'is_urgent' => $request->feedbackService['is_urgent'],
                'customerId' => $request->feedbackService['customer']['systemId'],
                'sysupdater' => $request->updater,
                'attachment' => ($request->feedbackService['image'] == '' ? null:$request->feedbackService['image'])
            ]);

        } else if($request->feedbackService['image'] != null) {
            if($request->feedbackService['fileName'] != null) {
                $file_name = $feedbackService->systemId . '_' . $request->$feedbackService['fileName'];
                if($feedbackService->attachment != null) {
                    if(file_exists(public_path($feedbackService->attachment))) {
                        unlink(public_path($feedbackService->attachment));
                    }
                    InterventionImage::make($request->feedbackService['image'])->save(public_path('attachment/' . $tenant->email . '/feedback_service/' . $feedbackService->systemId . '/' . $file_name));
                    $feedbackService->update([
                        'customer_rating' => $request->feedbackService['rating'],
                        'customer_feedback' => $request->feedbackService['feedback'],
                        'is_need_call' => $request->feedbackService['need_call'],
                        'is_urgent' => $request->feedbackService['is_urgent'],
                        'customerId' => $request->feedbackService['customer']['systemId'],
                        'sysupdater' => $request->updater,
                        'attachment' => 'attachment/' . $tenant->email . '/feedback_service/' . $feedbackService->systemId . '/' . $file_name,
                    ]);
                } else {
                    if(!file_exists(public_path('attachment/' . $tenant->email . '/feedback_service/' . $feedbackService->systemId . '/'))) {
                        mkdir(public_path('attachment/' . $tenant->email . '/feedback_service/' . $feedbackService->systemId . '/'), 0775, true);
                    }
                    InterventionImage::make($request->feedbackService['image'])->save(public_path('attachment/' . $tenant->email . '/feedback_service/' . $feedbackService->systemId . '/' . $file_name));
                    $feedbackService->update([
                        'customer_rating' => $request->feedbackService['rating'],
                        'customer_feedback' => $request->feedbackService['feedback'],
                        'is_need_call' => $request->feedbackService['need_call'],
                        'is_urgent' => $request->feedbackService['is_urgent'],
                        'customerId' => $request->feedbackService['customer']['systemId'],
                        'sysupdater' => $request->updater,
                        'attachment' => '/attachment/' . $tenant->email . '/feedback_service/' . $feedbackService->systemId . '/' . $file_name
                    ]);
                }
            } else {
                return ['message' => 'success'];
            }
        }
        return ['message' => 'success'];
//        return ['all_request' => $request->all()];
    }

    public function deleteFeedbackService(Request $request) {
        $feedbackService = FeedbackService::findOrFail($request->feedback_id);
        if($feedbackService->attachment != null) {
            if(file_exists(public_path($feedbackService->attachment))) {
                unlink(public_path($feedbackService->attachment));
            }
        }
        $feedbackService->delete();
        return ['message' => 'success'];
    }
}
