
<div class="form-group {{ $errors->has('user-id') ? 'has-error' : '' }}">
    <label for="userid" class="col-md-2 control-label">Userid</label>
    <div class="col-md-10">
        <select class="form-control" id="userid" name="user-id">
        	    <option value="" style="display: none;" {{ old('user-id', optional($userRating)->{'user-id'} ?: '') == '' ? 'selected' : '' }} disabled selected>Enter userid here...</option>
        	@foreach ($users as $key => $user)
			    <option value="{{ $key }}" {{ old('user-id', optional($userRating)->{'user-id'}) == $key ? 'selected' : '' }}>
			    	{{ $user }}
			    </option>
			@endforeach
        </select>
        {!! $errors->first('user-id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('rating') ? 'has-error' : '' }}">
    <label for="rating" class="col-md-2 control-label">Rating</label>
    <div class="col-md-10">
        <input class="form-control" name="rating" type="number" id="rating" value="{{ old('rating', optional($userRating)->rating) }}" min="-2147483648" max="2147483647" placeholder="Enter rating here...">
        {!! $errors->first('rating', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('timestamp') ? 'has-error' : '' }}">
    <label for="timestamp" class="col-md-2 control-label">Timestamp</label>
    <div class="col-md-10">
        <input class="form-control" name="timestamp" type="text" id="timestamp" value="{{ old('timestamp', optional($userRating)->timestamp) }}" required="true" placeholder="Enter timestamp here...">
        {!! $errors->first('timestamp', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('rated_by') ? 'has-error' : '' }}">
    <label for="rated_by" class="col-md-2 control-label">Rated By</label>
    <div class="col-md-10">
        <select class="form-control" id="rated_by" name="rated_by">
        	    <option value="" style="display: none;" {{ old('rated_by', optional($userRating)->rated_by ?: '') == '' ? 'selected' : '' }} disabled selected>Select rated by</option>
        	@foreach ($users as $key => $user)
                <option value="{{ $key }}" {{ old('user-id', optional($userRating)->rated_by) == $key ? 'selected' : '' }}>
                    {{ $user }}
                </option>
            @endforeach
        </select>

        {!! $errors->first('rated_by', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('comment') ? 'has-error' : '' }}">
    <label for="comment" class="col-md-2 control-label">Comment</label>
    <div class="col-md-10">
        <textarea class="form-control" name="comment" cols="50" rows="10" id="comment" placeholder="Enter comment here...">{{ old('comment', optional($userRating)->comment) }}</textarea>
        {!! $errors->first('comment', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('connect-id') ? 'has-error' : '' }}">
    <label for="connectid" class="col-md-2 control-label">Connectid</label>
    <div class="col-md-10">
        <input class="form-control" name="connect-id" type="number" id="connectid" value="{{ old('connect-id', optional($userRating)->{'connect-id'}) }}" min="-2147483648" max="2147483647" placeholder="Enter connectid here...">
        {!! $errors->first('connect-id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
    <label for="status" class="col-md-2 control-label">Status</label>
    <div class="col-md-10">
        <input class="form-control" name="status" type="number" id="status" value="{{ old('status', optional($userRating)->status) }}" min="-2147483648" max="2147483647" placeholder="Enter status here...">
        {!! $errors->first('status', '<p class="help-block">:message</p>') !!}
    </div>
</div>

