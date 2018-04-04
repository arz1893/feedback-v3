<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Resources\MasterData\ProductCategoryCollection;
use App\ProductCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ProductCategoryController extends Controller
{
    public function store(Request $request) {
        $rules = [
            'name' => 'required',
        ];
        $messages = [
            'name.required' => 'Please enter category name'
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if($request->category_type == 'root') {
            ProductCategory::create([
                'name' => $request->name,
                'productId' => $request->product_id
            ]);
            return redirect()->back()->with('status', 'Category has been added');
        } else if($request->category_type == 'sub') {
            $parent = ProductCategory::findOrFail($request->parent_id);
            $child = ProductCategory::create([
                'name' => $request->name
            ]);
            $child->makeChildOf($parent);
            return redirect()->back()->with('status', 'Category has been added');
        }
        return redirect('master_product.show', $request->product_id);
    }

    public function updateProductCategory(Request $request) {
        $rules = [
            'name' => 'required'
        ];

        $messages = [
            'name.required' => 'Please enter category name'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $category = ProductCategory::findOrFail($request->node_key);
        $category->name = $request->name;
        $category->update();
        return redirect()->back()->with('status', 'Category has been updated');
    }

    public function deleteProductCategory(Request $request) {
        $productCategory = ProductCategory::findOrFail($request->node_key);
        $productCategory->delete();
        return redirect()->back()->with('status', 'Category has been deleted');
    }

    public function getCategory(Request $request){
        if($request->json()) {
            $productCategory = ProductCategory::findOrFail($request->node_id);
            return response()->json($productCategory, 200);
        }
        return redirect()->back();
    }


    public function getTrees(Request $request) {
        if($request->json()) {
            $productCategories = ProductCategory::where('productId', $request->product_id)->get();
            $data = [];
            foreach ($productCategories as $productCategory) {
                $data[] = [
                    'title' => $productCategory->name,
                    'key' => $productCategory->id,
                    'folder' => true,
                    'lazy' => true
                ];
            }
            return response()->json($data, 200);
        }
        return redirect()->back();
    }

    public function getChilds(Request $request) {
        if($request->json()) {
            $childs = ProductCategory::where('parent_id', $request->parent_id)->get();
            $data = [];
            foreach ($childs as $child) {
                $data[] = [
                    'title' => $child->name,
                    'key' => $child->id,
                    'folder' => true,
                    'lazy' => true
                ];
            }
            return response()->json($data, 200);
        }
        return redirect()->back();
    }

    public function addParentNode(Request $request) {
        if($request->json()) {
            $parent = ProductCategory::create([
                'name' => $request->category_name,
                'productId' => $request->product_id
            ]);
            return response()->json($parent, 200);
        }
        return redirect()->back();
    }

    public function addChildNode(Request $request) {
        if($request->json()) {
            $parent = ProductCategory::findOrFail($request->parent_id);
            $child = ProductCategory::create([
                'name' => $request->name
            ]);
            $child->makeChildOf($parent);
            return response()->json($child, 200);
        }
        return redirect()->back();
    }

    public function renameNode(Request $request) {
        if($request->json()) {
            $node = ProductCategory::findOrFail($request->node_key);
            $node->name = $request->name;
            $node->update();
            return response()->json(['status' => 'success'], 200);
        }
        return redirect()->back();
    }

    public function removeNode(Request $request) {
        if($request->json()) {
            $node = ProductCategory::findOrFail($request->node_id);
            $node->delete();
            return response()->json(['status' => 'success'], 200);
        }
        return redirect()->back();
    }

    /* API Section */
    public function getRootNodes(Request $request, $product_id) {
        $productCategories = ProductCategory::where('productId', $product_id)->orderBy('name', 'asc')->get();
        return new ProductCategoryCollection($productCategories);
    }

    public function getParentNodes(Request $request, $node_id) {
        $currentNode = ProductCategory::findOrFail($node_id);
        if($currentNode->parent_id == null) {
            $parentNodes = ProductCategory::where('productId', $currentNode->productId)->orderBy('name', 'asc')->get();
            return new ProductCategoryCollection($parentNodes);
        } else {
            $parentNodes = ProductCategory::where('parent_id', $currentNode->parent_id)->orderBy('name', 'asc')->get();
            return new ProductCategoryCollection($parentNodes);
        }
    }

    public function getChildNodes(Request $request, $parent_id) {
        $childNodes = ProductCategory::where('parent_id', $parent_id)->orderBy('name', 'asc')->get();
        return new ProductCategoryCollection($childNodes);
    }
}
