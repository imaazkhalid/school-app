<div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
    <h1 class="text-2xl font-bold">{{ __('Admin Dashboard') }}</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="p-6 bg-white dark:bg-zinc-800 rounded-xl shadow border border-neutral-200 dark:border-zinc-700">
            <h2 class="text-xl font-semibold text-neutral-900 dark:text-neutral-100">{{ __('Total Courses') }}</h2>
            <p class="mt-2 text-3xl font-bold text-primary-500">{{ $courseCount }}</p>
        </div>
        <div class="p-6 bg-white dark:bg-zinc-800 rounded-xl shadow border border-neutral-200 dark:border-zinc-700">
            <h2 class="text-xl font-semibold text-neutral-900 dark:text-neutral-100">{{ __('Total Teachers') }}</h2>
            <p class="mt-2 text-3xl font-bold text-primary-500">{{ $teacherCount }}</p>
        </div>
        <div class="p-6 bg-white dark:bg-zinc-800 rounded-xl shadow border border-neutral-200 dark:border-zinc-700">
            <h2 class="text-xl font-semibold text-neutral-900 dark:text-neutral-100">{{ __('Total Students') }}</h2>
            <p class="mt-2 text-3xl font-bold text-primary-500">{{ $studentCount }}</p>
        </div>
    </div>
</div>
