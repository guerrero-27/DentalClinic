@props([
    'name' => '',
    'options' => [],
    'selected' => '',
    'placeholder' => 'Select an option',
    'icon' => 'fa-solid fa-chevron-down'
])

<div class="relative" x-data="{ open: false, selected: '{{ $selected }}' }" @click.outside="open = false" @keydown.escape.window="open = false">
    <input type="hidden" name="{{ $name }}" x-model="selected">
    
    <button 
        type="button"
        @click="open = !open"
        class="w-full flex items-center justify-between px-3 md:px-4 py-2 md:py-2.5 text-sm border-2 rounded-xl bg-white transition-all duration-300 ease-in-out
               hover:border-gray-300 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200"
        :class="open ? 'border-blue-500 ring-2 ring-blue-200' : 'border-gray-200'"
    >
        <span class="flex items-center gap-2" x-text="selected || '{{ $placeholder }}'"></span>
        <i class="{{ $icon }} text-gray-400 text-xs transition-transform duration-300" :class="open ? 'rotate-180' : ''"></i>
    </button>
    
    <div 
        x-show="open"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 -translate-y-2 scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
        x-transition:leave-end="opacity-0 -translate-y-2 scale-95"
        class="absolute z-50 w-full mt-2 bg-white border border-gray-200 rounded-xl shadow-xl overflow-hidden"
        style="display: none;"
    >
        <div class="py-1 max-h-60 overflow-auto">
            @foreach($options as $value => $label)
            <button 
                type="button"
                @click="selected = '{{ $label }}'; open = false"
                class="w-full flex items-center justify-between px-4 py-2.5 text-sm text-gray-700 hover:bg-blue-50 transition-colors duration-150"
                :class="selected === '{{ $label }}' ? 'bg-blue-50 text-blue-700 font-semibold' : ''"
            >
                <span>{{ $label }}</span>
                <i x-show="selected === '{{ $label }}'" class="fa-solid fa-check text-blue-600"></i>
            </button>
            @endforeach
        </div>
    </div>
</div>
