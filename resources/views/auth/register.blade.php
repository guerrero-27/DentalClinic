<x-guest-layout>
    <div class="text-center mb-8">
        <h1 class="text-4xl font-bold text-blue-900 mb-2">DentalCare</h1>
        <p class="text-gray-600">Create Your Account</p>
    </div>

    @if ($errors->any())
        <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-4">
            <p class="text-red-800 text-sm font-semibold mb-2">Registration Failed</p>
            @foreach ($errors->all() as $error)
                <p class="text-red-700 text-sm">• {{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Full Name')" class="text-gray-700 font-semibold" />
            <x-text-input 
                id="name" 
                class="block mt-2 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                type="text" 
                name="name" 
                :value="old('name')" 
                required 
                autofocus 
                autocomplete="name"
                placeholder="Juan Dela Cruz"
            />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

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
                autocomplete="username"
                placeholder="you@example.com"
            />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Phone -->
        <div>
            <x-input-label for="phone" :value="__('Phone Number')" class="text-gray-700 font-semibold" />
            <x-text-input 
                id="phone" 
                class="block mt-2 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                type="tel" 
                name="phone" 
                :value="old('phone')" 
                placeholder="09123456789"
            />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
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
                autocomplete="new-password"
                placeholder="••••••••"
            />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
            <p class="text-xs text-gray-500 mt-1">Must be at least 8 characters</p>
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-gray-700 font-semibold" />
            <x-text-input 
                id="password_confirmation" 
                class="block mt-2 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                type="password"
                name="password_confirmation" 
                required 
                autocomplete="new-password"
                placeholder="••••••••"
            />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Terms & Conditions (Optional) -->
        <div class="flex items-start">
            <input 
                type="checkbox" 
                id="terms" 
                class="mt-1 rounded border-gray-300 text-blue-600 focus:ring-blue-500 cursor-pointer" 
                required
            >
            <label for="terms" class="ms-2 text-sm text-gray-600">
                I agree to the 
                <a href="#" class="text-blue-600 hover:text-blue-800 font-medium">Terms & Conditions</a>
                and 
                <a href="#" class="text-blue-600 hover:text-blue-800 font-medium">Privacy Policy</a>
            </label>
        </div>

        <!-- Register Button -->
        <button 
            type="submit" 
            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-lg transition duration-200 ease-in-out transform hover:scale-105"
        >
            {{ __('Create Account') }}
        </button>

        <!-- Login Link -->
        <p class="text-center text-gray-600 text-sm">
            Already have an account?
            <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800 font-semibold">
                Log in here
            </a>
        </p>
    </form>
</x-guest-layout>
