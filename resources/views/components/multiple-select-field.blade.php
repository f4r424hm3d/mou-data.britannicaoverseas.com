<div class="form-group">
  <label>{{ $label }} {!! $required!=null?'<span class="text-danger">*</span>':'' !!}</label>
  <select name="{{ $name }}[]" id="{{ $id }}" class="form-control select2" {{ $required }} multiple data-trigger>
    <option value="">Select</option>
    @foreach ($list as $row)
    <option value="{{ $row->$savev }}" {{ $ft=='edit' && in_array($row->$savev, json_decode($sd->$name)) ?'selected':''
      }}>{{ $row->$showv }}</option>
    @endforeach
  </select>
  <span id="{{ $name }}-err" class="text-danger errSpan">
    @error($name)
    {{ $message }}
    @enderror
  </span>
</div>