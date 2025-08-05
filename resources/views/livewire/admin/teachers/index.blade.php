<div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
    <div class="flex items-center justify-between">
        <div class="flex justify-center items-center gap-4">
            <flux:button icon="arrow-left" variant="ghost" :href="route('admin.dashboard')"
                         :current="request()->routeIs('admin.teachers.index')" wire:navigate/>
            <h1 class="text-2xl font-bold">{{ __('Teachers Index') }}</h1>
        </div>
        <flux:button wire:click="$set('showCreateModal', true)" icon="plus">{{ __('Add Teacher') }}</flux:button>
    </div>

    <div
        class="mt-4 overflow-hidden rounded-xl border border-neutral-200 bg-white shadow dark:border-zinc-700 dark:bg-zinc-800">
        <div class="min-w-full overflow-x-auto">
            <table class="min-w-full divide-y divide-neutral-200 dark:divide-zinc-700">
                <thead>
                <tr class="bg-neutral-50 dark:bg-zinc-900">
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-neutral-500 dark:text-neutral-400">{{ __('Name') }}</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-neutral-500 dark:text-neutral-400">{{ __('Email') }}</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-neutral-500 dark:text-neutral-400">{{ __('Teacher ID') }}</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-neutral-200 dark:divide-zinc-700">
                @forelse ($teachers as $teacher)
                    <tr>
                        <td class="whitespace-nowrap px-6 py-5.5 text-sm font-medium text-neutral-900 dark:text-neutral-100">{{ $teacher->user->name }}</td>
                        <td class="whitespace-nowrap px-6 py-5.5 text-sm text-neutral-500 dark:text-neutral-400">{{ $teacher->user->email }}</td>
                        <td class="whitespace-nowrap px-6 py-5.5 text-sm text-neutral-500 dark:text-neutral-400">{{ $teacher->teacher_id }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3"
                            class="px-6 py-4 text-center text-sm text-neutral-500 dark:text-neutral-400">{{ __('No teachers found.') }}</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-4">
        {{ $teachers->links() }}
    </div>

    <flux:modal wire:model="showCreateModal" class="w-full max-w-xl">
        <div class="space-y-6">
            <flux:heading size="lg">{{ __('Create Teacher from User') }}</flux:heading>
            <flux:select wire:model="selectedUserId">
                <flux:select.option value="">{{ __('Select User') }}</flux:select.option>
                @foreach ($users as $user)
                    <flux:select.option value="{{ $user->id }}">
                        {{ $user->name }} ({{ $user->email }})
                    </flux:select.option>
                @endforeach
            </flux:select>
            <div class="flex justify-end gap-2">
                <flux:button variant="ghost"
                             wire:click="$set('showCreateModal', false)">{{ __('Cancel') }}</flux:button>
                <flux:button variant="primary" wire:click="createTeacher">{{ __('Create') }}</flux:button>
            </div>
        </div>
    </flux:modal>
</div>
