
<div class="form-group {{ $errors->has('userid') ? 'has-error' : '' }}">
    <label for="userid" class="col-md-2 control-label">Userid</label>
    <div class="col-md-10">
        <select class="form-control" id="userid" name="userid">
        	    <option value="" style="display: none;" {{ old('userid', optional($facebookLogin)->userid ?: '') == '' ? 'selected' : '' }} disabled selected>Enter userid here...</option>
        	@foreach ($users as $key => $user)
			    <option value="{{ $key }}" {{ old('userid', optional($facebookLogin)->userid) == $key ? 'selected' : '' }}>
			    	{{ $user }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('userid', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('syncprofilepic') ? 'has-error' : '' }}">
    <label for="syncprofilepic" class="col-md-2 control-label">Syncprofilepic</label>
    <div class="col-md-10">
        <div class="checkbox">
            <label for="syncprofilepic_1">
            	<input id="syncprofilepic_1" class="" name="syncprofilepic" type="checkbox" value="1" {{ old('syncprofilepic', optional($facebookLogin)->syncprofilepic) == '1' ? 'checked' : '' }}>
                Yes
            </label>
        </div>

        {!! $errors->first('syncprofilepic', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('fb_name') ? 'has-error' : '' }}">
    <label for="fb_name" class="col-md-2 control-label">Fb Name</label>
    <div class="col-md-10">
        <input class="form-control" name="fb_name" type="text" id="fb_name" value="{{ old('fb_name', optional($facebookLogin)->fb_name) }}" maxlength="70" placeholder="Enter fb name here...">
        {!! $errors->first('fb_name', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('fb_surname') ? 'has-error' : '' }}">
    <label for="fb_surname" class="col-md-2 control-label">Fb Surname</label>
    <div class="col-md-10">
        <input class="form-control" name="fb_surname" type="text" id="fb_surname" value="{{ old('fb_surname', optional($facebookLogin)->fb_surname) }}" maxlength="70" placeholder="Enter fb surname here...">
        {!! $errors->first('fb_surname', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('fb_email') ? 'has-error' : '' }}">
    <label for="fb_email" class="col-md-2 control-label">Fb Email</label>
    <div class="col-md-10">
        <input class="form-control" name="fb_email" type="text" id="fb_email" value="{{ old('fb_email', optional($facebookLogin)->fb_email) }}" maxlength="90" placeholder="Enter fb email here...">
        {!! $errors->first('fb_email', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('fb_gender') ? 'has-error' : '' }}">
    <label for="fb_gender" class="col-md-2 control-label">Fb Gender</label>
    <div class="col-md-10">
        <input class="form-control" name="fb_gender" type="text" id="fb_gender" value="{{ old('fb_gender', optional($facebookLogin)->fb_gender) }}" maxlength="20" placeholder="Enter fb gender here...">
        {!! $errors->first('fb_gender', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('fb_profilepic') ? 'has-error' : '' }}">
    <label for="fb_profilepic" class="col-md-2 control-label">Fb Profilepic</label>
    <div class="col-md-10">
        <input class="form-control" name="fb_profilepic" type="text" id="fb_profilepic" value="{{ old('fb_profilepic', optional($facebookLogin)->fb_profilepic) }}" maxlength="259" placeholder="Enter fb profilepic here...">
        {!! $errors->first('fb_profilepic', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('fb_link') ? 'has-error' : '' }}">
    <label for="fb_link" class="col-md-2 control-label">Fb Link</label>
    <div class="col-md-10">
        <input class="form-control" name="fb_link" type="text" id="fb_link" value="{{ old('fb_link', optional($facebookLogin)->fb_link) }}" maxlength="59" placeholder="Enter fb link here...">
        {!! $errors->first('fb_link', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('fb_location') ? 'has-error' : '' }}">
    <label for="fb_location" class="col-md-2 control-label">Fb Location</label>
    <div class="col-md-10">
        <input class="form-control" name="fb_location" type="text" id="fb_location" value="{{ old('fb_location', optional($facebookLogin)->fb_location) }}" maxlength="59" placeholder="Enter fb location here...">
        {!! $errors->first('fb_location', '<p class="help-block">:message</p>') !!}
    </div>
</div>

