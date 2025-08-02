<div class="py-2 px-3 inline-block bg-white border border-gray-200 rounded-lg dark:bg-neutral-900 dark:border-neutral-700" data-hs-input-number-{{ $detalleId }}="input-container">
    <div class="flex items-center gap-x-1.5">
        <!-- Botón Decrementador -->
        <button type="button" class="size-6 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-md border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-800 dark:focus:bg-neutral-800" tabindex="-1" aria-label="Decrease" data-hs-input-number-{{ $detalleId }}-decrement="decrement">
            <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M5 12h14"></path>
            </svg>
        </button>

        <!-- Input Numérico -->
        <input class="p-0 w-6 bg-transparent border-0 text-gray-800 text-center focus:ring-0 [&::-webkit-inner-spin-button]:appearance-none [&::-webkit-outer-spin-button]:appearance-none dark:text-white" style="-moz-appearance: textfield;" type="number" aria-roledescription="Number field" value="0" min="{{ $min }}" max="{{ $max }}" data-hs-input-number-{{ $detalleId }}-input="input-number">

        <!-- Botón Incrementador -->
        <button type="button" class="size-6 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-md border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-800 dark:focus:bg-neutral-800" tabindex="-1" aria-label="Increase" data-hs-input-number-{{ $detalleId }}-increment="increment">
            <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M5 12h14"></path>
                <path d="M12 5v14"></path>
            </svg>
        </button>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const min = {{ $min }};
        const max = {{ $max }};
        
        const decrementButton = document.querySelector('[data-hs-input-number-{{ $detalleId }}-decrement]');
        const incrementButton = document.querySelector('[data-hs-input-number-{{ $detalleId }}-increment]');
        const inputField = document.querySelector('[data-hs-input-number-{{ $detalleId }}-input]');

        function updateButtonState() {
            const currentValue = parseInt(inputField.value);
            decrementButton.disabled = currentValue <= min;
            incrementButton.disabled = currentValue >= max;
        }

        updateButtonState();

        decrementButton.addEventListener('click', function() {
            let currentValue = parseInt(inputField.value);
            if (currentValue > min) {
                inputField.value = currentValue - 1;
            }
            updateButtonState();
        });

        incrementButton.addEventListener('click', function() {
            let currentValue = parseInt(inputField.value);
            if (currentValue < max) {
                inputField.value = currentValue + 1;
            }
            updateButtonState();
        });

        inputField.addEventListener('input', function() {
            let value = parseInt(inputField.value);
            if (isNaN(value) || value < min) {
                inputField.value = min;
            } else if (value > max) {
                inputField.value = max;
            }
            updateButtonState();
        });
    });
</script>
