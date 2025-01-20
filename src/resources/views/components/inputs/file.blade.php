@props(['id', 'name', 'label' => null, 'image' => null, 'required' => false])

<div class="mb-4">
    @if ($label)
        <label class="block text-gray-700" for="{{ $id }}">{{ $label }}</label>
    @endif
    @if ($image)
        <img
            src="{{ Storage::url($image) }}"
            class="w-1/3 rounded-lg mb-4"
        />
    @endif
    <input
        id="{{ $id }}"
        type="file"
        name="{{ $name }}"
        class="w-full px-4 py-2 border rounded focus:outline-none @error($name) border-red-500 @enderror"
        @if ($required) required @endif
    />
    @error($name)
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>    
    @enderror
</div>