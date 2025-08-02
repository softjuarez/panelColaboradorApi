<section>
    <div class="mb-8">
        <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200">
            {{ __('Update Password') }}
        </h2>
        <p class="text-sm text-gray-600 dark:text-gray-400">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </div>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div class="grid sm:grid-cols-12 gap-2 sm:gap-6"> 
            <div class="sm:col-span-3">
                <label for="name" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                  {{ __('Current Password') }}
                </label>
                
            </div>

            <div class="sm:col-span-9">
                <div class="sm:flex">
                    <input id="update_password_current_password" name="current_password" type="password" class="py-2 px-3 pe-11 block w-full border-gray-200  text-sm rounded-lg focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" placeholder="Current Password" required>
                </div>
    
                <x-input-error class="mt-2" :messages="$errors->updatePassword->get('current_password')" />
            </div>

            <div class="sm:col-span-3">
                <label for="name" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                  {{ __('New Password') }}
                </label>
                
            </div>

            <div class="sm:col-span-9">
                <!-- Strong Password -->
                <div class="flex">
                    <div class="relative flex-1">
                        <input name="password" type="password" id="hs-strong-password-with-indicator-and-hint-in-popover" class="py-2 px-4 block w-full  border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" placeholder="Enter password">
                        
                        <div id="hs-strong-password-popover" class="hidden absolute z-10 w-full bg-white shadow-md rounded-lg p-4 dark:bg-gray-800 dark:border dark:border-gray-700 dark:divide-gray-700">
                            <div id="hs-strong-password-in-popover" data-hs-strong-password='{
                                "target": "#hs-strong-password-with-indicator-and-hint-in-popover",
                                "hints": "#hs-strong-password-popover",
                                "stripClasses": "hs-strong-password:opacity-100 hs-strong-password-accepted:bg-teal-500 h-2 flex-auto rounded-full bg-blue-500 opacity-50 mx-1",
                                "mode": "popover",
                                "minLength": "8"
                            }' class="flex mt-2 -mx-1">
                            </div>

                            <h4 class="mt-3 text-sm font-semibold text-gray-800 dark:text-white">
                                Your password must contain:
                            </h4>

                            <ul class="space-y-1 text-sm text-gray-500">
                                <li data-hs-strong-password-hints-rule-text="min-length" class="hs-strong-password-active:text-teal-500 flex items-center gap-x-2">
                                  <span class="hidden" data-check>
                                    <svg class="flex-shrink-0 w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                  </span>
                                  <span data-uncheck>
                                    <svg class="flex-shrink-0 w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                                  </span>
                                  {{ __('Minimum number of characters is 8')  }}.
                                </li>
                                <li data-hs-strong-password-hints-rule-text="lowercase" class="hs-strong-password-active:text-teal-500 flex items-center gap-x-2">
                                  <span class="hidden" data-check>
                                    <svg class="flex-shrink-0 w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                  </span>
                                  <span data-uncheck>
                                    <svg class="flex-shrink-0 w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                                  </span>
                                  {{ __('Should contain lowercase') }}.
                                </li>
                                <li data-hs-strong-password-hints-rule-text="uppercase" class="hs-strong-password-active:text-teal-500 flex items-center gap-x-2">
                                  <span class="hidden" data-check>
                                    <svg class="flex-shrink-0 w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                  </span>
                                  <span data-uncheck>
                                    <svg class="flex-shrink-0 w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                                  </span>
                                  {{ __('Should contain uppercase') }}.
                                </li>
                                <li data-hs-strong-password-hints-rule-text="numbers" class="hs-strong-password-active:text-teal-500 flex items-center gap-x-2">
                                  <span class="hidden" data-check>
                                    <svg class="flex-shrink-0 w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                  </span>
                                  <span data-uncheck>
                                    <svg class="flex-shrink-0 w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                                  </span>
                                  {{ __('Should contain numbers') }}.
                                </li>
                                <li data-hs-strong-password-hints-rule-text="special-characters" class="hs-strong-password-active:text-teal-500 flex items-center gap-x-2">
                                  <span class="hidden" data-check>
                                    <svg class="flex-shrink-0 w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                  </span>
                                  <span data-uncheck>
                                    <svg class="flex-shrink-0 w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                                  </span>
                                  {{ __('Should contain special characters') }}.
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- End Strong Password -->
    
                <x-input-error class="mt-2" :messages="$errors->updatePassword->get('password')" />
            </div>

            <div class="sm:col-span-3">
                <label for="name" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                  {{ __('Confirm Password') }}
                </label>
            </div>

            <div class="sm:col-span-9">
                <div class="sm:flex">
                    <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="py-2 px-3 pe-11 block w-full border-gray-200  text-sm rounded-lg focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" placeholder="Current Password" required>
                </div>
    
                <x-input-error class="mt-2" :messages="$errors->updatePassword->get('password_confirmation')" />
            </div>
        </div>


        <div class="mt-5 flex justify-end gap-x-2">
            <button type="submit" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                {{ __('Save') }}
            </button>
        </div>
    </form>
</section>
