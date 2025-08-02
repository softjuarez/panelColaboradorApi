<x-app-layout>
@section('breadcrumbs')
<li class="text-sm">
    <a class="flex items-center text-sm text-gray-500 hover:text-blue-600 focus:outline-none focus:text-blue-600 dark:focus:text-blue-500" href="#">
        <svg class="flex-shrink-0 mx-2 overflow-visible h-4 w-4 text-gray-400 dark:text-neutral-600" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
        {{ __('Profile') }}
    </a>
</li>
@endsection

<x-toast :show="session('status') != '' ? true : false" :type="session('status')" :message="session('message')"/>
<!-- Card Section -->
<div class="max-w-[100rem] px-4 py-2 sm:px-6 lg:px-8 lg:py-2 mx-auto">
    <!-- Card -->
    <div class="bg-white rounded-xl shadow p-4 sm:p-7 dark:bg-slate-900">    
        @include('profile.partials.update-profile-information-form')
    </div>
    <!-- End Card -->
</div>
<!-- End Card Section -->

<!-- Card Section -->
<div class="max-w-[100rem] px-4 py-2 sm:px-6 lg:px-8 lg:py-2 mx-auto">
    <!-- Card -->
    <div class="bg-white rounded-xl shadow p-4 sm:p-7 dark:bg-slate-900">
        @include('profile.partials.update-password-form')
    </div>
    <!-- End Card -->
</div>
<!-- End Card Section -->
</x-app-layout>
