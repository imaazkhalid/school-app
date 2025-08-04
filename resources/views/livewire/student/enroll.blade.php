<div>
    <h1 class="text-2xl font-bold">{{ __('Enroll in New Courses') }}</h1>

    @if (session('status'))
        <div class="mt-4 rounded-md bg-green-50 p-4 dark:bg-green-950">
            <div class="flex">
                <p class="text-sm font-medium text-green-800 dark:text-green-200">
                    {{ session('status') }}
                </p>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="mt-4 rounded-md bg-red-50 p-4 dark:bg-red-950">
            <div class="flex">
                <p class="text-sm font-medium text-red-800 dark:text-red-200">
                    {{ session('error') }}
                </p>
            </div>
        </div>
    @endif

    <div
        class="mt-4 overflow-hidden rounded-xl border border-neutral-200 bg-white shadow dark:border-zinc-700 dark:bg-zinc-800">
        <div class="min-w-full overflow-x-auto">
            <table class="min-w-full divide-y divide-neutral-200 dark:divide-zinc-700">
                <thead>
                <tr class="bg-neutral-50 dark:bg-zinc-900">
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-neutral-500 dark:text-neutral-400">{{ __('Course') }}</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-neutral-500 dark:text-neutral-400">{{ __('Section Name') }}</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-neutral-500 dark:text-neutral-400">{{ __('Teacher') }}</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-neutral-500 dark:text-neutral-400">{{ __('Schedule') }}</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-neutral-500 dark:text-neutral-400">{{ __('Seats Available') }}</th>
                    <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-neutral-500 dark:text-neutral-400">{{ __('Actions') }}</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-neutral-200 dark:divide-zinc-700">
                @forelse ($availableSections as $section)
                    <tr>
                        <td class="whitespace-nowrap px-6 py-3 text-sm font-medium text-neutral-900 dark:text-neutral-100">{{ $section->course->name }}</td>
                        <td class="whitespace-nowrap px-6 py-3 text-sm font-medium text-neutral-500 dark:text-neutral-400">{{ $section->name }}</td>
                        <td class="whitespace-nowrap px-6 py-3 text-sm text-neutral-500 dark:text-neutral-400">{{ $section->teacher->user->name }}</td>
                        <td class="whitespace-nowrap px-6 py-3 text-sm text-neutral-500 dark:text-neutral-400">{{ $section->schedule }}</td>
                        <td class="whitespace-nowrap px-6 py-3 text-sm text-neutral-500 dark:text-neutral-400">{{ $section->seats_available }}</td>
                        <td class="whitespace-nowrap px-6 py-3 text-right text-sm">
                            <flux:button
                                wire:click="confirmEnrollment({{ $section->id }})"
                                variant="primary"
                                size="xs"
                            >
                                Enroll
                            </flux:button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6"
                            class="px-6 py-4 text-center text-sm text-neutral-500 dark:text-neutral-400">{{ __('No sections with available seats found.') }}</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">
        {{ $availableSections->links() }}
    </div>

    <flux:modal
        title="Confirm Enrollment"
        wire:model.self="isConfirmingEnrollment"
        class="w-full max-w-md"
    >
        <h1 class="text-xl font-bold">Confirm</h1>
        <p class="mt-4">Are you sure you want to enroll in "{{ $sectionToEnroll?->course->name }}"?</p>
        <div class="mt-4 flex justify-end gap-2">
            <flux:button variant="ghost" wire:click="$set('isConfirmingEnrollment', false)">
                Cancel
            </flux:button>
            <flux:button variant="primary" wire:click="enroll({{ $sectionToEnroll?->id }})">
                Enroll
            </flux:button>
        </div>
    </flux:modal>
</div>
