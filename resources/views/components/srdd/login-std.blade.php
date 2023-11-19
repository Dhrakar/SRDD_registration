{{-- 
  -- Login form component 
  --}}

  <div class="ml-8 mr-3 mt-2 mb-10 px-2 py-4 rounded-sm border-l-8 border-green-700 bg-green-50 shadow-md text-sm">
    {{-- Get Session Info --}}
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <h2>Non UA SSO Login</h2>
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mx-2 grid grid-cols-6 auto-col-max-6 gap-1">
            {{-- email address --}}
            <x-srdd.form-label class="col-span-1" for="email" :value="__('Email')" />
            <x-srdd.form-txt-input class="col-span-4" id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
            <div class="col-span-1">&nbsp;</div>
            {{-- password --}}
            <x-srdd.form-label class="col-span-1" for="password" :value="__('Password')" />
            <x-srdd.form-txt-input class="col-span-4" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
            <div class="col-span-1">&nbsp;</div>
            {{-- Store in session --}}
            <div class="col-span-1">&nbsp;</div>
            <div class="col-span-1 mt-2">
                <input id="remember_me" type="checkbox" class="text-right rounded border-indigo-900 text-slate-600" name="remember">
                <span class="text-slate-700 text-sm text-left">{{ __('Remember me')}}</span> 
            </div> 
            <div class="col-span-2 mt-2">
                @if (Route::has('password.request'))
                <a class="inline-flex items-center mt-2 px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150"
                    href="{{ route('password.request') }}">           
                    {{__('Forgot your Password?') }}
                </a>
                @else
                    &nbsp;
                @endif
            </div>
            <x-primary-button class="col-span-1 mt-2 px-4">
                {{ __('Log in') }}
            </x-primary-button>
        </div>

    </form>
</div>