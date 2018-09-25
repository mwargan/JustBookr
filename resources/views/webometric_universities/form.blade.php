
<div class="form-group {{ $errors->has('uni-name') ? 'has-error' : '' }}">
    <label for="uniname" class="col-md-2 control-label">Uniname</label>
    <div class="col-md-10">
        <input class="form-control" name="uni-name" type="text" id="uniname" value="{{ old('uni-name', optional($University)->{'uni-name'}) }}" minlength="1" maxlength="150" required="true" placeholder="Enter uniname here...">
        {!! $errors->first('uni-name', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('en-name') ? 'has-error' : '' }}">
    <label for="enname" class="col-md-2 control-label">Enname</label>
    <div class="col-md-10">
        <input class="form-control" name="en-name" type="text" id="enname" value="{{ old('en-name', optional($University)->{'en-name'}) }}" maxlength="150" placeholder="Enter enname here...">
        {!! $errors->first('en-name', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('abr') ? 'has-error' : '' }}">
    <label for="abr" class="col-md-2 control-label">Abr</label>
    <div class="col-md-10">
        <input class="form-control" name="abr" type="text" id="abr" value="{{ old('abr', optional($University)->abr) }}" maxlength="64" placeholder="Enter abr here...">
        {!! $errors->first('abr', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('country_id') ? 'has-error' : '' }}">
    <label for="country_id" class="col-md-2 control-label">Country</label>
    <div class="col-md-10">
        <select class="form-control" id="country_id" name="country_id" required="true">
        	    <option value="" style="display: none;" {{ old('country_id', optional($University)->country_id ?: '') == '' ? 'selected' : '' }} disabled selected>Enter country here...</option>
        	@foreach ($countries as $key => $country)
			    <option value="{{ $key }}" {{ old('country_id', optional($University)->country_id) == $key ? 'selected' : '' }}>
			    	{{ $country }}
			    </option>
			@endforeach
        </select>

        {!! $errors->first('country_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('city') ? 'has-error' : '' }}">
    <label for="city" class="col-md-2 control-label">City</label>
    <div class="col-md-10">
        <input class="form-control" name="city" type="text" id="city" value="{{ old('city', optional($University)->city) }}" maxlength="64" placeholder="Enter city here...">
        {!! $errors->first('city', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('address') ? 'has-error' : '' }}">
    <label for="address" class="col-md-2 control-label">Address</label>
    <div class="col-md-10">
        <input class="form-control" name="address" type="text" id="address" value="{{ old('address', optional($University)->address) }}" maxlength="259" placeholder="Enter address here...">
        {!! $errors->first('address', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
    <label for="description" class="col-md-2 control-label">Description</label>
    <div class="col-md-10">
        <textarea class="form-control" name="description" cols="50" rows="10" id="description">{{ old('description', optional($University)->description) }}</textarea>
        {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('uni-tel') ? 'has-error' : '' }}">
    <label for="unitel" class="col-md-2 control-label">Unitel</label>
    <div class="col-md-10">
        <input class="form-control" name="uni-tel" type="text" id="unitel" value="{{ old('uni-tel', optional($University)->{'uni-tel'}) }}" maxlength="59" placeholder="Enter unitel here...">
        {!! $errors->first('uni-tel', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('uni-pic') ? 'has-error' : '' }}">
    <label for="unipic" class="col-md-2 control-label">Unipic</label>
    <div class="col-md-10">
        <input class="form-control" name="uni-pic" type="text" id="unipic" value="{{ old('uni-pic', optional($University)->{'uni-pic'}) }}" maxlength="259" placeholder="Enter unipic here...">
        {!! $errors->first('uni-pic', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('uni-logo') ? 'has-error' : '' }}">
    <label for="unilogo" class="col-md-2 control-label">Unilogo</label>
    <div class="col-md-10">
        <input class="form-control" name="uni-logo" type="text" id="unilogo" value="{{ old('uni-logo', optional($University)->{'uni-logo'}) }}" maxlength="259" placeholder="Enter unilogo here...">
        {!! $errors->first('uni-logo', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('uni-lat') ? 'has-error' : '' }}">
    <label for="unilat" class="col-md-2 control-label">Unilat</label>
    <div class="col-md-10">
        <input class="form-control" name="uni-lat" type="number" id="unilat" value="{{ old('uni-lat', optional($University)->{'uni-lat'}) }}" min="-9999" max="9999" placeholder="Enter unilat here..." step="any">
        {!! $errors->first('uni-lat', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('uni-lon') ? 'has-error' : '' }}">
    <label for="unilon" class="col-md-2 control-label">Unilon</label>
    <div class="col-md-10">
        <input class="form-control" name="uni-lon" type="number" id="unilon" value="{{ old('uni-lon', optional($University)->{'uni-lon'}) }}" min="-9999" max="9999" placeholder="Enter unilon here..." step="any">
        {!! $errors->first('uni-lon', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('url') ? 'has-error' : '' }}">
    <label for="url" class="col-md-2 control-label">Url</label>
    <div class="col-md-10">
        <input class="form-control" name="url" type="text" id="url" value="{{ old('url', optional($University)->url) }}" maxlength="150" placeholder="Enter url here...">
        {!! $errors->first('url', '<p class="help-block">:message</p>') !!}
    </div>
</div>

