<div>
    <div class="flex items-center justify-between">
        <div class="flex justify-center items-center gap-4">
            <flux:button icon="arrow-left" variant="ghost" :href="route('teacher.dashboard')"
                         :current="request()->routeIs('teacher.dashboard')" wire:navigate/>
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

    <form wire:submit="saveGrades" class="mt-4">
        <div
            class="overflow-hidden rounded-xl border border-neutral-200 bg-white shadow dark:border-zinc-700 dark:bg-zinc-800">
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
                        <tr wire:key="{{ $student->id }}">
                            <td class="whitespace-nowrap px-6 py-3 text-sm font-medium text-neutral-900 dark:text-neutral-100">{{ $student->user->name }}</td>
                            <td class="whitespace-nowrap px-6 py-3 text-sm text-neutral-500 dark:text-neutral-400">
                                <input type="number" class="w-full px-3 py-2 border rounded-md"
                                       min="0" max="100"
                                       wire:model="grades.{{ $student->id }}"/>
                                <div>
                                    @error('grades.' . $student->id)
                                        <span class="text-xs text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2"
                                class="px-6 py-4 text-center text-sm text-neutral-500 dark:text-neutral-400">{{ __('No students found in this section.') }}</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-4 flex justify-end">
            <flux:button type="submit" variant="primary">
                {{ __('Save Grades') }}
            </flux:button>
        </div>
    </form>
</div>
