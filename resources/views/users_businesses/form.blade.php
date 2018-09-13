
<div class="form-group {{ $errors->has('business_id') ? 'has-error' : '' }}">
    <label for="business_id" class="col-md-2 control-label">Business</label>
    <div class="col-md-10">
        <select class="form-control" id="business_id" name="business_id">
        	    <option value="" style="display: none;" {{ old('business_id', optional($usersBusiness)->business_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select business</option>
        	@foreach ($businesses as $key => $business)
			    <option value="{{ $key }}" {{ old('business_id', optional($usersBusiness)->business_id) == $key ? 'selected' : '' }}>
			    	{{ $business }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('business_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('user_id') ? 'has-error' : '' }}">
    <label for="user_id" class="col-md-2 control-label">User</label>
    <div class="col-md-10">
        <select class="form-control" id="user_id" name="user_id">
        	    <option value="" style="display: none;" {{ old('user_id', optional($usersBusiness)->user_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select user</option>
        	@foreach ($users as $key => $user)
			    <option value="{{ $key }}" {{ old('user_id', optional($usersBusiness)->user_id) == $key ? 'selected' : '' }}>
			    	{{ $user }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('user_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('is_admin') ? 'has-error' : '' }}">
    <label for="is_admin" class="col-md-2 control-label">Is Admin</label>
    <div class="col-md-10">
        <div class="checkbox">
            <label for="is_admin_1">
            	<input id="is_admin_1" class="" name="is_admin" type="checkbox" value="1" {{ old('is_admin', optional($usersBusiness)->is_admin) == '1' ? 'checked' : '' }}>
                Yes
            </label>
        </div>

        {!! $errors->first('is_admin', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('is_active') ? 'has-error' : '' }}">
    <label for="is_active" class="col-md-2 control-label">Is Active</label>
    <div class="col-md-10">
        <div class="checkbox">
            <label for="is_active_1">
            	<input id="is_active_1" class="" name="is_active" type="checkbox" value="1" {{ old('is_active', optional($usersBusiness)->is_active) == '1' ? 'checked' : '' }}>
                Yes
            </label>
        </div>

        {!! $errors->first('is_active', '<p class="help-block">:message</p>') !!}
    </div>
</div>

