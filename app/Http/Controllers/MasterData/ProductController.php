<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Requests\MasterData\ProductRequest;
use App\Http\Resources\MasterData\ProductCollection;
use App\Product;
use App\ProductCategory;
use App\Tag;
use App\Tenant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Http\Resources\MasterData\Product as ProductResource;
use Intervention\Image\ImageManagerStatic as InterventionImage;
use Webpatser\Uuid\Uuid;

class ProductController extends Controller
{
    public function index() {
        $selectOptions = [];
        $tags = Tag::where('recOwner', Auth::user()->tenantId)->orderBy('name', 'asc')->get();
        foreach ($tags as $tag) {
            array_push($selectOptions, ['id' => $tag->systemId, 'name' => $tag->name]);
        }
        return view('master_data.product.product_index', compact('selectOptions'));
    }

    public function create() {
        $selectTags = Tag::where('recOwner', Auth::user()->tenantId)->pluck('name', 'systemId');
        return view('master_data.product.product_add', compact('selectTags'));
    }


    public function show(Product $product) {
        $productCategories = ProductCategory::where('productId', $product->systemId)->where('parent_id', null)->get();
        $hasCategory = false;
        if(count($productCategories) > 0) {
            $hasCategory = true;
        }
        $productTags = $product->tags;

        return view('master_data.product.product_show', compact('product', 'hasCategory', 'productTags'));
    }

    public function edit(Product $product) {
        return view('master_data.product.product_edit', compact('product', 'selectTags', 'selectedTags'));
    }

    /* API Section */
    public function addProduct(Request $request) {
        $tags = [];
        $uploadedImage = $request->product['image'];
        $id = Uuid::generate(4);
        $tenant = Tenant::findOrFail($request->tenantId);
        $fileName = $id . '_' . $request->fileName;
        for($i=0;$i<count($request->product['tags']);$i++) {
            array_push($tags, $request->product['tags'][$i]['systemId']);
        }

        if($uploadedImage != '') {
            InterventionImage::make($uploadedImage)->save(public_path('uploaded_images/' . $tenant->email . '/' . $fileName), 50);
            $newProduct = Product::create([
                'systemId' => $id,
                'name' => $request->product['name'],
                'description' => $request->product['description'],
                'img' => '/uploaded_images/' . $tenant->email . '/' . $fileName,
                'tenantId' => $request->tenantId
            ]);

            ProductCategory::create([
                'name' => 'General',
                'productId' => $newProduct->systemId
            ]);

            $newProduct->tags()->sync($tags);
            return ['message' => 'success'];
        } else if($uploadedImage == '') {
            $newProduct = Product::create([
                'systemId' => $id,
                'name' => $request->product['name'],
                'description' => $request->product['description'],
                'tenantId' => $request->tenantId
            ]);

            ProductCategory::create([
                'name' => 'General',
                'productId' => $newProduct->systemId
            ]);

            $newProduct->tags()->sync($tags);
            return ['message' => 'success'];
        } else {
            return ['message' => 'error!'];
        }
    }

    public function getProduct(Request $request, $productId) {
        $product = Product::findOrFail($productId);
        return new ProductResource($product);
    }

    public function deleteProduct(Request $request) {
        $product = Product::findOrFail($request->productId);
        if($product->img != null) {
            if(file_exists(public_path($product->img))) {
                unlink(public_path($product->img));
            }
        }
        $product->delete();
        return ['message' => 'success'];
    }

    public function updateProduct(Request $request) {
        $tags = [];
        for($i=0;$i<count($request->product['productTags']);$i++) {
            array_push($tags, $request->product['productTags'][$i]['systemId']);
        }
        $oldProduct = Product::findOrFail($request->product['systemId']);
        $oldProduct->name = $request->product['name'];
        $oldProduct->description = $request->product['description'];
        $oldProduct->update();
        $oldProduct->tags()->sync($tags);
        return ['message' => 'success'];
    }

    public function changePicture(Request $request, $product_id) {
        $product = Product::findOrFail($product_id);
        $tenant = Tenant::findOrFail($product->tenantId);
        $fileName = $product->systemId . '_' . $request->fileName;

        if($product->img != null) {
            if(file_exists(public_path($product->img))) {
                unlink(public_path($product->img));
            }
        }

        InterventionImage::make($request->uploadedImage)->save(public_path('uploaded_images/' . $tenant->email . '/' . $fileName));
        $product->img = 'uploaded_images/' . $tenant->email . '/' . $fileName;
        $product->update();
        return ['message' => 'success'];
    }

    public function getProductList(Request $request, $tenant_id) {
        $products = Product::where('tenantId', $tenant_id)->orderBy('created_at', 'desc')->paginate(15);
        return new ProductCollection($products);
    }

    public function filterProductList(Request $request, $tenant_id, $tags) {
        $tagIds = explode(',', $tags);

        $filteredProducts = Product::where('tenantId', $tenant_id)->whereHas('tags', function ($q) use ($tagIds){
            $q->whereIn('systemId', $tagIds);
        })->orderBy('created_at', 'desc')->paginate(24);
        return new ProductCollection($filteredProducts);
    }

    public function filterByName(Request $request, $tenant_id, $searchString) {
        $filteredProducts = Product::where('tenantId', $tenant_id)->where('name', 'LIKE', "%$searchString%")->orderBy('name', 'asc')->paginate(24);
        return new ProductCollection($filteredProducts);
    }

    public function generateSelectProduct(Request $request, $tenant_id) {
        $selectOption = array();
        $selectProducts = Product::where('tenantId', $tenant_id)->orderBy('name', 'asc')->get();
        foreach ($selectProducts as $selectProduct) {
            array_push($selectOption, ['systemId' => $selectProduct->systemId, 'name' => $selectProduct->name]);
        }
        return $selectOption;
    }
}
