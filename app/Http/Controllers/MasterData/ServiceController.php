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
use App\Http\Resources\MasterData\Service as ServiceResource;

class ServiceController extends Controller
{
    public function index() {
        return view('master_data.service.service_index');
    }

    public function create() {
        return view('master_data.service.service_add');
    }

    public function edit(Service $service) {
        return view('master_data.service.service_edit', compact('service'));
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

    public function getService($serviceId) {
        $service = Service::findOrFail($serviceId);
        return new ServiceResource($service);
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

    public function updateService(Request $request) {
        $tags = [];
        for($i=0;$i<count($request->service['serviceTags']);$i++) {
            array_push($tags, $request->service['serviceTags'][$i]['systemId']);
        }
        $oldService = Service::findOrFail($request->service['systemId']);
        $oldService->name = $request->service['name'];
        $oldService->description = $request->service['description'];
        $oldService->update();
        $oldService->tags()->sync($tags);
        return ['message' => 'success'];
    }

    public function deleteService(Request $request) {
        $service = Service::findOrFail($request->serviceId);
        if($service->img != null) {
            if(file_exists(public_path($service->img))) {
                unlink(public_path($service->img));
            }
        }
        $service->delete();
        return ['message' => 'success'];
    }

    public function changePicture(Request $request, $service_id) {
        $service = Service::findOrFail($service_id);
        $tenant = Tenant::findOrFail($service->tenantId);
        $fileName = $service->systemId . '_' . $request->fileName;

        if($service->img != null) {
            if(file_exists(public_path($service->img))) {
                unlink(public_path($service->img));
            }
        }

        InterventionImage::make($request->uploadedImage)->save(public_path('uploaded_images/' . $tenant->email . '/' . $fileName));
        $service->img = 'uploaded_images/' . $tenant->email . '/' . $fileName;
        $service->update();
        return ['message' => 'success'];
    }

    public function filterServiceList($tenantId, $tags) {
        $tagIds = explode(',', $tags);

        $filteredServices = Service::where('tenantId', $tenantId)->whereHas('tags', function ($q) use ($tagIds){
            $q->whereIn('systemId', $tagIds);
        })->orderBy('created_at', 'desc')->paginate(24);
        return new ServiceCollection($filteredServices);
    }

    public function filterByName($tenantId, $searchString) {
        $filteredServices = Service::where('tenantId', $tenantId)->where('name', 'LIKE', "%$searchString%")->orderBy('name', 'asc')->paginate(24);
        return new ServiceCollection($filteredServices);
    }
}
