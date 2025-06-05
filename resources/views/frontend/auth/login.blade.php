@extends('layouts.site')

@section('content')
    <!-- HORUS Login Container -->
    <div class="horus-login-container">
        <div class="horus-login-form">
            <h2 class="horus-login-title">Sign In</h2>
            
            <!-- Login Form -->
            <form method="POST" action="{{ url('login') }}">
                @csrf
                
                <!-- Email -->
                <div class="horus-login-form-group">
                    <label class="horus-login-label">EMAIL <span class="required">*</span></label>
                    <input type="email" class="horus-login-input" name="email" value="{{ old('email') }}" required>
                    @error('email')
                        <small class="horus-error-message">{{ $errors->first('email') }}</small>
                    @enderror
                </div>

                <!-- Password -->
                <div class="horus-login-form-group">
                    <label class="horus-login-label">PASSWORD <span class="required">*</span></label>
                    <input type="password" class="horus-login-input" name="password" required>
                    @error('password')
                        <small class="horus-error-message">{{ $errors->first('password') }}</small>
                    @enderror
                </div>

                <!-- Sign Up Link -->
                <div class="horus-login-signup-link">
                    <a href="#ws-register-modal" data-toggle="modal">Click here to sign up for an account</a>
                </div>

                <!-- Sign In Button -->
                <button class="horus-login-btn" type="submit">SIGN IN</button>
            </form>
        </div>
    </div>

    <!-- Register Modal -->
    <div class="modal fade horus-register-modal" id="ws-register-modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <a class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </a>
                </div>

                <div class="modal-body">
                    <form class="ws-register-form">
                        @csrf
                        <h3>Create An Account</h3>
                        <div class="ws-separator"></div>
                        
                        <!-- Name -->
                        <div class="form-group">
                            <label class="control-label">Name <span>*</span></label>
                            <input type="text" class="form-control" id="regName">
                        </div>

                        <!-- Email -->
                        <div class="form-group">
                            <label class="control-label">Email Address <span>*</span></label>
                            <input type="email" class="form-control" id="regEmail">
                        </div>
                        
                        <!-- Phone -->
                        <div class="form-group">
                            <label class="control-label">Phone <span>*</span></label>
                            <input type="tel" class="form-control" id="regPhone">
                        </div>

                        <!-- Area -->
                        <div class="form-group">
                            <label class="control-label">Area <span>*</span></label>
                            <select class="form-control" id="regArea">
                                @foreach ($areas as $area)
                                    <option value="{{ $area->id }}">
                                        {{ $area->name }} - {{ $area->arabic_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <!-- Gender -->
                        <div class="form-group">
                            <label class="control-label">Gender <span>*</span></label>
                            <select class="form-control" id="regGender">
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
                        
                        <!-- Confirm Password -->
                        <div class="form-group">
                            <label class="control-label">Confirm Password <span>*</span></label>
                            <input type="password" class="form-control" id="regConfPass">
                        </div>
                        
                        <!-- Address -->
                        <div class="form-group">
                            <label class="control-label">Address</label>
                            <textarea class="form-control" name="address" rows="3" id="regAddress"></textarea>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <!-- Create Account Button -->
                    <button class="btn ws-btn-fullwidth" onclick="submitRegForm()">Create Account</button>
                    
                    <!-- Sign In Link -->
                    <div class="ws-register-link" style="margin-top: 20px;">
                        <a href="#" data-dismiss="modal">Already have an account? Sign in here.</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
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
