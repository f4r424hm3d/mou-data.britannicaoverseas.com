<div class="form-group">
  <label>{{ $label }} {!! $required!=null?'<span class="text-danger">*</span>':'' !!}</label>
  <textarea name="{{ $name }}" id="{{ $id }}" class="form-control" placeholder="{{ $label }}" {{ $required
    }}>{{ $ft == 'edit' ? $sd->$name : old($name) }}</textarea>
  <span id="{{ $name }}-err" class="text-danger errSpan">
    @error($name)
    {{ $message }}
    @enderror
  </span>
</div>