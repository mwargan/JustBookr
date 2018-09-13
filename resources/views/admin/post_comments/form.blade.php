
<div class="form-group {{ $errors->has('postid') ? 'has-error' : '' }}">
    <label for="postid" class="col-md-2 control-label">Postid</label>
    <div class="col-md-10">
        <select class="form-control" id="postid" name="postid" required="true">
        	    <option value="" style="display: none;" {{ old('postid', optional($postComment)->postid ?: '') == '' ? 'selected' : '' }} disabled selected>Enter postid here...</option>
        	@foreach ($posts as $key => $post)
			    <option value="{{ $key }}" {{ old('postid', optional($postComment)->postid) == $key ? 'selected' : '' }}>
			    	{{ $post }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('postid', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('userid') ? 'has-error' : '' }}">
    <label for="userid" class="col-md-2 control-label">Userid</label>
    <div class="col-md-10">
        <select class="form-control" id="userid" name="userid" required="true">
        	    <option value="" style="display: none;" {{ old('userid', optional($postComment)->userid ?: '') == '' ? 'selected' : '' }} disabled selected>Enter userid here...</option>
        	@foreach ($users as $key => $user)
			    <option value="{{ $key }}" {{ old('userid', optional($postComment)->userid) == $key ? 'selected' : '' }}>
			    	{{ $user }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('userid', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('comment') ? 'has-error' : '' }}">
    <label for="comment" class="col-md-2 control-label">Comment</label>
    <div class="col-md-10">
        <input class="form-control" name="comment" type="text" id="comment" value="{{ old('comment', optional($postComment)->comment) }}" minlength="1" maxlength="250" required="true" placeholder="Enter comment here...">
        {!! $errors->first('comment', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('comment_timestamp') ? 'has-error' : '' }}">
    <label for="comment_timestamp" class="col-md-2 control-label">Comment Timestamp</label>
    <div class="col-md-10">
        <input class="form-control" name="comment_timestamp" type="text" id="comment_timestamp" value="{{ old('comment_timestamp', optional($postComment)->comment_timestamp) }}" required="true" placeholder="Enter comment timestamp here...">
        {!! $errors->first('comment_timestamp', '<p class="help-block">:message</p>') !!}
    </div>
</div>

