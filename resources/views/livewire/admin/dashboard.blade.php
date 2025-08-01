    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold">{{ __('Course Management') }}</h1>
            <flux:button href="#" wire:navigate color="primary" icon="plus" class="flex-shrink-0">
                {{ __('Create Course') }}
            </flux:button>
        </div>

        <div class="overflow-hidden rounded-xl border border-neutral-200 bg-white shadow dark:border-zinc-700 dark:bg-zinc-800">
            <div class="min-w-full overflow-x-auto">
                <table class="min-w-full divide-y divide-neutral-200 dark:divide-zinc-700">
                    <thead>
                    <tr class="bg-neutral-50 dark:bg-zinc-900">
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-neutral-500 dark:text-neutral-400">{{ __('Course Name') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-neutral-500 dark:text-neutral-400">{{ __('Course Code') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-neutral-500 dark:text-neutral-400">{{ __('Sections') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-neutral-500 dark:text-neutral-400">{{ __('Actions') }}</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-neutral-200 dark:divide-zinc-700">
                    @forelse ($courses as $course)
                        <tr>
                            <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-neutral-900 dark:text-neutral-100">{{ $course->name }}</td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-neutral-500 dark:text-neutral-400">{{ $course->code }}</td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-neutral-500 dark:text-neutral-400">{{ $course->sections_count }}</td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-neutral-500 dark:text-neutral-400">
                                <flux:dropdown>
                                    <flux:button icon="ellipsis-vertical"/>
                                    <flux:menu>
                                        <flux:menu.item href="#">{{ __('View Sections') }}</flux:menu.item>
                                        <flux:menu.item href="#">{{ __('Edit Course') }}</flux:menu.item>
                                        <flux:menu.item href="#" class="text-red-500 hover:bg-red-500/10">{{ __('Delete Course') }}</flux:menu.item>
                                    </flux:menu>
                                </flux:dropdown>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-sm text-neutral-500 dark:text-neutral-400">{{ __('No courses found.') }}</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
