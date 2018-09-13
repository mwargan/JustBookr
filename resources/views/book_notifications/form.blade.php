
<div class="form-group {{ $errors->has('user_id') ? 'has-error' : '' }}">
    <label for="user_id" class="col-md-2 control-label">User</label>
    <div class="col-md-10">
        <select class="form-control" id="user_id" name="user_id">
        	    <option value="" style="display: none;" {{ old('user_id', optional($bookNotification)->user_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select user</option>
        	@foreach ($users as $key => $user)
			    <option value="{{ $key }}" {{ old('user_id', optional($bookNotification)->user_id) == $key ? 'selected' : '' }}>
			    	{{ $user }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('user_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('uni_id') ? 'has-error' : '' }}">
    <label for="uni_id" class="col-md-2 control-label">Uni</label>
    <div class="col-md-10">
        <select class="form-control" id="uni_id" name="uni_id">
        	    <option value="" style="display: none;" {{ old('uni_id', optional($bookNotification)->uni_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select uni</option>
        	@foreach ($unis as $key => $uni)
			    <option value="{{ $key }}" {{ old('uni_id', optional($bookNotification)->uni_id) == $key ? 'selected' : '' }}>
			    	{{ $uni }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('uni_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('isbn') ? 'has-error' : '' }}">
    <label for="isbn" class="col-md-2 control-label">Isbn</label>
    <div class="col-md-10">
        <input class="form-control" name="isbn" type="text" id="isbn" value="{{ old('isbn', optional($bookNotification)->isbn) }}" minlength="1" placeholder="Enter isbn here...">
        {!! $errors->first('isbn', '<p class="help-block">:message</p>') !!}
    </div>
</div>

