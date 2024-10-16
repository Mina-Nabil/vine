@extends('layouts.site')

@section('content')
    <!-- Page Content -->
    <div class="container ws-page-container">
        <div class="row">
            <div class="col-sm-6 col-sm-offset-3">

                <!-- Login Form -->
                <form class="ws-login-form">
                    <!-- Email -->
                    <div class="form-group">
                        <label class="control-label">Username or Email Adress <span>*</span></label>
                        <input type="email" class="form-control">
                    </div>

                    <!-- Password -->
                    <div class="form-group">
                        <label class="control-label">Password <span>*</span></label>
                        <input type="password" class="form-control">
                    </div>

                    <!-- Checkbox -->
                    <div class="pull-left">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox">Stay signed in
                            </label>
                        </div>
                    </div>

                    <div class="pull-right">
                        <div class="ws-forgot-pass">
                            <a href="#x">Forgot your password ?</a>
                        </div>
                    </div>

                    <div class="clearfix"></div>
                    <div class="padding-top-x50"></div>

                    <!-- Button -->
                    <a class="btn ws-btn-fullwidth">Sign in</a>
                    <br><br>
                    <div class="g_id_signin" style="margin-bottom:15px " data-type="standard" data-size="large" data-theme="outline" data-text="sign_in_with"
                    data-shape="rectangular" data-logo_alignment="left">
                </form>
                <!-- End Login Form -->

                <!-- Register Form-->
                <div class="ws-register-form">

                    <!-- Link -->
                    <div class="ws-register-link">
                        <a href="#ws-register-modal" data-toggle="modal">Click here to sign up for an account. </a>
                    </div>

                    <!-- Register Modal -->
                    <div class="modal fade" id="ws-register-modal" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">

                                <div class="modal-header">
                                    <a class="close" data-dismiss="modal" aria-label="Close"><span
                                            aria-hidden="true">&times;</span></a>
                                </div>

                                <div class="row">
                                    <div class="col-sm-10 col-sm-offset-1">

                                        <div class="modal-body">
                                            <!-- Register Form -->
                                            <form class="ws-register-form">

                                                <h3>Create An Account</h3>
                                                <div class="ws-separator"></div>
                                                <!-- Name -->
                                                <div class="form-group">
                                                    <label class="control-label">Name <span>*</span></label>
                                                    <input type="text" class="form-control">
                                                </div>

                                                <!-- Email -->
                                                <div class="form-group">
                                                    <label class="control-label">Email Adress <span>*</span></label>
                                                    <input type="email" class="form-control">
                                                </div>

                                                <!-- Password -->
                                                <div class="form-group">
                                                    <label class="control-label">Password <span>*</span></label>
                                                    <input type="password" class="form-control">
                                                </div>

                                                <div class="form-group">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox">I accept the <a href="faq.html">Terms of
                                                                Service</a>
                                                        </label>
                                                    </div>
                                                </div>

                                            </form>
                                        </div>

                                        <div class="modal-footer">
                                            <!-- Button -->
                                            <a class="btn ws-btn-fullwidth">Create Account</a>
                                            <br><br>
                                            <!-- Facebook Button -->
                                            <a class="btn ws-btn-facebook">Sign in with Facebook</a>
                                            <!-- Link -->
                                            <div class="ws-register-link">
                                                <a href="#ws-register-modal" data-toggle="modal">Already have an account?
                                                    Sign in here.</a>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- End Register Modal -->
                </div>
                <!-- End Register -->

            </div>
        </div>
    </div>
    <!-- End Page Content -->

    <script>
        function onSignIn(googleUser) {
            var profile = googleUser.getBasicProfile();
            console.log('ID: ' + profile.getId()); // Do not send to your backend! Use an ID token instead.
            console.log('Name: ' + profile.getName());
            console.log('Image URL: ' + profile.getImageUrl());
            console.log('Email: ' + profile.getEmail()); // This is null if the 'email' scope is not present.
        }
    </script>
@endsection
