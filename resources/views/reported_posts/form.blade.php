
<div class="form-group {{ $errors->has('reported_by') ? 'has-error' : '' }}">
    <label for="reported_by" class="col-md-2 control-label">Reported By</label>
    <div class="col-md-10">
        <select class="form-control" id="reported_by" name="reported_by">
        	    <option value="" style="display: none;" {{ old('reported_by', optional($reportedPost)->reported_by ?: '') == '' ? 'selected' : '' }} disabled selected>Select reported by</option>
        	@foreach ($users as $key => $user)
			    <option value="{{ $key }}" {{ old('reported_by', optional($reportedPost)->reported_by) == $key ? 'selected' : '' }}>
			    	{{ $user }}
			    </option>
			@endforeach
        </select>

        {!! $errors->first('reported_by', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('post-id') ? 'has-error' : '' }}">
    <label for="postid" class="col-md-2 control-label">Postid</label>
    <div class="col-md-10">
        <select class="form-control" id="postid" name="post-id">
        	    <option value="" style="display: none;" {{ old('post-id', optional($reportedPost)->{'post-id'} ?: '') == '' ? 'selected' : '' }} disabled selected>Enter postid here...</option>
        	@foreach ($posts as $key => $post)
			    <option value="{{ $key }}" {{ old('post-id', optional($reportedPost)->{'post-id'}) == $key ? 'selected' : '' }}>
			    	{{ $key }}
			    </option>
			@endforeach
        </select>

        {!! $errors->first('post-id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('reason') ? 'has-error' : '' }}">
    <label for="reason" class="col-md-2 control-label">Reason</label>
    <div class="col-md-10">
        <input class="form-control" name="reason" type="text" id="reason" value="{{ old('reason', optional($reportedPost)->reason) }}" maxlength="150" placeholder="Enter reason here...">
        {!! $errors->first('reason', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('report_time') ? 'has-error' : '' }}">
    <label for="report_time" class="col-md-2 control-label">Report Time</label>
    <div class="col-md-10">
        <input class="form-control" name="report_time" type="text" id="report_time" value="{{ old('report_time', optional($reportedPost)->report_time) }}" placeholder="Enter report time here...">
        {!! $errors->first('report_time', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('resolved') ? 'has-error' : '' }}">
    <label for="resolved" class="col-md-2 control-label">Resolved</label>
    <div class="col-md-10">
        <input class="form-control" name="resolved" type="number" id="resolved" value="{{ old('resolved', optional($reportedPost)->resolved) }}" min="-2147483648" max="2147483647" placeholder="Enter resolved here...">
        {!! $errors->first('resolved', '<p class="help-block">:message</p>') !!}
    </div>
</div>

