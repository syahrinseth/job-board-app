<div
    x-data="{
        showSuccess: false,
        redirectToCheckout(jobId) {
            console.log('Redirect function called with jobId:', jobId);
            window.location.href = '/checkout?job_id=' + jobId;
        }
    }"
    @redirect-to-checkout.window="console.log('Event received:', $event.detail); redirectToCheckout($event.detail.jobId)"
>
    <!-- Success Message -->
    @if($success_message)
        <div x-show="showSuccess" x-init="showSuccess = true; setTimeout(() => showSuccess = false, 3000)"
             class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ $success_message }}</span>
        </div>
    @endif

    @if (session()->has('message'))
        <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
    @endif

    <!-- Error Message -->
    @if (session()->has('error'))
        <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <form wire:submit="save" class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Job Title -->
            <div class="md:col-span-2">
                <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Job Title <span class="text-red-500">*</span>
                </label>
                <input
                    type="text"
                    id="title"
                    wire:model="title"
                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                    placeholder="e.g. Senior Software Engineer"
                    required
                >
                @error('title')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Company -->
            <div>
                <label for="company" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Company <span class="text-red-500">*</span>
                </label>
                <input
                    type="text"
                    id="company"
                    wire:model="company"
                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                    placeholder="e.g. Tech Corp Inc."
                    required
                >
                @error('company')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Location -->
            <div>
                <label for="location" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Location <span class="text-red-500">*</span>
                </label>
                <input
                    type="text"
                    id="location"
                    wire:model="location"
                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                    placeholder="e.g. San Francisco, CA"
                    required
                >
                @error('location')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Job Type -->
            <div>
                <label for="job_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Job Type <span class="text-red-500">*</span>
                </label>
                <select
                    id="job_type"
                    wire:model="job_type"
                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                    required
                >
                    <option value="full-time">Full-time</option>
                    <option value="part-time">Part-time</option>
                    <option value="contract">Contract</option>
                    <option value="freelance">Freelance</option>
                    <option value="internship">Internship</option>
                </select>
                @error('job_type')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Work Type -->
            <div>
                <label for="work_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Work Type <span class="text-red-500">*</span>
                </label>
                <select
                    id="work_type"
                    wire:model="work_type"
                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                    required
                >
                    <option value="onsite">On-site</option>
                    <option value="remote">Remote</option>
                    <option value="hybrid">Hybrid</option>
                </select>
                @error('work_type')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Salary Range -->
            <div class="md:col-span-2">
                <label for="salary_range" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Salary Range <span class="text-red-500">*</span>
                </label>
                <input
                    type="text"
                    id="salary_range"
                    wire:model="salary_range"
                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                    placeholder="e.g. $80,000 - $120,000 per year"
                    required
                >
                @error('salary_range')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Job Description -->
            <div class="md:col-span-2">
                <div class="flex items-center justify-between mb-2">
                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Job Description <span class="text-red-500">*</span>
                    </label>
                    <div>
                        <button
                            type="button"
                            class="bg-blue-500 hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-700 text-white px-4 py-2 rounded mb-1 transition-colors"
                            wire:click="$dispatch('open-ai-modal')"
                        >
                            Generate with AI
                        </button>
                    </div>

                </div>
                {{-- <textarea
                    id="description"
                    wire:model="description"
                    rows="6"
                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                    placeholder="Describe the role, responsibilities, and what you're looking for in a candidate..."
                    required
                ></textarea> --}}
                <!-- Rich Text Editor -->
                <div
                    x-data="{
                        content: @entangle('description'),
                        editor: null,

                        init() {
                            this.setupEditor();
                        },

                        setupEditor() {
                            // For now, use contenteditable div with basic formatting
                            this.$refs.editor.innerHTML = this.content;

                            // Listen for content changes
                            this.$refs.editor.addEventListener('input', () => {
                                this.content = this.$refs.editor.innerHTML;
                            });

                            // Watch for external content updates (like from AI)
                            this.$watch('content', (newValue) => {
                                if (this.$refs.editor.innerHTML !== newValue) {
                                    this.$refs.editor.innerHTML = newValue;
                                }
                            });
                        },

                        formatText(command, value = null) {
                            document.execCommand(command, false, value);
                            this.content = this.$refs.editor.innerHTML;
                        },

                        isActive(command) {
                            return document.queryCommandState(command);
                        }
                    }"
                    x-init="init()"
                    wire:ignore
                    class="w-full"
                >
                    <!-- Toolbar -->
                    <div class="border border-gray-300 dark:border-gray-600 rounded-t-md bg-gray-50 dark:bg-gray-700 px-3 py-2 flex flex-wrap gap-1">
                        <button
                            type="button"
                            @click="formatText('bold')"
                            :class="{ 'bg-gray-300 dark:bg-gray-600': isActive('bold') }"
                            class="px-3 py-1 text-sm rounded hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors text-gray-700 dark:text-gray-300 font-bold"
                            title="Bold"
                        >
                            B
                        </button>

                        <button
                            type="button"
                            @click="formatText('italic')"
                            :class="{ 'bg-gray-300 dark:bg-gray-600': isActive('italic') }"
                            class="px-3 py-1 text-sm rounded hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors text-gray-700 dark:text-gray-300 italic"
                            title="Italic"
                        >
                            I
                        </button>

                        <button
                            type="button"
                            @click="formatText('underline')"
                            :class="{ 'bg-gray-300 dark:bg-gray-600': isActive('underline') }"
                            class="px-3 py-1 text-sm rounded hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors text-gray-700 dark:text-gray-300 underline"
                            title="Underline"
                        >
                            U
                        </button>

                        <div class="border-l border-gray-300 dark:border-gray-600 mx-1"></div>

                        <button
                            type="button"
                            @click="formatText('insertUnorderedList')"
                            :class="{ 'bg-gray-300 dark:bg-gray-600': isActive('insertUnorderedList') }"
                            class="px-3 py-1 text-sm rounded hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors text-gray-700 dark:text-gray-300"
                            title="Bullet List"
                        >
                            •
                        </button>

                        <button
                            type="button"
                            @click="formatText('insertOrderedList')"
                            :class="{ 'bg-gray-300 dark:bg-gray-600': isActive('insertOrderedList') }"
                            class="px-3 py-1 text-sm rounded hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors text-gray-700 dark:text-gray-300"
                            title="Numbered List"
                        >
                            1.
                        </button>

                        <div class="border-l border-gray-300 dark:border-gray-600 mx-1"></div>

                        <button
                            type="button"
                            @click="formatText('formatBlock', 'h2')"
                            class="px-3 py-1 text-sm rounded hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors text-gray-700 dark:text-gray-300 font-bold"
                            title="Heading"
                        >
                            H2
                        </button>

                        <button
                            type="button"
                            @click="formatText('formatBlock', 'p')"
                            class="px-3 py-1 text-sm rounded hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors text-gray-700 dark:text-gray-300"
                            title="Paragraph"
                        >
                            P
                        </button>
                    </div>

                    <!-- Editor Content -->
                    <div
                        x-ref="editor"
                        contenteditable="true"
                        class="rich-text-editor border border-t-0 border-gray-300 dark:border-gray-600 rounded-b-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white min-h-[150px] p-4 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                        placeholder="Describe the role, responsibilities, and what you're looking for in a candidate..."
                    ></div>
                </div>
                @error('description')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Requirements -->
            <div class="md:col-span-2">
                <label for="requirements" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Requirements <span class="text-red-500">*</span>
                </label>
                <textarea
                    id="requirements"
                    wire:model="requirements"
                    rows="4"
                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                    placeholder="List the required skills, experience, education, etc..."
                    required
                ></textarea>
                @error('requirements')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Form Actions -->
        <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200 dark:border-gray-600">
            <button
                type="button"
                wire:click="resetForm"
                class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-500 focus:outline-none focus:border-gray-700 focus:ring focus:ring-gray-200 active:bg-gray-600 disabled:opacity-25 transition"
            >
                Reset Form
            </button>

            <button
                type="submit"
                wire:loading.attr="disabled"
                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:ring focus:ring-indigo-200 active:bg-indigo-600 disabled:opacity-25 transition"
            >
                <span wire:loading.remove>
                    <svg class="w-4 h-4 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Post Job
                </span>
                <span wire:loading class="flex items-center">
                    <svg class="animate-spin -ml-1 mr-3 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Posting...
                </span>
            </button>
        </div>
    </form>
    <livewire:ai-text-modal />
</div>
