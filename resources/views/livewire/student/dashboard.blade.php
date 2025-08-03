<div>
    <h1 class="text-2xl font-bold">{{ __('My Enrolled Courses') }}</h1>

    <div class="mt-4 overflow-hidden rounded-xl border border-neutral-200 bg-white shadow dark:border-zinc-700 dark:bg-zinc-800">
        <div class="min-w-full overflow-x-auto">
            <table class="min-w-full divide-y divide-neutral-200 dark:divide-zinc-700">
                <thead>
                <tr class="bg-neutral-50 dark:bg-zinc-900">
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-neutral-500 dark:text-neutral-400">{{ __('Course') }}</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-neutral-500 dark:text-neutral-400">{{ __('Section Name') }}</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-neutral-500 dark:text-neutral-400">{{ __('Teacher') }}</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-neutral-500 dark:text-neutral-400">{{ __('Schedule') }}</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-neutral-500 dark:text-neutral-400">{{ __('Grade') }}</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-neutral-200 dark:divide-zinc-700">
                @forelse ($sections as $section)
                    <tr>
                        <td class="whitespace-nowrap px-6 py-3 text-sm font-medium text-neutral-900 dark:text-neutral-100">{{ $section->course->name }}</td>
                        <td class="whitespace-nowrap px-6 py-3 text-sm font-medium text-neutral-500 dark:text-neutral-400">{{ $section->name }}</td>
                        <td class="whitespace-nowrap px-6 py-3 text-sm text-neutral-500 dark:text-neutral-400">{{ $section->teacher->user->name }}</td>
                        <td class="whitespace-nowrap px-6 py-3 text-sm text-neutral-500 dark:text-neutral-400">{{ $section->schedule }}</td>
                        <td class="whitespace-nowrap px-6 py-3 text-sm text-neutral-500 dark:text-neutral-400">
                            {{ $section->pivot->grade ?? 'N/A' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-sm text-neutral-500 dark:text-neutral-400">{{ __('You are not enrolled in any sections yet.') }}</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
