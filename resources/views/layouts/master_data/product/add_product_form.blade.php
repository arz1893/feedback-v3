<div class="col-md-6 col-md-offset-3">
    <div class="form-group">
        {{ Form::label('name', 'Name', ['class' => 'control-label']) }}
        {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Enter Your Product Name']) }}
    </div>

    <div class="form-group">
        {{ Form::label('description', 'Description',['class' => 'control-label']) }}
        <textarea name="description" id="description" class="form-control" rows="6" placeholder="Enter your product's description"></textarea>
    </div>

    <div class="form-group">
        {{ Form::label('tags', 'Select tag') }}
        {{ Form::select('tags[]', $selectTags, null, ['class' => 'form-control select2-tag', 'multiple' => true, 'data-placeholder' => 'Select Tag...']) }}
    </div>

    <div class="form-group">
        <label for="image_cover">Choose image</label>
        <input type="file" accept="image/*" class="form-control-file" name="image_cover" id="image_cover" aria-describedby="fileHelp" v-on:change='previewImage($event)'>
        <small id="fileHelp" class="form-text text-muted">Choose your product's image</small>
    </div>

    <div class="form-group" v-if="showAttachment" style="width: 180px;">
        <span class="mailbox-attachment-icon has-img"><img src="" id="preview"></span>

        <div class="mailbox-attachment-info">
            <a @click="clearAttachment($event)" class="btn btn-danger btn-xs pull-right" data-toggle="tooltip" data-placement="bottom" title="delete attachment">
                <i class="fa fa-close"></i>
            </a>
            <a class="mailbox-attachment-name"><i class="fa fa-camera"></i> image</a>
        </div>
    </div>

    <div class="form-group">
        <button type="submit" class="btn btn-primary">
            <i class="fa fa-plus"></i> Add Product
        </button>
    </div>

</div>