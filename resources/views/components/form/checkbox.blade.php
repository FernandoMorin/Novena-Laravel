@props(['label', 'checked' => false])

<label class="chk-inline">
    <input type="checkbox" @checked($checked) {{ $attributes }}>
    <span>{{ $label }}</span>
</label>
