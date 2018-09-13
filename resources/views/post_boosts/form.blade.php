
<div class="form-group {{ $errors->has('post_t_id') ? 'has-error' : '' }}">
    <label for="post_t_id" class="col-md-2 control-label">Post T</label>
    <div class="col-md-10">
        <select class="form-control" id="post_t_id" name="post_t_id">
        	    <option value="" style="display: none;" {{ old('post_t_id', optional($postBoost)->post_t_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select post t</option>
        	@foreach ($postTs as $key => $postT)
			    <option value="{{ $key }}" {{ old('post_t_id', optional($postBoost)->post_t_id) == $key ? 'selected' : '' }}>
			    	{{ $postT }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('post_t_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('expires_at') ? 'has-error' : '' }}">
    <label for="expires_at" class="col-md-2 control-label">Expires At</label>
    <div class="col-md-10">
        <input class="form-control" name="expires_at" type="text" id="expires_at" value="{{ old('expires_at', optional($postBoost)->expires_at) }}" placeholder="Enter expires at here...">
        {!! $errors->first('expires_at', '<p class="help-block">:message</p>') !!}
    </div>
</div>

