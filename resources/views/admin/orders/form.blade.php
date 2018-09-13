
<div class="form-group {{ $errors->has('user-id-sell') ? 'has-error' : '' }}">
    <label for="useridsell" class="col-md-2 control-label">Seller</label>
    <div class="col-md-10">
        <select class="form-control" id="useridsell" name="user-id-sell" required="true">
        	    <option value="" style="display: none;" {{ old('user-id-sell', optional($order)->{'user-id-sell'} ?: '') == '' ? 'selected' : '' }} disabled selected>Enter seller here...</option>
        	@foreach ($users as $key => $user)
                <option value="{{ $key }}" {{ old('user-id-sell', optional($order)->{'user-id-sell'}) == $key ? 'selected' : '' }}>
                    {{ $user }}
                </option>
            @endforeach
        </select>
        
        {!! $errors->first('user-id-sell', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('user-id-buy') ? 'has-error' : '' }}">
    <label for="useridbuy" class="col-md-2 control-label">Buyer</label>
    <div class="col-md-10">
        <select class="form-control" id="useridbuy" name="user-id-buy" required="true">
        	    <option value="" style="display: none;" {{ old('user-id-buy', optional($order)->{'user-id-buy'} ?: '') == '' ? 'selected' : '' }} disabled selected>Enter buyer here...</option>
        	@foreach ($users as $key => $user)
			    <option value="{{ $key }}" {{ old('user-id-buy', optional($order)->{'user-id-buy'}) == $key ? 'selected' : '' }}>
			    	{{ $user }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('user-id-buy', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('post-id') ? 'has-error' : '' }}">
    <label for="postid" class="col-md-2 control-label">Postid</label>
    <div class="col-md-10">
        <select class="form-control" id="postid" name="post-id" required="true">
        	    <option value="" style="display: none;" {{ old('post-id', optional($order)->{'post-id'} ?: '') == '' ? 'selected' : '' }} disabled selected>Enter postid here...</option>
        	@foreach ($posts as $key => $post)
			    <option value="{{ $key }}" {{ old('post-id', optional($order)->{'post-id'}) == $key ? 'selected' : '' }}>
			    	{{ $key }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('post-id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('comment') ? 'has-error' : '' }}">
    <label for="comment" class="col-md-2 control-label">Comment</label>
    <div class="col-md-10">
        <input class="form-control" name="comment" type="text" id="comment" value="{{ old('comment', optional($order)->comment) }}" minlength="1" maxlength="500" required="true" placeholder="Enter comment here...">
        {!! $errors->first('comment', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('timestamp') ? 'has-error' : '' }}">
    <label for="timestamp" class="col-md-2 control-label">Timestamp</label>
    <div class="col-md-10">
        <input class="form-control" name="timestamp" type="text" id="timestamp" value="{{ old('timestamp', optional($order)->timestamp) }}" required="true" placeholder="Enter timestamp here...">
        {!! $errors->first('timestamp', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('location-meet') ? 'has-error' : '' }}">
    <label for="locationmeet" class="col-md-2 control-label">Locationmeet</label>
    <div class="col-md-10">
        <input class="form-control" name="location-meet" type="text" id="locationmeet" value="{{ old('location-meet', optional($order)->{'location-meet'}) }}" minlength="1" maxlength="150" required="true" placeholder="Enter locationmeet here...">
        {!! $errors->first('location-meet', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('location-date') ? 'has-error' : '' }}">
    <label for="locationdate" class="col-md-2 control-label">Locationdate</label>
    <div class="col-md-10">
        <input class="form-control" name="location-date" type="text" id="locationdate" value="{{ old('location-date', optional($order)->{'location-date'}) }}" required="true" placeholder="Enter locationdate here...">
        {!! $errors->first('location-date', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('location-time') ? 'has-error' : '' }}">
    <label for="locationtime" class="col-md-2 control-label">Locationtime</label>
    <div class="col-md-10">
        <input class="form-control" name="location-time" type="text" id="locationtime" value="{{ old('location-time', optional($order)->{'location-time'}) }}" maxlength="20" placeholder="Enter locationtime here...">
        {!! $errors->first('location-time', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('replied') ? 'has-error' : '' }}">
    <label for="replied" class="col-md-2 control-label">Replied</label>
    <div class="col-md-10">
        <input class="form-control" name="replied" type="text" id="replied" value="{{ old('replied', optional($order)->replied) }}" placeholder="Enter replied here...">
        {!! $errors->first('replied', '<p class="help-block">:message</p>') !!}
    </div>
</div>

