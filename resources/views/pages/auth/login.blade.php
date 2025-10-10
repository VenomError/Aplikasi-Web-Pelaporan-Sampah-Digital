<?php
use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
new #[Layout('layouts.auth')] class extends Component {};
?>
<div>
    <form action="/auth/login">
        <div class="login-userset">
            <div class="login-userheading">
                <h3>Sign In</h3>
                <h4>Access the Dreamspos panel using
                    your email and passcode.</h4>
            </div>
            <div class="form-login">
                <label class="form-label">Email
                    Address</label>
                <div class="form-addons">
                    <input class="form-control" type="text">
                    <x-img src="assets/img/icons/mail.svg" alt="img" />
                </div>
            </div>
            <div class="form-login">
                <label>Password</label>
                <div class="pass-group">
                    <input class="pass-input" type="password">
                    <span class="fas toggle-password fa-eye-slash"></span>
                </div>
            </div>
            <div class="form-login authentication-check">
                <div class="row">
                    <div class="col-6">
                        <div class="custom-control custom-checkbox">
                            <label class="checkboxs line-height-1 mb-0 pb-0 ps-4">
                                <input type="checkbox">
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
                <button class="btn btn-login" type="submit">Sign In</button>
            </div>
            <div class="signinform">
                <h4>New on our platform?<a class="hover-a mx-2" href="{{ route('register') }}"> Create an
                        account</a></h4>
            </div>
        </div>
    </form>
</div>
