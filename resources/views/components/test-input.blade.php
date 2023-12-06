<div class="col-md-12 col-sm-12">
  <div class="form-group mb-3">
    <label>Meta Title</label>
    <input name="meta_title" type="text" class="form-control" placeholder="Enter Meta Title">
    <span id="{{ $name }}-err" class="text-danger errSpan">
      @error('meta_title')
      {{ $message }}
      @enderror
    </span>
  </div>
</div>