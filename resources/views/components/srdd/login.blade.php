{{-- 
  -- Login form component 
  --}}
{{-- log --}}
{{ Log::debug("Opened Blade: login  - " . session('status') ); }}
{{-- Get Session Info --}}
<x-auth-session-status class="mb-4" :status="session('status')" />

<x-srdd.notice :title="__('University of Alaska Google SSO')">
    <span>
        {!! Str::inlineMarkdown(__('ui.markdown.gsuite')); !!}
    </span>
    
    <x-srdd.divider />
    
    <x-input-error :messages="$errors->get('email')" class="mt-2" />
    <div class="flex justify-between">
        <div id="buttonDiv" class="flex w-auto px-4"></div>
        <div class="flex px-4">
        <form name="gsuite_login" method="POST" action="{{ route('ualogin') }}">
            @csrf
            
            <input type='hidden' id="gs_login_email" name='email' value='unset'/>
            <input type='hidden' id="gs_login_id" name='name' value='unset'/>
            <input type='hidden' id="gs_login_token" name='token' value='unset'/>
            <button 
                type='submit' id="gs_login_submit" 
                class='mt-2 px-4 bg-slate-600 border border-slate-800 rounded-md font-semibold text-xs text-slate-200 uppercase tracking-widest' 
                disabled>
                Need Google Sign-in
            </button>
        </form>
        </div>
    </div>
</x-srdd.notice>

<x-srdd.divider />

<x-srdd.notice :title="__('Login Without a UA Single Sign-On Account')">
    <span>
        {!! Str::inlineMarkdown(__('ui.markdown.nonUALogin')); !!}
    </span>

    <form name="std_login" method="POST" action="{{ route('login') }}">
        @csrf
        <x-input-error :messages="$errors->get('email')" class="mt-2" />
        <x-input-error :messages="$errors->get('password')" class="mt-2" />
        <div class="mx-2 grid grid-cols-6 auto-col-max-6 gap-1">
            {{-- email address --}}
            <x-srdd.form-label class="col-span-1" for="email" :value="__('Email')" />
            <x-srdd.form-txt-input class="col-span-4" id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <div class="col-span-1">&nbsp;</div>
            {{-- password --}}
            <x-srdd.form-label class="col-span-1" for="password" :value="__('Password')" />
            <x-srdd.form-txt-input class="col-span-4" type="password" name="password" required autocomplete="current-password" />
            <div class="col-span-1">&nbsp;</div>
            {{-- Store in session --}}
            <div class="col-span-1">&nbsp;</div>
            <div class="col-span-2 mt-1">
                <input id="remember_me" type="checkbox" class="text-right rounded border-indigo-900 text-slate-600" name="remember">
                <x-srdd.form-label class="col-span-1" for="remember_me" :value="__('Remember me')" />
            </div> 
            <div class="col-span-3">&nbsp;</div>
            {{-- Buttons --}}
            <div class="col-span-1">&nbsp;</div>
            @if (Route::has('password.request'))
                <div class="col-span-3 mt-2">
                    <a class="inline-flex items-center mt-2 px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150"
                        href="{{ route('password.request') }}">           
                        {{__('Forgot your Password?') }}
                    </a>
                </div>
            @else
                <div class="col-span-3">&nbsp;</div>
            @endif
            <x-primary-button class="col-span-1 mt-2 px-4">
                {{ __('Log in') }}
            </x-primary-button>
            <div class="col-span-1">&nbsp;</div>
        </div>
    </form>
</x-srdd.notice>

<x-srdd.divider />

<x-srdd.notice :title="__('Register for a Non-UA Account')">
    <span>
        This link will allow you to register for a non-UA account that can be used to build a calendar or (if you are leading a session)
        get reports on session attendees.
    </span>

    <div class="mx-2 grid grid-cols-6 auto-col-max-6 gap-1">
        <div class="col-span-3 mt-2">
            <a class="inline-flex items-center mt-2 px-4 py-2 
                    bg-white border border-gray-300 rounded-md 
                    font-semibold text-xs text-gray-700 uppercase 
                    tracking-widest shadow-sm hover:bg-gray-50 
                    focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 
                    disabled:opacity-25 transition ease-in-out duration-150"
                href="{{ route('register') }}">           
                {{__('ui.link.register') }}
            </a>
        </div>
    </div>

</x-srdd.notice>


<!-- script to process the UA auth -->

<script  type="module">
    $(document).ready( function () {
      google.accounts.id.initialize({
        client_id: "{{ env('UA_CLIENT_ID') }}",
        callback: handleCredentialResponse
      });
      google.accounts.id.renderButton(
        document.getElementById("buttonDiv"),
        { theme: "outline", size: "large" }  // customization attributes
      );
    });
    function handleCredentialResponse(response) {
        // get the JWT credential blob
        var myCred = response.credential;
        // get the payload object
        var credPayload = KJUR.jws.JWS.readSafeJSONString(b64utoutf8(myCred.split(".")[1]));
        // now that we have a google login, append hidden data to form and also turn on the submit button
        $('#gs_login_email').val(credPayload.email);
        $('#gs_login_id').val(credPayload.name);
        $('#gs_login_token').val(myCred);
        $("#gs_login_submit").removeAttr("disabled");
        $("#gs_login_submit").html("Continue");
        $("#gs_login_submit").attr('class','mt-2 px-4 py-2 bg-green-500 border border-green-800 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest');
    };
</script>