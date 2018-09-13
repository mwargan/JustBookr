
<div class="form-group {{ $errors->has('tagid') ? 'has-error' : '' }}">
    <label for="tagid" class="col-md-2 control-label">Tagid</label>
    <div class="col-md-10">
        <select class="form-control" id="tagid" name="tagid" required="true">
        	    <option value="" style="display: none;" {{ old('tagid', optional($textbookTag)->tagid ?: '') == '' ? 'selected' : '' }} disabled selected>Enter tagid here...</option>
        	@foreach ($tags as $key => $tag)
			    <option value="{{ $key }}" {{ old('tagid', optional($textbookTag)->tagid) == $key ? 'selected' : '' }}>
			    	{{ $tag }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('tagid', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('isbn') ? 'has-error' : '' }}">
    <label for="isbn" class="col-md-2 control-label">Isbn</label>
    <div class="col-md-10">
        <select class="form-control" id="isbn" name="isbn" required="true">
        	    <option value="" style="display: none;" {{ old('isbn', optional($textbookTag)->isbn ?: '') == '' ? 'selected' : '' }} disabled selected>Enter isbn here...</option>
        	@foreach ($textbooks as $key => $textbook)
			    <option value="{{ $key }}" {{ old('isbn', optional($textbookTag)->isbn) == $key ? 'selected' : '' }}>
			    	{{ $textbook }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('isbn', '<p class="help-block">:message</p>') !!}
    </div>
</div>

