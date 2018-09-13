
<div class="form-group {{ $errors->has('isbn') ? 'has-error' : '' }}">
    <label for="isbn" class="col-md-2 control-label">Isbn</label>
    <div class="col-md-10">
        <input class="form-control" name="isbn" type="text" id="isbn" value="{{ old('isbn', optional($textbookPriceAverage)->isbn) }}" minlength="1" placeholder="Enter isbn here...">
        {!! $errors->first('isbn', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('min') ? 'has-error' : '' }}">
    <label for="min" class="col-md-2 control-label">Min</label>
    <div class="col-md-10">
        <input class="form-control" name="min" type="text" id="min" value="{{ old('min', optional($textbookPriceAverage)->min) }}" minlength="1" placeholder="Enter min here...">
        {!! $errors->first('min', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('avg') ? 'has-error' : '' }}">
    <label for="avg" class="col-md-2 control-label">Avg</label>
    <div class="col-md-10">
        <input class="form-control" name="avg" type="text" id="avg" value="{{ old('avg', optional($textbookPriceAverage)->avg) }}" minlength="1" placeholder="Enter avg here...">
        {!! $errors->first('avg', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('max') ? 'has-error' : '' }}">
    <label for="max" class="col-md-2 control-label">Max</label>
    <div class="col-md-10">
        <input class="form-control" name="max" type="text" id="max" value="{{ old('max', optional($textbookPriceAverage)->max) }}" minlength="1" placeholder="Enter max here...">
        {!! $errors->first('max', '<p class="help-block">:message</p>') !!}
    </div>
</div>

