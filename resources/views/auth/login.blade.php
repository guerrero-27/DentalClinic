<x-guest-layout>
    <div class="text-center mb-8">
        <h1 class="text-4xl font-bold text-blue-900 mb-2">DentalCare</h1>
        <p class="text-gray-600">Your Smile, Our Priority</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    @if ($errors->any())
        <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-4">
            <p class="text-red-800 text-sm font-semibold mb-2">Login Failed</p>
            @foreach ($errors->all() as $error)
                <p class="text-red-700 text-sm">• {{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email Address')" class="text-gray-700 font-semibold" />
            <x-text-input 
                id="email" 
                class="block mt-2 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                type="email" 
                name="email" 
                :value="old('email')" 
                required 
                autofocus 
                autocomplete="username"
                placeholder="you@example.com"
            />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" class="text-gray-700 font-semibold" />
            <x-text-input 
                id="password" 
                class="block mt-2 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                type="password"
                name="password"
                required 
                autocomplete="current-password"
                placeholder="••••••••"
            />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input 
                    id="remember_me" 
                    type="checkbox" 
                    class="rounded border-gray-300 text-blue-600 focus:ring-blue-500 cursor-pointer" 
                    name="remember"
                >
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
            
            @if (Route::has('password.request'))
                <a class="text-sm text-blue-600 hover:text-blue-800 font-medium" href="{{ route('password.request') }}">
                    {{ __('Forgot password?') }}
                </a>
            @endif
        </div>

        <!-- Login Button -->
        <button 
            type="submit" 
            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-lg transition duration-200 ease-in-out transform hover:scale-105"
        >
            {{ __('Log In') }}
        </button>

        <!-- Register Link -->
        <p class="text-center text-gray-600 text-sm">
            Don't have an account?
            <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-800 font-semibold">
                Register here
            </a>
        </p>
    </form>

    <!-- Demo Credentials Info -->
    <div class="mt-8 pt-6 border-t border-gray-200">
        <p class="text-xs text-gray-500 text-center mb-2 font-semibold">DEMO CREDENTIALS</p>
        <div class="bg-blue-50 rounded-lg p-3 space-y-1">
            <p class="text-xs text-gray-700"><strong>Admin:</strong> test@example.com / password</p>
            <p class="text-xs text-gray-700"><strong>Client:</strong> client@gmail.com / password</p>
        </div>
    </div>
</x-guest-layout>
