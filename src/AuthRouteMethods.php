<?php

namespace Laravel\Ui;

class AuthRouteMethods
{
    /**
     * Register the typical authentication routes for an application.
     *
     * @param  array  $options
     * @return void
     */
    public function auth()
    {
        return function ($options = []) {
            $namespace = $options['namespace'] ?? 'App\Http\Controllers\\';

            // Authentication Routes...
            $this->get('login', $namespace . 'Auth\LoginController@showLoginForm')->name('login');
            $this->post('login', $namespace . 'Auth\LoginController@login');
            $this->post('logout', $namespace . 'Auth\LoginController@logout')->name('logout');

            // Registration Routes...
            if ($options['register'] ?? true) {
                $this->get('register', $namespace . 'Auth\RegisterController@showRegistrationForm')->name('register');
                $this->post('register', $namespace . 'Auth\RegisterController@register');
            }

            // Password Reset Routes...
            if ($options['reset'] ?? true) {
                $this->resetPassword($namespace);
            }

            // Password Confirmation Routes...
            if ($options['confirm'] ??
                class_exists($this->prependGroupNamespace('Auth\ConfirmPasswordController'))) {
                $this->confirmPassword($namespace);
            }

            // Email Verification Routes...
            if ($options['verify'] ?? false) {
                $this->emailVerification($namespace);
            }
        };
    }

    /**
     * Register the typical reset password routes for an application.
     *
     * @return void
     */
    public function resetPassword($namespace)
    {
        return function () {
            $this->get('password/reset', $namespace . 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
            $this->post('password/email', $namespace . 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
            $this->get('password/reset/{token}', $namespace . 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
            $this->post('password/reset', $namespace . 'Auth\ResetPasswordController@reset')->name('password.update');
        };
    }

    /**
     * Register the typical confirm password routes for an application.
     *
     * @return void
     */
    public function confirmPassword($namespace)
    {
        return function () {
            $this->get('password/confirm', $namespace . 'Auth\ConfirmPasswordController@showConfirmForm')->name('password.confirm');
            $this->post('password/confirm', $namespace . 'Auth\ConfirmPasswordController@confirm');
        };
    }

    /**
     * Register the typical email verification routes for an application.
     *
     * @return void
     */
    public function emailVerification($namespace)
    {
        return function () {
            $this->get('email/verify', $namespace . 'Auth\VerificationController@show')->name('verification.notice');
            $this->get('email/verify/{id}/{hash}', $namespace . 'Auth\VerificationController@verify')->name('verification.verify');
            $this->post('email/resend', $namespace . 'Auth\VerificationController@resend')->name('verification.resend');
        };
    }
}
