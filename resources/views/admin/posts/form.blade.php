
<div class="form-group {{ $errors->has('user-id') ? 'has-error' : '' }}">
    <label for="userid" class="col-md-2 control-label">user-id</label>
    <div class="col-md-10">
        <select class="form-control" id="userid" name="user-id">
        	    <option value="" style="display: none;" {{ old('user-id', optional($post)->{'user-id'} ?: '') == '' ? 'selected' : '' }} disabled selected>Enter user-id here...</option>
        	@foreach ($users as $user)
			    <option value="{{ $user }}" {{ old('user-id', optional($post)->{'user-id'}) == $user ? 'selected' : '' }}>
			    	{{ $user }}
			    </option>
			@endforeach
        </select>
        {!! $errors->first('user-id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('date') ? 'has-error' : '' }}">
    <label for="date" class="col-md-2 control-label">Date</label>
    <div class="col-md-10">
        <input class="form-control" name="date" type="text" id="date" value="{{ old('date', optional($post)->date) }}" placeholder="Enter date here...">
        {!! $errors->first('date', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('post-description') ? 'has-error' : '' }}">
    <label for="post-description" class="col-md-2 control-label">Postdescription</label>
    <div class="col-md-10">
        <textarea class="form-control" name="post-description" cols="50" rows="10" id="postdescription" required="true" placeholder="Enter postdescription here...">{{ old('post-description', optional($post)->{'post-description'}) }}</textarea>
        {!! $errors->first('post-description', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('isbn') ? 'has-error' : '' }}">
    <label for="isbn" class="col-md-2 control-label">Isbn</label>
    <div class="col-md-10">
        <select class="form-control" id="isbn" name="isbn" required="true">
        	    <option value="" style="display: none;" {{ old('isbn', optional($post)->isbn ?: '') == '' ? 'selected' : '' }} disabled selected>Enter isbn here...</option>
        	@foreach ($textbooks as $textbook)
			    <option value="{{ $textbook }}" {{ old('isbn', optional($post)->isbn) == $textbook ? 'selected' : '' }}>
			    	{{ $textbook }}
			    </option>
			@endforeach
        </select>

        {!! $errors->first('isbn', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('quality') ? 'has-error' : '' }}">
    <label for="quality" class="col-md-2 control-label">Quality</label>
    <div class="col-md-10">
        <input class="form-control" name="quality" type="text" id="quality" value="{{ old('quality', optional($post)->quality) }}" maxlength="64" placeholder="Enter quality here...">
        {!! $errors->first('quality', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('uni-id') ? 'has-error' : '' }}">
    <label for="uniid" class="col-md-2 control-label">Uniid</label>
    <div class="col-md-10">
        <select class="form-control" id="uniid" name="uni-id" required="true">
        	    <option value="" style="display: none;" {{ old('uni-id', optional($post)->{'uni-id'} ?: '') == '' ? 'selected' : '' }} disabled selected>Enter uniid here...</option>
        	@foreach ($Universities as $key => $value)
			    <option value="{{ $value }}" {{ old('uni-id', optional($post)->{'uni-id'}) == $value ? 'selected' : '' }}>
			    	{{ $key }}
			    </option>
			@endforeach
        </select>

        {!! $errors->first('uni-id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('sku') ? 'has-error' : '' }}">
    <label for="sku" class="col-md-2 control-label">Sku</label>
    <div class="col-md-10">
        <input class="form-control" name="sku" type="number" id="sku" value="{{ old('sku', optional($post)->sku) }}" min="-2147483648" max="2147483647" placeholder="Enter sku here...">
        {!! $errors->first('sku', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('price') ? 'has-error' : '' }}">
    <label for="price" class="col-md-2 control-label">Price</label>
    <div class="col-md-10">
        <input class="form-control" name="price" type="number" id="price" value="{{ old('price', optional($post)->price) }}" min="-2147483648" max="2147483647" required="true" placeholder="Enter price here...">
        {!! $errors->first('price', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
    <label for="status" class="col-md-2 control-label">Status</label>
    <div class="col-md-10">
        <input class="form-control" name="status" type="text" id="status" value="{{ old('status', optional($post)->status) }}" minlength="1" placeholder="Enter status here...">
        {!! $errors->first('status', '<p class="help-block">:message</p>') !!}
    </div>
</div>

