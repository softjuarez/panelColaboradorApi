@props([
    'message' => '',
    'show' => false,
    'type' => '',
])

<!-- Toast -->
<div 
    x-data="{
        show: @js($show),
    }"
    x-show="show"
    x-transition
    x-init="setTimeout(() => show = false, 4000)"
    class="{{ $show != '' ? '' : 'hidden' }} {{ $type == 'success' ? 'bg-teal-500' : 'bg-red-500' }} max-w-xs text-sm text-white rounded-xl shadow-lg fixed right-4 top-4 z-50" 
    role="alert"
>

    <div class="flex items-center p-4">
        <div>
            <svg class="h-4 w-4 text-white-500 mr-2" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
              <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
            </svg>
        </div>
      
        <div class="flex items-center">
            {{ __($message) }}
        </div>
  
        <div class="flex items-center">
            <button type="button" x-on:click="show = false" class="ml-2 h-5 w-5 rounded-lg text-white hover:text-white opacity-50 hover:opacity-100 focus:outline-none focus:opacity-100" data-hs-remove-element="#dismiss-toast">
                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
            </button>
        </div>
    </div>
</div>
<!-- End Toast -->
