<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Requests\MasterData\TagRequest;
use App\Http\Resources\MasterData\TagCollection;
use App\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Webpatser\Uuid\Uuid;

class TagController extends Controller
{
    public function index() {
        return view('master_data.tag.tag_index');
    }

    public function create() {
        return view('master_data.tag.tag_add');
    }

    public function store(TagRequest $request) {
        Tag::create([
            'systemId' => Uuid::generate(4),
            'name' => $request->name,
            'defValue' => $request->defValue,
            'bgColor' => $request->bgColor,
            'recOwner' => Auth::user()->tenantId,
            'syscreator' => Auth::user()->systemId
        ]);
        return redirect('tag')->with(['status' => 'A new tag has been added']);
    }

    public function edit(Tag $tag) {
        return view('master_data.tag.tag_edit', compact('tag'));
    }

    public function update(TagRequest $request, Tag $tag) {
        $tag->update($request->all());
        return redirect('tag')->with(['status' => 'Tag has been updated']);
    }

    public function deleteTag(Request $request) {
        $tag = Tag::findOrFail($request->tag_id);
        $tag->delete();
        return redirect('tag')->with(['status' => 'Tag has been deleted']);
    }

    /* API Section */
    public function addTag(Request $request) {
        Tag::create([
            'systemId' => Uuid::generate(4),
            'name' => $request->tag['name'],
            'defValue' => $request->tag['defValue'],
            'bgColor' => $request->tag['bgColor'],
            'recOwner' => $request->tenantId,
            'syscreator' => $request->syscreator
        ]);
        return ['message' => 'success'];
    }

    public function getTagList($tenant_id) {
        $tags = Tag::where('recOwner', $tenant_id)->orderBy('name', 'asc')->paginate(15);
        return new TagCollection($tags);
    }

    public function generateSelectTag($tenant_id) {
        $selectOption = array();
        $tags = Tag::where('recOwner', $tenant_id)->orderBy('name', 'asc')->get();

        foreach ($tags as $tag) {
            array_push($selectOption, ['systemId' => $tag->systemId, 'name' => $tag->name]);
        }
        return $selectOption;
    }
}
