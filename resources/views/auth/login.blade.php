<x-guest-layout>
    <x-auth-session-status class="mb-4 text-sm text-tr-ok" :status="session('status')" />

    <h1 class="font-display font-bold text-xl text-tr-text mb-6">Sign in</h1>

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" type="email" name="email" :value="old('email')"
                required autofocus autocomplete="username" placeholder="you@company.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
        </div>

        <div>
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" type="password" name="password"
                required autocomplete="current-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
        </div>

        <div class="flex items-center justify-between">
            <label class="flex items-center gap-2 cursor-pointer group">
                <input type="checkbox" name="remember"
                    class="w-4 h-4 rounded border-tr-border bg-tr-raised text-tr-accent focus:ring-tr-accent/30 focus:ring-1 transition-colors">
                <span class="text-sm text-tr-muted group-hover:text-tr-text transition-colors">Remember me</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-xs text-tr-dim hover:text-tr-accent transition-colors" href="{{ route('password.request') }}">
                    Forgot password?
                </a>
            @endif
        </div>

        <div class="pt-1">
            <x-primary-button class="w-full justify-center py-2.5 text-sm">
                Sign in →
            </x-primary-button>
        </div>
    </form>

    @if (Route::has('register'))
        <p class="mt-6 text-center text-sm text-tr-muted">
            No account?
            <a href="{{ route('register') }}" class="text-tr-accent hover:text-tr-accent-h font-medium transition-colors">
                Create one
            </a>
        </p>
    @endif
</x-guest-layout>
