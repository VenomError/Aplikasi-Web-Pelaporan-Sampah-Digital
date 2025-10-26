@props([
    'id' => 'modalDelete',
    'alertMessage' => 'Are you sure about this delete?',
    'description' => 'This action cannot be undone. The account and all associated data will be permanently removed.',
    'confirmAction' => null,
])
<x-modal id="{{ $id }}" backDrop>
    <div class="py-4 text-center">
        <i class="ri-error-warning-line text-danger display-3 mb-3"></i>

        <h5 class="mb-2">{{ $alertMessage }}</h5>
        <p class="text-muted mb-4">{{ $description }}</p>

        <div class="d-flex justify-content-center gap-3">
            <button
                class="btn btn-secondary px-4"
                type="button"
                @click="$dispatch('hide:modal', { id: '{{ $id }}' })"
            >
                <i class="ri-close-line me-1"></i> Cancel
            </button>

            <button
                class="btn btn-danger px-4"
                type="button"
                wire:click="{{ $confirmAction }}"
                wire:loading.attr="disabled"
                wire:target="{{ $confirmAction }}"
            >
                <i class="ri-delete-bin-6-line me-1"></i>
                <span wire:loading.remove wire:target="{{ $confirmAction }}">Confirm</span>
                <span wire:loading wire:target="{{ $confirmAction }}">Removing...</span>
            </button>
        </div>
    </div>
</x-modal>
