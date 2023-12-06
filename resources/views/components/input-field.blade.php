<div class="form-group">
  <label>{{ $label }} {!! $required!=null?'<span class="text-danger">*</span>':'' !!}</label>
  <input name="{{ $name }}" id="{{ $id }}" type="{{ $type }}" class="form-control" placeholder="{{ $label }}"
    value="{{ $ft == 'edit' ? $sd->$name : old($name) }}" {{ $required }}>
  <span id="{{ $name }}-err" class="text-danger errSpan">
    @error($name)
    {{ $message }}
    @enderror
  </span>
</div>