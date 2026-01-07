<div class="flex flex-1 h-screen">
    {{-- Left Side - Image/Illustration (full cover) --}}
    <div class="hidden lg:block lg:w-1/2 relative">
        {{-- Full-bleed image --}}
        <img
            src="https://img.freepik.com/free-photo/construction-site-sunset_23-2152006125.jpg?semt=ais_hybrid&w=740&q=80"
            alt="Login Illustration"
            class="absolute inset-0 w-full h-full object-cover"
        />

        {{-- Optional translucent gradient overlay to improve text contrast --}}
        <div class="absolute inset-0 bg-linear-to-br from-blue-600/40 to-blue-800/40"></div>

        {{-- Text content on top of the image --}}
        <div class="relative z-10 flex items-center justify-center h-full p-12">
            <div class="max-w-md text-white text-center">
                <h2 class="text-3xl font-bold mb-4">Welcome Back!</h2>
                <p class="text-blue-100">Sign in to access your dashboard and manage your application.</p>
            </div>
        </div>
    </div>

    {{-- Right Side - Login Form --}}
   <div class="flex-1 flex items-center justify-center p-8 bg-[linear-gradient(135deg,#c6e8ff,#93deff)]!">
    <div class="w-full max-w-md">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8">
            <div class="mb-8">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Hello!</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-2">Sign Up to Get Started</p>
            </div>

            {{-- Updated form structure for Filament v4 --}}
            <form wire:submit="authenticate" class="space-y-6">
                {{ $this->form }}

                <x-filament::button type="submit" class="w-full">
                    Login
                </x-filament::button>
            </form>

            @if (filament()->hasPasswordReset())
                <div class="mt-4 text-center">
                    <a href="{{ filament()->getPasswordResetUrl() }}" class="text-sm text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200">
                        Forgot Password
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
</div>