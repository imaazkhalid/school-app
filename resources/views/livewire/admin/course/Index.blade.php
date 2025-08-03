<div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold">{{ __('Course Management') }}</h1>
        <flux:modal.trigger :name="'create-course-modal'">
            <flux:button color="primary" icon="plus" class="flex-shrink-0">
                {{ __('Create Course') }}
            </flux:button>
        </flux:modal.trigger>
    </div>

    <div
        class="overflow-hidden rounded-xl border border-neutral-200 bg-white shadow dark:border-zinc-700 dark:bg-zinc-800">
        <div class="min-w-full overflow-x-auto">
            <table class="min-w-full divide-y divide-neutral-200 dark:divide-zinc-700">
                <thead>
                <tr class="bg-neutral-50 dark:bg-zinc-900">
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-neutral-500 dark:text-neutral-400">{{ __('Course Name') }}</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-neutral-500 dark:text-neutral-400">{{ __('Course Code') }}</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-neutral-500 dark:text-neutral-400">{{ __('Sections') }}</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-neutral-500 dark:text-neutral-400">{{ __('Actions') }}</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-neutral-200 dark:divide-zinc-700">
                @forelse ($courses as $course)
                    <tr>
                        <td class="whitespace-nowrap px-6 py-3 text-sm font-medium text-neutral-900 dark:text-neutral-100">{{ $course->name }}</td>
                        <td class="whitespace-nowrap px-6 py-3 text-sm text-neutral-500 dark:text-neutral-400">{{ $course->code }}</td>
                        <td class="whitespace-nowrap px-6 py-3 text-sm text-neutral-500 dark:text-neutral-400">{{ $course->sections_count }}</td>
                        <td class="whitespace-nowrap px-6 py-3 text-sm text-neutral-500 dark:text-neutral-400">
                            <flux:dropdown>
                                <flux:button class="size-6 text-sm">
                                    <flux:icon.ellipsis-vertical variant="solid" class="size-4"/>
                                </flux:button>
                                <flux:menu>
                                    <flux:menu.item
                                        :href="route('admin.courses.sections', ['course' => $course->id])"
                                        wire:navigate
                                    >
                                        {{ __('View Sections') }}
                                    </flux:menu.item>
                                    <flux:menu.item wire:click="edit({{ $course->id }})">
                                        {{ __('Edit Course') }}
                                    </flux:menu.item>
                                    <flux:menu.item wire:click="delete({{ $course->id }})" class="text-red-500 hover:bg-red-500/10">
                                        {{ __('Delete Course') }}
                                    </flux:menu.item>
                                </flux:menu>
                            </flux:dropdown>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4"
                            class="px-6 py-4 text-center text-sm text-neutral-500 dark:text-neutral-400">{{ __('No courses found.') }}</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">
        {{ $courses->links('vendor/pagination/tailwind') }}
    </div>

    <flux:modal name="create-course-modal" wire:model.self="showCreateModal" class="w-xl" @close="resetForm">
        <form wire:submit="save" class="grid gap-4">
            <div>
                <flux:heading size="lg">
                    {{ $editing ? __('Edit Course') : __('Create New Course') }}
                </flux:heading>
                <flux:text class="mt-2">
                    {{ $editing ? __('Update the details for this course.') : __('Enter the details for the new course.') }}
                </flux:text>
            </div>

            <flux:input label="Course Name" wire:model="name" placeholder="E.g. Computer Science"/>
            <flux:input label="Course Code" wire:model="code" placeholder="E.g. CS101"/>
            <flux:textarea label="Description" wire:model="description"/>

            <div class="flex gap-2">
                <flux:spacer/>
                <flux:modal.close>
                    <flux:button variant="ghost">{{ __('Cancel') }}</flux:button>
                </flux:modal.close>
                <flux:button type="submit" variant="primary">
                    {{ __('Save Course') }}
                </flux:button>
            </div>
        </form>
    </flux:modal>

    <flux:modal name="delete-course-modal" wire:model.self="showDeleteModal" class="w-full max-w-md">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Delete Course</flux:heading>
                <flux:text class="mt-2">
                    Are you sure you want to delete the course "{{ $deleting?->name }}"? <br>
                    This action cannot be reversed.
                </flux:text>
            </div>
            <div class="flex gap-2">
                <flux:spacer/>
                <flux:modal.close>
                    <flux:button variant="ghost">Cancel</flux:button>
                </flux:modal.close>
                <flux:button wire:click="destroy" type="button" variant="danger">Delete Course</flux:button>
            </div>
        </div>
    </flux:modal>
</div>
