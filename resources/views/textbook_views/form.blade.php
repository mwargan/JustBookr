
<div class="form-group {{ $errors->has('userid') ? 'has-error' : '' }}">
    <label for="userid" class="col-md-2 control-label">Userid</label>
    <div class="col-md-10">
        <input class="form-control" name="userid" type="number" id="userid" value="{{ old('userid', optional($textbookView)->userid) }}" min="-2147483648" max="2147483647" placeholder="Enter userid here...">
        {!! $errors->first('userid', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('view_IP') ? 'has-error' : '' }}">
    <label for="view_IP" class="col-md-2 control-label">View  I P</label>
    <div class="col-md-10">
        <input class="form-control" name="view_IP" type="text" id="view_IP" value="{{ old('view_IP', optional($textbookView)->view_IP) }}" minlength="1" maxlength="45" required="true" placeholder="Enter view  i p here...">
        {!! $errors->first('view_IP', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('isbnviewed') ? 'has-error' : '' }}">
    <label for="isbnviewed" class="col-md-2 control-label">Isbnviewed</label>
    <div class="col-md-10">
        <input class="form-control" name="isbnviewed" type="text" id="isbnviewed" value="{{ old('isbnviewed', optional($textbookView)->isbnviewed) }}" minlength="1" maxlength="13" required="true" placeholder="Enter isbnviewed here...">
        {!! $errors->first('isbnviewed', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('univiewed') ? 'has-error' : '' }}">
    <label for="univiewed" class="col-md-2 control-label">Univiewed</label>
    <div class="col-md-10">
        <input class="form-control" name="univiewed" type="number" id="univiewed" value="{{ old('univiewed', optional($textbookView)->univiewed) }}" min="-2147483648" max="2147483647" placeholder="Enter univiewed here...">
        {!! $errors->first('univiewed', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('dateviewed') ? 'has-error' : '' }}">
    <label for="dateviewed" class="col-md-2 control-label">Dateviewed</label>
    <div class="col-md-10">
        <input class="form-control" name="dateviewed" type="text" id="dateviewed" value="{{ old('dateviewed', optional($textbookView)->dateviewed) }}" required="true" placeholder="Enter dateviewed here...">
        {!! $errors->first('dateviewed', '<p class="help-block">:message</p>') !!}
    </div>
</div>

