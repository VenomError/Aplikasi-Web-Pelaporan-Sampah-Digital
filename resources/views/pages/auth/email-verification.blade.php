<?php
use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
new #[Layout('layouts.auth')] class extends Component {
    public function mount()
    {
        if (auth()->user()?->hasVerifiedEmail()) {
            return redirect()->route('home');
        }
    }
    public function resend()
    {
        if (auth()->user()->hasVerifiedEmail()) {
            return redirect('/');
        }
        auth()->user()->sendEmailVerificationNotification();
        sweetalert('Email Verification Sended');
        session()->flash('message', 'Link verifikasi telah dikirim ke email kamu!');
    }
};
?>
<div>
    <div class="login-userset">
        <a class="login-logo logo-white" href="index.html">
            <x-img src="assets/img/logo-white.png" alt="" />
        </a>
        <div class="login-userheading text-center">
            <h3>Verify Your Email</h3>
            <h4 class="verfy-mail-content">We've sent a link to your email <b class="text-primary">{{ auth()->user()->email }}</b> Please follow the
                link
                inside to continue</h4>
        </div>
        <div class="signinform text-center">
        </div>
        <div class="form-login">
             <button
                    class="btn btn-login"
                    wire:loading.attr='disabled'
                    wire:target='resend()'
                >

                    <span wire:loading.remove wire:target='resend()'>Resend</span>
                    <span wire:loading wire:target='resend()'>Sending...</span>
                </button>
        </div>
    </div>
</div>
