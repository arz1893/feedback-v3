<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Resources\MasterData\ServiceCollection;
use App\Service;
use App\ServiceCategory;
use App\Tenant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Webpatser\Uuid\Uuid;
use Intervention\Image\ImageManagerStatic as InterventionImage;

class ServiceController extends Controller
{
    public function index() {
        return view('master_data.service.service_index');
    }

    public function create() {
        return view('master_data.service.service_add');
    }

    public function show(Service $service) {
        $serviceCategories = ServiceCategory::where('serviceId', $service->systemId)->where('parent_id', null)->get();

        $hasCategory = false;
        if(count($serviceCategories) > 0) {
            $hasCategory = true;
        }
        $serviceTags = $service->tags;
        return view('master_data.service.service_show', compact('service', 'serviceTags', 'hasCategory'));
    }

    /* API Section */
    public function getServiceList($tenant_id) {
        $services = Service::where('tenantId', $tenant_id)->orderBy('created_at', 'desc')->paginate(24);
        return new ServiceCollection($services);
    }

    public function addService(Request $request) {
        $tags = [];
        $uploadedImage = $request->service['image'];
        $id = Uuid::generate(4);
        $tenant = Tenant::findOrFail($request->tenantId);
        $fileName = $id . '_' . $request->fileName;
        for($i=0;$i<count($request->service['tags']);$i++) {
            array_push($tags, $request->service['tags'][$i]['systemId']);
        }

        if($uploadedImage != '') {
            InterventionImage::make($uploadedImage)->save(public_path('uploaded_images/' . $tenant->email . '/' . $fileName));
            $newService = Service::create([
                'systemId' => $id,
                'name' => $request->service['name'],
                'description' => $request->service['description'],
                'img' => '/uploaded_images/' . $tenant->email . '/' . $fileName,
                'tenantId' => $request->tenantId
            ]);

            ServiceCategory::create([
                'name' => 'General',
                'serviceId' => $newService->systemId
            ]);

            $newService->tags()->sync($tags);
            return ['message' => 'success'];
        } else if($uploadedImage == '') {
            $newService = Service::create([
                'systemId' => $id,
                'name' => $request->service['name'],
                'description' => $request->service['description'],
                'tenantId' => $request->tenantId
            ]);

            ServiceCategory::create([
                'name' => 'General',
                'serviceId' => $newService->systemId
            ]);

            $newService->tags()->sync($tags);
            return ['message' => 'success'];
        } else {
            return ['message' => 'error!'];
        }
    }
}
