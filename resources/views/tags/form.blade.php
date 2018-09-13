
<div class="form-group {{ $errors->has('t-data') ? 'has-error' : '' }}">
    <label for="tdata" class="col-md-2 control-label">Tdata</label>
    <div class="col-md-10">
        <input class="form-control" name="t-data" type="text" id="tdata" value="{{ old('t-data', optional($tag)->{'t-data'}) }}" minlength="1" maxlength="20" required="true" placeholder="Enter tdata here...">
        {!! $errors->first('t-data', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('t-pic') ? 'has-error' : '' }}">
    <label for="tpic" class="col-md-2 control-label">Tpic</label>
    <div class="col-md-10">
        <input class="form-control" name="t-pic" type="text" id="tpic" value="{{ old('t-pic', optional($tag)->{'t-pic'}) }}" maxlength="159" placeholder="Enter tpic here...">
        {!! $errors->first('t-pic', '<p class="help-block">:message</p>') !!}
    </div>
</div>

