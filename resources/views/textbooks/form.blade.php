<div class="form-group {{ $errors->has('isbn') ? 'has-error' : '' }}">
    <label for="isbn" class="col-md-2 control-label">ISBN</label>
    <div class="col-md-10">
        <input class="form-control" name="isbn" type="text" id="isbn" value="{{ old('isbn', optional($textbook)->isbn) }}" minlength="1" maxlength="259" required="true" placeholder="Enter booktitle here...">
        {!! $errors->first('isbn', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('book-title') ? 'has-error' : '' }}">
    <label for="booktitle" class="col-md-2 control-label">Booktitle</label>
    <div class="col-md-10">
        <input class="form-control" name="book-title" type="text" id="booktitle" value="{{ old('book-title', optional($textbook)->{'book-title'}) }}" minlength="1" maxlength="259" required="true" placeholder="Enter booktitle here...">
        {!! $errors->first('book-title', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('author') ? 'has-error' : '' }}">
    <label for="author" class="col-md-2 control-label">Author</label>
    <div class="col-md-10">
        <input class="form-control" name="author" type="text" id="author" value="{{ old('author', optional($textbook)->author) }}" minlength="1" maxlength="259" required="true" placeholder="Enter author here...">
        {!! $errors->first('author', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('book-des') ? 'has-error' : '' }}">
    <label for="bookdes" class="col-md-2 control-label">Bookdes</label>
    <div class="col-md-10">
        <textarea class="form-control" name="book-des" cols="50" rows="10" id="bookdes" required="true" placeholder="Enter bookdes here...">{{ old('book-des', optional($textbook)->{'book-des'}) }}</textarea>
        {!! $errors->first('book-des', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('edition') ? 'has-error' : '' }}">
    <label for="edition" class="col-md-2 control-label">Edition</label>
    <div class="col-md-10">
        <input class="form-control" name="edition" type="text" id="edition" value="{{ old('edition', optional($textbook)->edition) }}" minlength="1" maxlength="64" required="true" placeholder="Enter edition here...">
        {!! $errors->first('edition', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('image-url') ? 'has-error' : '' }}">
    <label for="imageurl" class="col-md-2 control-label">Imageurl</label>
    <div class="col-md-10">
        <input class="form-control" name="image-url" type="text" id="imageurl" value="{{ old('image-url', optional($textbook)->{'image-url'}) }}" min="1" max="259" required="true" placeholder="Enter imageurl here...">
        {!! $errors->first('image-url', '<p class="help-block">:message</p>') !!}
    </div>
</div>

