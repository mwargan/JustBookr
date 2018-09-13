
<div class="form-group {{ $errors->has('uniid') ? 'has-error' : '' }}">
    <label for="uniid" class="col-md-2 control-label">Uniid</label>
    <div class="col-md-10">
        <input class="form-control" name="uniid" type="text" id="uniid" value="{{ old('uniid', optional($universityTag)->uniid) }}" minlength="1" placeholder="Enter uniid here...">
        {!! $errors->first('uniid', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('tagid') ? 'has-error' : '' }}">
    <label for="tagid" class="col-md-2 control-label">Tagid</label>
    <div class="col-md-10">
        <input class="form-control" name="tagid" type="text" id="tagid" value="{{ old('tagid', optional($universityTag)->tagid) }}" minlength="1" placeholder="Enter tagid here...">
        {!! $errors->first('tagid', '<p class="help-block">:message</p>') !!}
    </div>
</div>

