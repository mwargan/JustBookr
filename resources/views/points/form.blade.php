
<div class="form-group {{ $errors->has('points') ? 'has-error' : '' }}">
    <label for="points" class="col-md-2 control-label">Points</label>
    <div class="col-md-10">
        <input class="form-control" name="points" type="number" id="points" value="{{ old('points', optional($point)->points) }}" min="-2147483648" max="2147483647" required="true" placeholder="Enter points here...">
        {!! $errors->first('points', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('action') ? 'has-error' : '' }}">
    <label for="action" class="col-md-2 control-label">Action</label>
    <div class="col-md-10">
        <input class="form-control" name="action" type="text" id="action" value="{{ old('action', optional($point)->action) }}" maxlength="150" placeholder="Enter action here...">
        {!! $errors->first('action', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('user-id') ? 'has-error' : '' }}">
    <label for="userid" class="col-md-2 control-label">Userid</label>
    <div class="col-md-10">
        <select class="form-control" id="userid" name="user-id" required="true">
        	    <option value="" style="display: none;" {{ old('user-id', optional($point)->{'user-id'} ?: '') == '' ? 'selected' : '' }} disabled selected>Enter userid here...</option>
        	@foreach ($users as $key => $user)
			    <option value="{{ $key }}" {{ old('user-id', optional($point)->{'user-id'}) == $key ? 'selected' : '' }}>
			    	{{ $user }}
			    </option>
			@endforeach
        </select>

        {!! $errors->first('userid', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('timestamp') ? 'has-error' : '' }}">
    <label for="timestamp" class="col-md-2 control-label">Timestamp</label>
    <div class="col-md-10">
        <input class="form-control" name="timestamp" type="text" id="timestamp" value="{{ old('timestamp', optional($point)->timestamp) }}" placeholder="Enter timestamp here...">
        {!! $errors->first('timestamp', '<p class="help-block">:message</p>') !!}
    </div>
</div>

