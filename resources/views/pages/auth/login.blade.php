<?php
use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use App\Livewire\Forms\Auth\LoginForm;
new #[Layout('layouts.auth')] class extends Component {
    public LoginForm $form;
    public function login()
    {
        $this->form->login();
    }
};
?>
<div>
    <form wire:submit.prevent='login()'>
        <div class="login-userset rounded">
            <div class="login-userheading">
                <h3>Sign In</h3>
                <h4>Access the Dreamspos panel using
                    your email and passcode.</h4>
            </div>
            @error('form.login')
                <div class="my-3 text-center">
                    <div class="alert alert-solid-danger alert-dismissible fade show">
                        {{ $message }}
                    </div>
                </div>
            @enderror
            <div class="form-login">
                <label class="form-label">Email
                    Address</label>
                <div class="form-addons">
                    <input
                        class="form-control"
                        type="email"
                        placeholder="Enter Email Address"
                        wire:model="form.email"
                    >
                    <x-img src="assets/img/icons/mail.svg" alt="img" />
                </div>
                @error('form.email')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-login">
                <label>Password</label>
                <div class="pass-group">
                    <input
                        class="pass-input"
                        type="password"
                        placeholder="Enter Password"
                        wire:model='form.password'
                    >
                    <span class="fas toggle-password fa-eye-slash"></span>
                </div>
                @error('form.password')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-login authentication-check">
                <div class="row">
                    <div class="col-6">
                        <div class="custom-control custom-checkbox">
                            <label class="checkboxs line-height-1 mb-0 pb-0 ps-4">
                                <input type="checkbox" wire:model='form.remember'>
                                <span class="checkmarks"></span>Remember
                                me
                            </label>
                        </div>
                    </div>
                    <div class="col-6 text-end">
                        <a class="forgot-link" href="forgot-password-3.html">Forgot
                            Password?</a>
                    </div>
                </div>
            </div>
            <div class="form-login">
                <button
                    class="btn btn-login"
                    type="submit"
                    wire:loading.attr='disabled'
                    wire:target='login()'
                >

                    <span wire:loading.remove wire:target='login()'>Login</span>
                    <span wire:loading wire:target='login()'>Submitting...</span>
                </button>
            </div>
            <div class="signinform">
                <h4>New on our platform?<a class="hover-a mx-2" href="{{ route('register') }}"> Create an
                        account</a></h4>
            </div>
        </div>
    </form>
</div>
