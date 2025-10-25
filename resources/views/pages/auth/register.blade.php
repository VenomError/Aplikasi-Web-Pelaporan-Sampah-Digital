<?php
use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use App\Livewire\Forms\Auth\RegisterForm;
new #[Layout('layouts.auth')] class extends Component {
    public RegisterForm $form;
    public function register()
    {
        $this->form->register();
    }
};
?>
<div>
    <form wire:submit.prevent="register()">
        <div class="login-userset rounded">
            <div class="login-userheading">
                <h3>Register</h3>
                <h4>Access the Dreamspos panel using
                    your email and passcode.</h4>
            </div>
            <div class="form-login">
                <label class="form-label">Full Name</label>
                <div class="form-addons">
                    <input
                        class="form-control"
                        type="text"
                        placeholder="Enter Full Name"
                        wire:model="form.name"
                    >
                    <x-img src="assets/img/icons/users1.svg" alt="img" />
                </div>
                @error('form.name')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-login">
                <label class="form-label">Phone Number</label>
                <div class="form-addons">
                    <input
                        class="form-control"
                        type="tel"
                        placeholder="Enter Phone Number"
                        wire:model="form.phone"
                    >
                    <x-img src="assets/img/icons/users1.svg" alt="img" />
                </div>
                @error('form.phone')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
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
                <label class="form-label">Address</label>
                <div class="form-addons">
                    <textarea
                        class="form-control"
                        rows="5"
                        placeholder="Enter Address"
                        wire:model='form.address'
                    ></textarea>
                    <x-img src="assets/img/icons/mail.svg" alt="img" />
                </div>
                @error('form.address')
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
            <div class="form-login">
                <label>Password Confirmation</label>
                <div class="pass-group">
                    <input
                        class="pass-input"
                        type="password"
                        placeholder="Enter Password Confirmation"
                        wire:model='form.password_confirmation'
                    >
                    <span class="fas toggle-password fa-eye-slash"></span>
                </div>

            </div>
            <div class="form-login authentication-check">
                <div class="row">

                </div>
            </div>
            <div class="form-login">
                <button
                    class="btn btn-login"
                    type="submit"
                    wire:loading.attr='disabled'
                    wire:target='register()'
                >

                    <span wire:loading.remove wire:target='register()'>Register</span>
                    <span wire:loading wire:target='register()'>Submitting...</span>
                </button>
            </div>
            <div class="signinform">
                <h4>Already have account?<a class="hover-a mx-2" href="{{ route('login') }}"> Login here !</a></h4>
            </div>
        </div>
    </form>
</div>
