
<div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
    <label for="name" class="col-md-2 control-label">Name</label>
    <div class="col-md-10">
        <input class="form-control" name="name" type="text" id="name" value="{{ old('name', optional($user)->name) }}" minlength="1" maxlength="64" required="true" placeholder="Enter name here...">
        {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('surname') ? 'has-error' : '' }}">
    <label for="surname" class="col-md-2 control-label">Surname</label>
    <div class="col-md-10">
        <input class="form-control" name="surname" type="text" id="surname" value="{{ old('surname', optional($user)->surname) }}" minlength="1" maxlength="64" required="true" placeholder="Enter surname here...">
        {!! $errors->first('surname', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('about-me') ? 'has-error' : '' }}">
    <label for="aboutme" class="col-md-2 control-label">Aboutme</label>
    <div class="col-md-10">
        <input class="form-control" name="about-me" type="text" id="aboutme" value="{{ old('about-me', optional($user)->{'about-me'}) }}" maxlength="8388607" placeholder="Enter aboutme here...">
        {!! $errors->first('about-me', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('username') ? 'has-error' : '' }}">
    <label for="username" class="col-md-2 control-label">Username</label>
    <div class="col-md-10">
        <input class="form-control" name="username" type="text" id="username" value="{{ old('username', optional($user)->username) }}" maxlength="259" placeholder="Enter username here...">
        {!! $errors->first('username', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
    <label for="password" class="col-md-2 control-label">Password</label>
    <div class="col-md-10">
        <input class="form-control" name="password" type="text" id="password" value="{{ old('password', optional($user)->password) }}" minlength="1" maxlength="8388607" required="true" placeholder="Enter password here...">
        {!! $errors->first('password', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
    <label for="email" class="col-md-2 control-label">Email</label>
    <div class="col-md-10">
        <input class="form-control" name="email" type="text" id="email" value="{{ old('email', optional($user)->email) }}" minlength="1" maxlength="64" required="true" placeholder="Enter email here...">
        {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('uni-id') ? 'has-error' : '' }}">
    <label for="uniid" class="col-md-2 control-label">Uniid</label>
    <div class="col-md-10">
        <select class="form-control" id="uniid" name="uni-id">
        	    <option value="" style="display: none;" {{ old('uni-id', optional($user)->{'uni-id'} ?: '') == '' ? 'selected' : '' }} disabled selected>Enter uniid here...</option>
        	@foreach ($Universities as $key => $University)
			    <option value="{{ $key }}" {{ old('uni-id', optional($user)->{'uni-id'}) == $key ? 'selected' : '' }}>
			    	{{ $key }}
			    </option>
			@endforeach
        </select>

        {!! $errors->first('uni-id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('country') ? 'has-error' : '' }}">
    <label for="country" class="col-md-2 control-label">Country</label>
    <div class="col-md-10">
        <input class="form-control" name="country" type="text" id="country" value="{{ old('country', optional($user)->country) }}" placeholder="Enter country here...">
        {!! $errors->first('country', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('city') ? 'has-error' : '' }}">
    <label for="city" class="col-md-2 control-label">City</label>
    <div class="col-md-10">
        <input class="form-control" name="city" type="text" id="city" value="{{ old('city', optional($user)->city) }}" maxlength="64" placeholder="Enter city here...">
        {!! $errors->first('city', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('address') ? 'has-error' : '' }}">
    <label for="address" class="col-md-2 control-label">Address</label>
    <div class="col-md-10">
        <input class="form-control" name="address" type="text" id="address" value="{{ old('address', optional($user)->address) }}" maxlength="259" placeholder="Enter address here...">
        {!! $errors->first('address', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('user-tel') ? 'has-error' : '' }}">
    <label for="usertel" class="col-md-2 control-label">Usertel</label>
    <div class="col-md-10">
        <input class="form-control" name="user-tel" type="text" id="usertel" value="{{ old('user-tel', optional($user)->{'user-tel'}) }}" maxlength="20" placeholder="Enter usertel here...">
        {!! $errors->first('user-tel', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('user-registered') ? 'has-error' : '' }}">
    <label for="userregistered" class="col-md-2 control-label">Userregistered</label>
    <div class="col-md-10">
        <input class="form-control" name="user-registered" type="text" id="userregistered" value="{{ old('user-registered', optional($user)->{'user-registered'}) }}" required="true" placeholder="Enter userregistered here...">
        {!! $errors->first('user-registered', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('userlevel') ? 'has-error' : '' }}">
    <label for="userlevel" class="col-md-2 control-label">Userlevel</label>
    <div class="col-md-10">
        <div class="checkbox">
            <label for="userlevel_1">
            	<input id="userlevel_1" class="" name="userlevel" type="checkbox" value="1" {{ old('userlevel', optional($user)->userlevel) == '1' ? 'checked' : '' }}>
                Yes
            </label>
        </div>

        {!! $errors->first('userlevel', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('profilepic') ? 'has-error' : '' }}">
    <label for="profilepic" class="col-md-2 control-label">Profilepic</label>
    <div class="col-md-10">
        <input class="form-control" name="profilepic" type="text" id="profilepic" value="{{ old('profilepic', optional($user)->profilepic) }}" minlength="1" maxlength="259" required="true" placeholder="Enter profilepic here...">
        {!! $errors->first('profilepic', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('seen') ? 'has-error' : '' }}">
    <label for="seen" class="col-md-2 control-label">Seen</label>
    <div class="col-md-10">
        <input class="form-control" name="seen" type="text" id="seen" value="{{ old('seen', optional($user)->seen) }}" required="true" placeholder="Enter seen here...">
        {!! $errors->first('seen', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('last_login') ? 'has-error' : '' }}">
    <label for="last_login" class="col-md-2 control-label">Last Login</label>
    <div class="col-md-10">
        <input class="form-control" name="last_login" type="text" id="last_login" value="{{ old('last_login', optional($user)->last_login) }}" placeholder="Enter last login here...">
        {!! $errors->first('last_login', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('last_ip_access') ? 'has-error' : '' }}">
    <label for="last_ip_access" class="col-md-2 control-label">Last Ip Access</label>
    <div class="col-md-10">
        <input class="form-control" name="last_ip_access" type="text" id="last_ip_access" value="{{ old('last_ip_access', optional($user)->last_ip_access) }}" maxlength="17" placeholder="Enter last ip access here...">
        {!! $errors->first('last_ip_access', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('sess-id') ? 'has-error' : '' }}">
    <label for="sessid" class="col-md-2 control-label">Sessid</label>
    <div class="col-md-10">
        <input class="form-control" name="sess-id" type="text" id="sessid" value="{{ old('sess-id', optional($user)->{'sess-id'}) }}" maxlength="40" placeholder="Enter sessid here...">
        {!! $errors->first('sess-id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

