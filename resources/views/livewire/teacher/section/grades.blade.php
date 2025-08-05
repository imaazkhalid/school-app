<div>
    <div class="flex items-center justify-between">
        <div class="flex justify-center items-center gap-4">
            <flux:button icon="arrow-left" variant="ghost" :href="route('teacher.dashboard')"
                         :current="request()->routeIs('teacher.sections.grades')" wire:navigate/>
            <h1 class="text-2xl font-bold">{{ __('Grades for: ') }} {{ $section->name }}</h1>
        </div>
    </div>

    @if (session('status'))
        <div class="mt-4 rounded-md dark:bg-green-50 p-4 bg-green-200">
            <div class="flex">
                <div class="ml-3">
                    <p class="text-sm font-medium dark:text-green-800 text-green-900">
                        {{ session('status') }}
                    </p>
                </div>
            </div>
        </div>
    @endif

    <div
        class="mt-4 overflow-hidden rounded-xl border border-neutral-200 bg-white shadow dark:border-zinc-700 dark:bg-zinc-800">
        <div class="min-w-full overflow-x-auto">
            <table class="min-w-full divide-y divide-neutral-200 dark:divide-zinc-700">
                <thead>
                <tr class="bg-neutral-50 dark:bg-zinc-900">
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-neutral-500 dark:text-neutral-400">{{ __('Student Name') }}</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-neutral-500 dark:text-neutral-400">{{ __('Grade') }}</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-neutral-500 dark:text-neutral-400">{{ __('Marks') }}</th>
                    <th class="px-6 py-4"></th>
                </tr>
                </thead>
                <tbody class="divide-y divide-neutral-200 dark:divide-zinc-700">
                @forelse ($enrollments as $enrollment)
                    <tr wire:key="{{ $enrollment->id }}">
                        <td class="whitespace-nowrap px-6 py-3 text-sm font-medium text-neutral-900 dark:text-neutral-100">
                            {{ $enrollment->student->user->name }}
                        </td>
                        <td class="whitespace-nowrap px-6 py-3 text-sm text-neutral-500 dark:text-neutral-400">
                            {{ $enrollment->grade ?? 'N/A' }}
                        </td>
                        <td class="whitespace-nowrap px-6 py-3 text-sm text-neutral-500 dark:text-neutral-400">
                            {{ $enrollment->marks ?? 'N/A' }}
                        </td>
                        <td class="whitespace-nowrap px-6 py-3 text-sm">
                            <flux:button size="sm" variant="primary" wire:click="openEditModal({{ $enrollment->id }})">
                                {{ __('Edit') }}
                            </flux:button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4"
                            class="px-6 py-4 text-center text-sm text-neutral-500 dark:text-neutral-400">{{ __('No students found in this section.') }}</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <flux:modal name="edit-grade-modal" wire:model="editEnrollmentId" class="w-full max-w-md">
        <form wire:submit.prevent="saveGrade" class="space-y-4">
            <flux:heading size="lg">
                {{ __('Edit Marks for') }} {{ $editStudentName }}
            </flux:heading>
            <flux:field>
                <flux:label badge="Required">{{ __('Marks (0-100):') }}</flux:label>
                <flux:input type="number" wire:model="editMarks" min="0" max="100" required/>
                <flux:error name="editMarks"/>
            </flux:field>
            <div class="flex justify-end gap-2">
                <flux:button variant="ghost" wire:click="closeModal">{{ __('Cancel') }}</flux:button>
                <flux:button type="submit" variant="primary" disabled
                             wire:dirty.attr.remove="disabled">{{ __('Save') }}</flux:button>
            </div>
        </form>
    </flux:modal>
</div>
