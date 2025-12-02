<div class="flex flex-col gap-6 mx-auto w-120 mt-10">
    <x-auth-header :title="__('Log in to your account')" :description="__('Enter your email and password below to log in')" />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form method="POST" wire:submit="login" class="flex flex-col gap-6">
        <!-- Email Address -->
        <x-input
            wire:model.live="email"
            :label="__('Email address')"
            type="email"
            required
            autofocus
            autocomplete="email"
            placeholder="email@example.com"
        />

        <!-- Password -->
        <div class="relative">
            <x-input
                wire:model.live="password"
                :label="__('Password')"
                type="password"
                required
                autocomplete="current-password"
                :placeholder="__('Password')"
                viewable
            />

            @if (Route::has('password.request'))
                <x-link class="absolute top-0 text-sm end-0" :href="route('password.request')" :label="__('Forgot your password?')" wire:navigate />
            @endif
        </div>

        <!-- Remember Me -->
        <x-checkbox wire:model.live="remember" :label="__('Remember me')" />

        <div class="flex items-center justify-end">
            <x-button primary type="submit" class="w-full" data-test="login-button" :label="__('Log in')" />
        </div>
    </form>

    @if (Route::has('register'))
        <div class="space-x-1 text-sm text-center rtl:space-x-reverse text-zinc-600 dark:text-zinc-400">
            <span>{{ __('Don\'t have an account?') }}</span>
            <x-link :href="route('register')" wire:navigate :label="__('Sign up')" />
        </div>
    @endif
</div>
