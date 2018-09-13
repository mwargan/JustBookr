
<div class="form-group {{ $errors->has('business_id') ? 'has-error' : '' }}">
    <label for="business_id" class="col-md-2 control-label">Business</label>
    <div class="col-md-10">
        <select class="form-control" id="business_id" name="business_id">
        	    <option value="" style="display: none;" {{ old('business_id', optional($businessStand)->business_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select business</option>
        	@foreach ($businesses as $key => $business)
			    <option value="{{ $key }}" {{ old('business_id', optional($businessStand)->business_id) == $key ? 'selected' : '' }}>
			    	{{ $business }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('business_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('uni_id') ? 'has-error' : '' }}">
    <label for="uni_id" class="col-md-2 control-label">Uni</label>
    <div class="col-md-10">
        <select class="form-control" id="uni_id" name="uni_id">
        	    <option value="" style="display: none;" {{ old('uni_id', optional($businessStand)->uni_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select uni</option>
        	@foreach ($unis as $key => $uni)
			    <option value="{{ $key }}" {{ old('uni_id', optional($businessStand)->uni_id) == $key ? 'selected' : '' }}>
			    	{{ $uni }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('uni_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('stand_text') ? 'has-error' : '' }}">
    <label for="stand_text" class="col-md-2 control-label">Stand Text</label>
    <div class="col-md-10">
        <input class="form-control" name="stand_text" type="text" id="stand_text" value="{{ old('stand_text', optional($businessStand)->stand_text) }}" minlength="1" placeholder="Enter stand text here...">
        {!! $errors->first('stand_text', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('location') ? 'has-error' : '' }}">
    <label for="location" class="col-md-2 control-label">Location</label>
    <div class="col-md-10">
        <input class="form-control" name="location" type="text" id="location" value="{{ old('location', optional($businessStand)->location) }}" minlength="1" placeholder="Enter location here...">
        {!! $errors->first('location', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('active') ? 'has-error' : '' }}">
    <label for="active" class="col-md-2 control-label">Active</label>
    <div class="col-md-10">
        <input class="form-control" name="active" type="text" id="active" value="{{ old('active', optional($businessStand)->active) }}" minlength="1" placeholder="Enter active here...">
        {!! $errors->first('active', '<p class="help-block">:message</p>') !!}
    </div>
</div>

