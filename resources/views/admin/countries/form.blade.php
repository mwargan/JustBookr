
<div class="form-group {{ $errors->has('iso2') ? 'has-error' : '' }}">
    <label for="iso2" class="col-md-2 control-label">Iso2</label>
    <div class="col-md-10">
        <input class="form-control" name="iso2" type="text" id="iso2" value="{{ old('iso2', optional($country)->iso2) }}" minlength="1" maxlength="2" required="true" placeholder="Enter iso2 here...">
        {!! $errors->first('iso2', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('iso3') ? 'has-error' : '' }}">
    <label for="iso3" class="col-md-2 control-label">Iso3</label>
    <div class="col-md-10">
        <input class="form-control" name="iso3" type="text" id="iso3" value="{{ old('iso3', optional($country)->iso3) }}" minlength="1" maxlength="3" required="true" placeholder="Enter iso3 here...">
        {!! $errors->first('iso3', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
    <label for="name" class="col-md-2 control-label">Name</label>
    <div class="col-md-10">
        <input class="form-control" name="name" type="text" id="name" value="{{ old('name', optional($country)->name) }}" minlength="1" maxlength="100" required="true" placeholder="Enter name here...">
        {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('currency') ? 'has-error' : '' }}">
    <label for="currency" class="col-md-2 control-label">Currency</label>
    <div class="col-md-10">
        <input class="form-control" name="currency" type="text" id="currency" value="{{ old('currency', optional($country)->currency) }}" maxlength="7" placeholder="Enter currency here...">
        {!! $errors->first('currency', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('currency_iso') ? 'has-error' : '' }}">
    <label for="currency_iso" class="col-md-2 control-label">Currency Iso</label>
    <div class="col-md-10">
        <input class="form-control" name="currency_iso" type="text" id="currency_iso" value="{{ old('currency_iso', optional($country)->currency_iso) }}" maxlength="3" placeholder="Enter currency iso here...">
        {!! $errors->first('currency_iso', '<p class="help-block">:message</p>') !!}
    </div>
</div>

