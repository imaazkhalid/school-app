<div>
    <div class="flex items-center justify-between">
        <div class="flex justify-center items-center gap-4">
            <flux:button icon="arrow-left" variant="ghost" :href="route('admin.dashboard')" :current="request()->routeIs('admin.dashboard')" wire:navigate/>
            <h1 class="text-2xl font-bold">{{ __('Sections for: ') }} {{ $course->name }}</h1>
        </div>
        <flux:modal.trigger :name="'create-section-modal'">
            <flux:button icon="plus" class="flex-shrink-0">
                {{ __('Create Section') }}
            </flux:button>
        </flux:modal.trigger>
    </div>

    <div
        class="mt-4 overflow-hidden rounded-xl border border-neutral-200 bg-white shadow dark:border-zinc-700 dark:bg-zinc-800">
        <div class="min-w-full overflow-x-auto">
            <table class="min-w-full divide-y divide-neutral-200 dark:divide-zinc-700">
                <thead>
                <tr class="bg-neutral-50 dark:bg-zinc-900">
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-neutral-500 dark:text-neutral-400">{{ __('Section Name') }}</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-neutral-500 dark:text-neutral-400">{{ __('Teacher') }}</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-neutral-500 dark:text-neutral-400">{{ __('Schedule') }}</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-neutral-500 dark:text-neutral-400">{{ __('Capacity') }}</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-neutral-500 dark:text-neutral-400">{{ __('Available Seats') }}</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-neutral-500 dark:text-neutral-400">{{ __('Actions') }}</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-neutral-200 dark:divide-zinc-700">
                @forelse ($sections as $section)
                    <tr>
                        <td class="whitespace-nowrap px-6 py-3 text-sm font-medium text-neutral-900 dark:text-neutral-100">{{ $section->name }}</td>
                        <td class="whitespace-nowrap px-6 py-3 text-sm text-neutral-500 dark:text-neutral-400">{{ $section->teacher->user->name }}</td>
                        <td class="whitespace-nowrap px-6 py-3 text-sm text-neutral-500 dark:text-neutral-400">{{ $section->schedule }}</td>
                        <td class="whitespace-nowrap px-6 py-3 text-sm text-neutral-500 dark:text-neutral-400">{{ $section->capacity }}</td>
                        <td class="whitespace-nowrap px-6 py-3 text-sm text-neutral-500 dark:text-neutral-400">{{ $section->seats_available }}</td>
                        <td class="whitespace-nowrap px-6 py-3 text-sm text-neutral-500 dark:text-neutral-400">
                            <flux:dropdown>
                                <flux:button class="size-6 text-sm">
                                    <flux:icon.ellipsis-vertical variant="solid" class="size-4"/>
                                </flux:button>
                                <flux:menu>
                                    <flux:menu.item
                                        wire:click="edit({{ $section->id }})">{{ __('Edit Section') }}</flux:menu.item>
                                    <flux:menu.item wire:click="delete({{ $section->id }})"
                                                    class="text-red-500 hover:bg-red-500/10">{{ __('Delete Section') }}</flux:menu.item>
                                </flux:menu>
                            </flux:dropdown>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6"
                            class="px-6 py-4 text-center text-sm text-neutral-500 dark:text-neutral-400">{{ __('No sections found.') }}</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <flux:modal name="create-section-modal" wire:model.self="showCreateModal" @close="resetForm"
                class="w-full max-w-xl">
        <form wire:submit="save" class="grid gap-4">
            <div>
                <flux:heading size="lg">
                    {{ $editing ? __('Edit Section') : __('Create New Section') }}
                </flux:heading>
                <flux:text class="mt-2">
                    {{ $editing ? __('Update the details for this section.') : __('Enter the details for the new section.') }}
                </flux:text>
            </div>

            <flux:input label="Section Name" wire:model="name" placeholder="E.g. Introduction"/>

            <flux:select label="Teacher" wire:model="teacher_id">
                <option value="0" selected disabled>{{ __('Select a teacher') }}</option>
                @foreach ($teachers as $teacher)
                    <option value="{{ $teacher->id }}">{{ $teacher->user->name }}</option>
                @endforeach
            </flux:select>

            <flux:input label="Schedule" wire:model="schedule" placeholder="E.g. Mon, Wed, Fri 9:00 - 10:00"/>
            <flux:input type="number" label="Capacity" wire:model="capacity" placeholder="E.g. 30"/>

            <div class="flex gap-2">
                <flux:spacer/>
                <flux:modal.close>
                    <flux:button variant="ghost">{{ __('Cancel') }}</flux:button>
                </flux:modal.close>
                <flux:button type="submit" variant="primary" disabled wire:dirty.attr.remove="disabled">
                    {{ $editing ? __('Update Section') : __('Save Section') }}
                </flux:button>
            </div>
        </form>
    </flux:modal>

    <flux:modal name="delete-section-modal" wire:model.self="showDeleteModal" class="w-full max-w-md">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Delete Section</flux:heading>
                <flux:text class="mt-2">
                    Are you sure you want to delete the section"{{ $deleting?->name }}"? <br>
                    This action cannot be reversed.
                </flux:text>
            </div>
            <div class="flex gap-2">
                <flux:spacer/>
                <flux:modal.close>
                    <flux:button variant="ghost">Cancel</flux:button>
                </flux:modal.close>
                <flux:button wire:click="destroy" type="button" variant="danger">Delete Section</flux:button>
            </div>
        </div>
    </flux:modal>
</div>
