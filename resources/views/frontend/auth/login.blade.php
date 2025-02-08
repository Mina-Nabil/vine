@extends('layouts.site')

@section('content')
    <!-- Page Content -->
    <div class="container ws-page-container">
        <div class="row">
            <div class="col-sm-6 col-sm-offset-3">

                <!-- Login Form -->
                <form class="ws-login-form" method="POST" action="{{ url('login') }}">
                    @csrf
                    <!-- Email -->
                    <div class="form-group">
                        <label class="control-label">Email <span>*</span></label>
                        <input type="email" class="form-control" name=email value="{{old('email')}}"  required>
                        @error('email')
                            <small class="text-danger"> {{ $errors->first('email') }} </small>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="form-group">
                        <label class="control-label">Password <span>*</span></label>
                        <input type="password" class="form-control" name=password  required >
                        @error('password')
                            <small class="text-danger"> {{ $errors->first('password') }} </small>
                        @enderror
                    </div>

                    <div class="pull-right">
                        <div class="ws-forgot-pass">
                            <a href="#ws-register-modal" data-toggle="modal">Click here to sign up for an account</a>
                        </div>
                    </div>

                    <div class="clearfix"></div>
                    <div class="padding-top-x50"></div>

                    <!-- Button -->
                    <button class="btn ws-btn-fullwidth" type=submit>Sign in</button>
                    <br><br>
                    {{-- <div class="g_id_signin" style="margin-bottom:15px " data-type="standard" data-size="large" data-theme="outline" data-text="sign_in_with"
                    data-shape="rectangular" data-logo_alignment="left"> --}}
                </form>
                <!-- End Login Form -->
                <div class="modal fade" id="ws-register-modal" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">

                            <div class="modal-header">
                                <a class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></a>
                            </div>

                            <div class="row">

                                @csrf

                                <div class="col-sm-10 col-sm-offset-1">

                                    <div class="modal-body">
                                        <!-- Register Form -->
                                        <form class="ws-register-form">

                                            <h3>Create An Account</h3>
                                            <div class="ws-separator"></div>
                                            <!-- Name -->
                                            <div class="form-group">
                                                <label class="control-label">Name <span>*</span></label>
                                                <input type="text" class="form-control" id="regName">
                                            </div>

                                            <!-- Email -->
                                            <div class="form-group">
                                                <label class="control-label">Email Adress <span>*</span></label>
                                                <input type="email" class="form-control" id="regEmail">
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">Phone <span>*</span></label>
                                                <input type="email" class="form-control" id="regPhone">
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label">Area <span>*</span></label>
                                                <select id="regArea">
                                                    @foreach ($areas as $area)
                                                        <option value="{{ $area->id }}">
                                                            {{ $area->name }} -
                                                            {{ $area->arabic_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">Gender <span>*</span></label>
                                                <select id="regGender">
                                                    @foreach ($genders as $gender)
                                                        <option value="{{ $gender->id }}">
                                                            {{ $gender->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <!-- Password -->
                                            <div class="form-group">
                                                <label class="control-label">Password <span>*</span></label>
                                                <input type="password" class="form-control" id="regPass">
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">Confirm Password <span>*</span></label>
                                                <input type="password" class="form-control" id="regConfPass">
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">Address</span></label>
                                                <textarea class="form-control" name="address" rows="3" id="regAddress">
                                                        </textarea>
                                            </div>

                                        </form>
                                    </div>

                                    <div class="modal-footer">
                                        <!-- Button -->
                                        <button class="btn ws-btn-fullwidth" onclick="submitRegForm()">Create
                                            Account</button>
                                        <br><br>

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

        function submitRegForm() {
            var name = document.getElementById('regName').value;
            var email = document.getElementById('regEmail').value;
            var phone = document.getElementById('regPhone').value;
            var area = document.getElementById('regArea').value;
            var gender = document.getElementById('regGender').value;
            var password = document.getElementById('regPass').value;
            var confirmPassword = document.getElementById('regConfPass').value;
            var address = document.getElementById('regAddress').value;

            $.ajax({
                url: '{{ $signUpUrl }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    name: name,
                    email: email,
                    mobile: phone,
                    area: area,
                    gender: gender,
                    password: password,
                    password_confirmation: confirmPassword,
                    address: address
                },
                success: function(response) {
                    if (response.success) {
                        alert('Registration successful!');
                        location.reload();
                    } else {
                        alert('Registration failed: ' + response.message);
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        var errors = xhr.responseJSON.errors;
                        var errorMessages = '';
                        for (var key in errors) {
                            if (errors.hasOwnProperty(key)) {
                                errorMessages += errors[key].join(' ') + ' - ';
                            }
                        }
                        Swal.fire({
                            text: errorMessages,
                            icon: "warning",
                            showCancelButton: true,
                        })

                    } else {
                        alert('An error occurred: ' + xhr.responseText);
                    }
                }
            });
        }
    </script>
@endsection
