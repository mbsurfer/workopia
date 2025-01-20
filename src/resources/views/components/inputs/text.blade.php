@props(['id', 'name', 'placeholder', 'value' => null, 'label' => null, 'type' => 'text', 'required' => false])

<div class="mb-4">
    @if ($label)
        <label class="block text-gray-700" for="{{ $id }}">{{ $label }}</label>
    @endif

    <input
        id="{{ $id }}"
        type="{{ $type }}"
        name="{{ $name }}"
        @class([
            'w-full',
            'px-4',
            'py-2',
            'border',
            'rounded',
            'focus:outline-none',
            'border-red-500' => $errors->has($name)
        ])
        placeholder="{{ $placeholder }}"
        value="{{ old($name, $value) }}"
        @if ($required) required @endif
    />
    @error($name)
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>    
    @enderror
</div>