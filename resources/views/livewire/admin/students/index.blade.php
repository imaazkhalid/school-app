<div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
    <div class="flex items-center justify-between">
        <div class="flex justify-center items-center gap-4">
            <flux:button icon="arrow-left" variant="ghost"
                         :href="route('admin.dashboard')"
                         :current="request()->routeIs('admin.students.index')" wire:navigate/>
            <h1 class="text-2xl font-bold">{{ __('Students Index') }}</h1>
        </div>
    </div>

    <div
        class="mt-4 overflow-hidden rounded-xl border border-neutral-200 bg-white shadow dark:border-zinc-700 dark:bg-zinc-800">
        <div class="min-w-full overflow-x-auto">
            <table class="min-w-full divide-y divide-neutral-200 dark:divide-zinc-700">
                <thead>
                <tr class="bg-neutral-50 dark:bg-zinc-900">
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-neutral-500 dark:text-neutral-400">{{ __('Name') }}</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-neutral-500 dark:text-neutral-400">{{ __('Email') }}</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-neutral-500 dark:text-neutral-400">{{ __('Student ID') }}</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-neutral-500 dark:text-neutral-400">{{ __('Actions') }}</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-neutral-200 dark:divide-zinc-700">
                @forelse ($students as $student)
                    <tr>
                        <td class="whitespace-nowrap px-6 py-3 text-sm font-medium text-neutral-900 dark:text-neutral-100">{{ $student->user->name }}</td>
                        <td class="whitespace-nowrap px-6 py-3 text-sm text-neutral-500 dark:text-neutral-400">{{ $student->user->email }}</td>
                        <td class="whitespace-nowrap px-6 py-3 text-sm text-neutral-500 dark:text-neutral-400">{{ $student->student_id }}</td>
                        <td class="whitespace-nowrap px-6 py-3 text-sm text-neutral-500 dark:text-neutral-400">
                            <flux:button
                                wire:click.prevent="showDetails({{ $student->id }})"
                            >
                                {{ __('View Details') }}
                            </flux:button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4"
                            class="px-6 py-4 text-center text-sm text-neutral-500 dark:text-neutral-400">{{ __('No students found.') }}</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-4">
        {{ $students->onEachSide(2)->links() }}
    </div>

    <flux:modal name="student-details-modal" wire:model="showDetailsModal" class="w-full max-w-2xl">
        @if($selectedStudent)
            <div class="space-y-4">
                <div>
                    <flux:heading size="lg" class="mb-2">{{ __('Enrolled Courses & Grades') }}</flux:heading>
                    <flux:heading class="font-bold mt-4 text-xl">{{ $selectedStudent->user->name }}</flux:heading>
                    <flux:text class="leading-6">
                        {{ $selectedStudent->user->email }}<br>
                        {{ __('Student ID:') }} {{ $selectedStudent->student_id }}
                    </flux:text>
                </div>
                <div
                    class="mt-4 overflow-hidden rounded-xl border border-neutral-200 bg-white shadow dark:border-zinc-700 dark:bg-zinc-800">
                    <div class="min-w-full overflow-x-auto">
                        <table class="min-w-full divide-y divide-neutral-200 dark:divide-zinc-700">
                            <thead>
                            <tr class="bg-neutral-50 dark:bg-zinc-900">
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-neutral-500 dark:text-neutral-400">{{ __('Course') }}</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-neutral-500 dark:text-neutral-400">{{ __('Section') }}</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-neutral-500 dark:text-neutral-400">{{ __('Grade') }}</th>
                            </tr>
                            </thead>
                            <tbody class="divide-y divide-neutral-200 dark:divide-zinc-700">
                            @forelse($selectedStudent->enrollments as $enrollment)
                                <tr>
                                    <td class="whitespace-nowrap px-6 py-5.5 text-sm font-medium text-neutral-900 dark:text-neutral-100">{{ $enrollment->section->course->name }}</td>
                                    <td class="whitespace-nowrap px-6 py-5.5 text-sm text-neutral-500 dark:text-neutral-400">{{ $enrollment->section->name }}</td>
                                    <td class="whitespace-nowrap px-6 py-5.5 text-sm text-neutral-500 dark:text-neutral-400">{{ $enrollment->grade ?? __('N/A') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3"
                                        class="px-6 py-4 text-center text-sm text-neutral-500 dark:text-neutral-400">
                                        {{ __('No enrollments found.') }}
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="flex justify-end gap-2">
                    <flux:modal.close>
                        <flux:button variant="ghost">{{ __('Close') }}</flux:button>
                    </flux:modal.close>
                    <flux:button
                        variant="primary"
                        onclick="window.open('{{ route('admin.students.result-card', $selectedStudent->id) }}', '_blank')"
                    >
                        {{ __('Generate Result Card') }}
                    </flux:button>
                </div>
            </div>
        @endif
    </flux:modal>
</div>
