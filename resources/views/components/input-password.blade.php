@props([
    'label' => 'Password',
    'name' => 'password',
    'placeholder' => 'Masukkan password...',
])

<div class="space-y-1" x-data="{ show: false }">
    <label class="block text-sm font-medium text-gray-700" for="{{ $name }}">
        {{ $label }}
    </label>

    <div class="relative">
        <input
            id="{{ $name }}"
            name="{{ $name }}"
            :type="show ? 'text' : 'password'"
            placeholder="{{ $placeholder }}"
            {{ $attributes->merge([
                'class' =>
                    'pass-input w-full rounded-lg border border-gray-300 px-3 py-2 pr-10 focus:border-blue-500 focus:ring-blue-500',
            ]) }}
        />

        <button
            class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500 hover:text-gray-700"
            type="button"
            @click="show = !show"
        >
            <i :class="show ? 'fas fa-eye' : 'fas fa-eye-slash'"></i>
        </button>
    </div>
</div>
