
<div class="form-group {{ $errors->has('stand_id') ? 'has-error' : '' }}">
    <label for="stand_id" class="col-md-2 control-label">Stand</label>
    <div class="col-md-10">
        <select class="form-control" id="stand_id" name="stand_id">
        	    <option value="" style="display: none;" {{ old('stand_id', optional($standBook)->stand_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select stand</option>
        	@foreach ($stands as $key => $stand)
			    <option value="{{ $key }}" {{ old('stand_id', optional($standBook)->stand_id) == $key ? 'selected' : '' }}>
			    	{{ $stand }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('stand_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('isbn') ? 'has-error' : '' }}">
    <label for="isbn" class="col-md-2 control-label">Isbn</label>
    <div class="col-md-10">
        <input class="form-control" name="isbn" type="text" id="isbn" value="{{ old('isbn', optional($standBook)->isbn) }}" minlength="1" placeholder="Enter isbn here...">
        {!! $errors->first('isbn', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
    <label for="description" class="col-md-2 control-label">Description</label>
    <div class="col-md-10">
        <textarea class="form-control" name="description" cols="50" rows="10" id="description" minlength="1" maxlength="1000">{{ old('description', optional($standBook)->description) }}</textarea>
        {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('price') ? 'has-error' : '' }}">
    <label for="price" class="col-md-2 control-label">Price</label>
    <div class="col-md-10">
        <input class="form-control" name="price" type="text" id="price" value="{{ old('price', optional($standBook)->price) }}" minlength="1" placeholder="Enter price here...">
        {!! $errors->first('price', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('is_active') ? 'has-error' : '' }}">
    <label for="is_active" class="col-md-2 control-label">Is Active</label>
    <div class="col-md-10">
        <div class="checkbox">
            <label for="is_active_1">
            	<input id="is_active_1" class="" name="is_active" type="checkbox" value="1" {{ old('is_active', optional($standBook)->is_active) == '1' ? 'checked' : '' }}>
                Yes
            </label>
        </div>

        {!! $errors->first('is_active', '<p class="help-block">:message</p>') !!}
    </div>
</div>

