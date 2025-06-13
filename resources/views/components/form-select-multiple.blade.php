<div class="{{ $divClass }}">
    <div class="form-floating mb-3">
        <select class="form-select" id="{{ $id }}" aria-label="Floating label select example"
            name="{{ $name }}" fdprocessedid="6lmm1" style="{{ $style }}" multiple>
            {{ $slot }}
        </select>
        <label for="{{ $forLabel }}">{{ $inputLabel }}</label>
    </div>
    <x-form-error name='{{ $name }}' />
</div>
