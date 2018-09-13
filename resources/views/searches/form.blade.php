
<div class="form-group {{ $errors->has('query') ? 'has-error' : '' }}">
    <label for="query" class="col-md-2 control-label">Query</label>
    <div class="col-md-10">
        <input class="form-control" name="query" type="text" id="query" value="{{ old('query', optional($search)->query) }}" minlength="1" maxlength="100" required="true" placeholder="Enter query here...">
        {!! $errors->first('query', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('user') ? 'has-error' : '' }}">
    <label for="user" class="col-md-2 control-label">User</label>
    <div class="col-md-10">
        <input class="form-control" name="user" type="number" id="user" value="{{ old('user', optional($search)->user) }}" min="-2147483648" max="2147483647" placeholder="Enter user here...">
        {!! $errors->first('user', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('uni') ? 'has-error' : '' }}">
    <label for="uni" class="col-md-2 control-label">Uni</label>
    <div class="col-md-10">
        <input class="form-control" name="uni" type="number" id="uni" value="{{ old('uni', optional($search)->uni) }}" min="-2147483648" max="2147483647" placeholder="Enter uni here...">
        {!! $errors->first('uni', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('results_count') ? 'has-error' : '' }}">
    <label for="results_count" class="col-md-2 control-label">Results Count</label>
    <div class="col-md-10">
        <input class="form-control" name="results_count" type="text" id="results_count" value="{{ old('results_count', optional($search)->results_count) }}" min="0" placeholder="Enter results count here...">
        {!! $errors->first('results_count', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('timestamp') ? 'has-error' : '' }}">
    <label for="timestamp" class="col-md-2 control-label">Timestamp</label>
    <div class="col-md-10">
        <input class="form-control" name="timestamp" type="text" id="timestamp" value="{{ old('timestamp', optional($search)->timestamp) }}" placeholder="Enter timestamp here...">
        {!! $errors->first('timestamp', '<p class="help-block">:message</p>') !!}
    </div>
</div>

