<section>
    <div class="mb-8">
        <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200">
            {{ __('Profile Information') }}
        </h2>
        <p class="text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </div>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    
    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div class="grid sm:grid-cols-12 gap-2 sm:gap-6"> 
            <div class="sm:col-span-3">
                <label for="name" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                  {{ __('Full name') }}
                </label>
                
            </div>

            <div class="sm:col-span-9">
                <div class="sm:flex">
                  <input id="name" name="name" type="text" class="py-2 px-3 pe-11 block w-full border-gray-200  -mt-px -ms-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-s-lg sm:mt-0 sm:first:ms-0 sm:first:rounded-se-none sm:last:rounded-es-none sm:last:rounded-e-lg text-sm relative focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" placeholder="Maria" value="{{old('name', $user->name)}}" required autofocus autocomplete="name">
                  <input id="lastname" name="lastname" type="text" class="py-2 px-3 pe-11 block w-full border-gray-200  -mt-px -ms-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-s-lg sm:mt-0 sm:first:ms-0 sm:first:rounded-se-none sm:last:rounded-es-none sm:last:rounded-e-lg text-sm relative focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" placeholder="Boone" value="{{old('lastname', $user->lastname)}}" required autofocus autocomplete="lastname">
                </div>
    
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>

            <div class="sm:col-span-3">
                <label for="email" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                  {{ __('Email') }}
                </label>
            </div>
              <!-- End Col -->
      
            <div class="sm:col-span-9">
                <input name="email" id="email" type="email" class="py-2 px-3 pe-11 block w-full border-gray-200  text-sm rounded-lg focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" placeholder="maria@site.com" value="{{ old('email', $user->email) }}" required autocomplete="username">
                
                <x-input-error class="mt-2" :messages="$errors->get('email')" />

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
                @endif
            </div>
            <!-- End Col -->
        </div>

        <div class="mt-5 flex justify-end gap-x-2">
            <button type="submit" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                {{ __('Save') }}
            </button>
        </div>
    </form>
</section>
