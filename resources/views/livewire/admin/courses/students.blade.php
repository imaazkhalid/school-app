<div>
    <div class="flex items-center justify-between">
        <div class="flex justify-center items-center gap-4">
            <flux:button icon="arrow-left" variant="ghost"
                         :href="route('admin.courses.sections.index', ['course' => $section->course_id])"
                         :current="request()->routeIs('admin.courses.students.index')" wire:navigate/>
            <h1 class="text-2xl font-bold">{{ __('Students for: ') }} {{ $section->name }}</h1>
        </div>
    </div>

    <div
        class="mt-4 overflow-hidden rounded-xl border border-neutral-200 bg-white shadow dark:border-zinc-700 dark:bg-zinc-800">
        <div class="min-w-full overflow-x-auto">
            <table class="min-w-full divide-y divide-neutral-200 dark:divide-zinc-700">
                <thead>
                <tr class="bg-neutral-50 dark:bg-zinc-900">
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-neutral-500 dark:text-neutral-400">{{ __('Student Name') }}</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-neutral-500 dark:text-neutral-400">{{ __('Grade') }}</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-neutral-200 dark:divide-zinc-700">
                @forelse ($students as $student)
                    <tr>
                        <td class="whitespace-nowrap px-6 py-3 text-sm font-medium text-neutral-900 dark:text-neutral-100">{{ $student->user->name }}</td>
                        <td class="whitespace-nowrap px-6 py-3 text-sm text-neutral-500 dark:text-neutral-400">{{ $student->pivot->grade ?? 'N/A' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2"
                            class="px-6 py-4 text-center text-sm text-neutral-500 dark:text-neutral-400">{{ __('No students found for this course.') }}</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
