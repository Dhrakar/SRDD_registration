{{-- 
  -- Login form component 
  --}}

{{-- Get Session Info --}}
<x-auth-session-status class="mb-4" :status="session('status')" />
<x-srdd.notice :title="__('Custom Login (not UA Single Sign-On)')">
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
</x-srdd.notice>
<x-srdd.divider />
<x-srdd.notice :title="__('University of Alaska Google SSO')">
    <span>
        To login, first click the **Signin with Google** button and sign in to (or select) your UA account. 
    Please note that the only data used from your account is your UA username@alaska.edu email. This is 
    because we use your UA email to generate an account for you automatically. When using the UA 
    SSO authentication, a dummy password is used to ensure that your account can't be signed in to via the non-SSO
    option. Once you have finished getting your UA authentication, the **Continue** button will be activated.
    Click that button to finish logging in.
    </span>
    <x-srdd.divider />
    <div class="flex justify-between">
        <div id="buttonDiv" class="flex w-auto px-4"></div>
        <div class="flex px-4">
        <form name="gsuite_login" method="POST" action="{{ route('ualogin') }}">
            @csrf
            
            <input type='hidden' id="gs_login_email" name='email' value='unset'/>
            <input type='hidden' id="gs_login_id" name='name' value='unset'/>
            <input type='hidden' id="gs_login_token" name='token' value='unset'/>
            <x-primary-button id="gs_login_submit" class='mt-2 px-4' disabled>
                Continue
            </x-primary-button>
        </form>
        </div>
    </div>
</x-srdd.notice>

<!-- script to process the UA auth -->

<script  type="module">
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
    }
    window.onload = function () {
      google.accounts.id.initialize({
        client_id: "{{ env('UA_CLIENT_ID') }}",
        callback: handleCredentialResponse
      });
      google.accounts.id.renderButton(
        document.getElementById("buttonDiv"),
        { theme: "outline", size: "large" }  // customization attributes
      );
    }
</script>