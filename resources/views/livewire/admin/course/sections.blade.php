<div>
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold">{{ __('Sections for: ') }} {{ $course->name }}</h1>
        <flux:button color="primary" icon="plus" class="flex-shrink-0">
            {{ __('Create Section') }}
        </flux:button>
    </div>

    <div
        class="mt-4 overflow-hidden rounded-xl border border-neutral-200 bg-white shadow dark:border-zinc-700 dark:bg-zinc-800">
        <div class="min-w-full overflow-x-auto">
            <table class="min-w-full divide-y divide-neutral-200 dark:divide-zinc-700">
                <thead>
                <tr class="bg-neutral-50 dark:bg-zinc-900">
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-neutral-500 dark:text-neutral-400">{{ __('Section Name') }}</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-neutral-500 dark:text-neutral-400">{{ __('Actions') }}</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-neutral-200 dark:divide-zinc-700">
                @forelse ($sections as $section)
                    <tr>
                        <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-neutral-900 dark:text-neutral-100">{{ $section->name }}</td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm text-neutral-500 dark:text-neutral-400">
                            <flux:dropdown>
                                <flux:button class="size-6 text-sm">
                                    <flux:icon.ellipsis-vertical variant="solid" class="size-4"/>
                                </flux:button>
                                <flux:menu>
                                    <flux:menu.item href="#">{{ __('Edit Section') }}</flux:menu.item>
                                    <flux:menu.item href="#"
                                                    class="text-red-500 hover:bg-red-500/10">{{ __('Delete Section') }}</flux:menu.item>
                                </flux:menu>
                            </flux:dropdown>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2"
                            class="px-6 py-4 text-center text-sm text-neutral-500 dark:text-neutral-400">{{ __('No sections found.') }}</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
