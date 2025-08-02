@props([
    'name',
    'options',
    'selected' => [],
    'multiple' => false,
    'placeholder' => 'Selecciona una opción',
    'id' => $name,
    'disabled' => false,
])

@php
    $processedSelected = array_map('strval', (array) $selected);
@endphp

<div
    x-data="selectSearch({
        options: {{ json_encode($options) }},
        selected: {{ json_encode($processedSelected) }},
        multiple: {{ $multiple ? 'true' : 'false' }},
        placeholder: '{{ $placeholder }}'
    })"
    x-init="init()"
    @click.outside="close()"
    class="relative w-full"
>
    <template x-if="!multiple">
        <input type="hidden" name="{{ $name }}" :value="selected[0] || ''" @disabled($disabled)>
    </template>
    <template x-if="multiple">
        <template x-for="value in selected" :key="value">
            <input type="hidden" name="{{ $name }}[]" :value="value" @disabled($disabled)>
        </template>
    </template>

    <button
        type="button"
        @click="if (!{{ $disabled ? 'true' : 'false' }}) toggle()"
        :class="{ 'ring-2 ring-blue-500': open }"
             @disabled($disabled)

        {{ $attributes->merge([
            'class' => '' .
                       ' disabled:bg-gray-50 disabled:text-gray-500 disabled:border-gray-200 disabled:cursor-not-allowed dark:disabled:bg-slate-800 dark:disabled:text-gray-400 dark:disabled:border-gray-700'
        ]) }}

        >
        <span class="flex items-center">
            <template x-if="isEmpty()">
                <span class="block truncate text-gray-800" x-text="placeholder"></span>
            </template>

            <template x-if="multiple && !isEmpty()">
                <div class="flex flex-wrap gap-1">
                    <template x-for="value in selected" :key="value">
                        <span class="flex items-center gap-x-1 rounded-full bg-blue-100 px-2 py-1 text-xs font-medium text-blue-800 dark:bg-blue-800 dark:text-blue-100">
                            <span x-text="options[value]"></span>
                            @if(!$disabled)
                            <svg @click.stop="deselectOption(value)" class="h-4 w-4 cursor-pointer hover:text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                            @endif
                        </span>
                    </template>
                </div>
            </template>

            <template x-if="!multiple && !isEmpty()">
                <span class="block truncate" x-text="options[selected[0]]"></span>
            </template>
        </span>

        <span class="pointer-events-none absolute inset-y-0 right-0 ml-3 flex items-center pr-2">
            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M10 3a.75.75 0 01.53.22l3.5 3.5a.75.75 0 01-1.06 1.06L10 4.81 6.53 8.28a.75.75 0 01-1.06-1.06l3.5-3.5A.75.75 0 0110 3zm-3.72 9.28a.75.75 0 011.06 0L10 15.19l3.47-3.47a.75.75 0 111.06 1.06l-4 4a.75.75 0 01-1.06 0l-4-4a.75.75 0 010-1.06z" clip-rule="evenodd" />
            </svg>
        </span>
    </button>

    <div
        x-show="open"
        x-transition:leave="transition ease-in duration-100"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="absolute z-10 mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm dark:bg-slate-800 dark:ring-gray-700"
        style="display: none;"
    >
        <div class="p-2">
            <input
                type="text"
                x-model.debounce.300ms="search"
                x-ref="search"
                @keydown.escape.prevent="close()"
                @keydown.enter.prevent="selectFirstOption()"
                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 dark:bg-slate-900 dark:border-gray-600 dark:focus:border-blue-500 dark:text-gray-300"
                placeholder="Buscar..."
            >
        </div>

        <ul x-ref="listbox">
            <template x-if="Object.keys(filteredOptions()).length === 0">
                 <li class="px-3 py-2 text-center text-gray-500">No se encontraron resultados</li>
            </template>
            <template x-for="(label, value) in filteredOptions()" :key="value">
                <li
                    @click="selectOption(value)"
                    :class="{ 'bg-blue-600 text-white': isSelected(value), 'text-gray-900 dark:text-gray-200': !isSelected(value) }"
                    class="relative cursor-pointer select-none py-2 pl-3 pr-9 hover:bg-blue-500 hover:text-white"
                >
                    <span class="block truncate" :class="{ 'font-semibold': isSelected(value), 'font-normal': !isSelected(value) }" x-text="label"></span>

                    <template x-if="isSelected(value)">
                        <span class="absolute inset-y-0 right-0 flex items-center pr-4 text-white">
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.052-.143z" clip-rule="evenodd" /></svg>
                        </span>
                    </template>
                </li>
            </template>
        </ul>
    </div>
</div>

<script>
    function selectSearch(config) {
        return {
            open: false,
            search: '',
            options: config.options || {},
            selected: config.selected || [],
            multiple: config.multiple || false,
            placeholder: config.placeholder || 'Selecciona una opción',

            init() {
                if (!this.multiple && this.selected.length > 1) {
                    this.selected = [this.selected[0]];
                }
                this.$watch('selected', () => {
                    this.$dispatch('input', this.multiple ? this.selected : this.selected[0]);
                });
            },

            toggle() {
                if (this.open) { return this.close(); }
                this.open = true;
                this.$nextTick(() => { this.$refs.search.focus(); });
            },

            close() {
                this.open = false;
                this.search = '';
            },

            selectOption(value) {
                const stringValue = String(value);

                if (!this.multiple) {
                    this.selected = [stringValue];
                    this.close();
                } else {
                    const index = this.selected.indexOf(stringValue);
                    if (index === -1) {
                        this.selected.push(stringValue);
                    } else {
                        this.selected.splice(index, 1);
                    }
                }
            },

            deselectOption(value) {
                const stringValue = String(value);
                const index = this.selected.indexOf(stringValue);
                if (index !== -1) {
                    this.selected.splice(index, 1);
                }
            },

            selectFirstOption() {
                const firstValue = Object.keys(this.filteredOptions())[0];
                if (firstValue) {
                    this.selectOption(firstValue);
                }
            },

            isSelected(value) {
                return this.selected.includes(String(value));
            },

            isEmpty() {
                return this.selected.length === 0;
            },

            filteredOptions() {
                if (this.search === '') {
                    return this.options;
                }
                return Object.fromEntries(
                    Object.entries(this.options).filter(([key, label]) =>
                        label.toLowerCase().includes(this.search.toLowerCase())
                    )
                );
            }
        }
    }
</script>
