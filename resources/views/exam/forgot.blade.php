@extends('layouts.app')
@section('title', 'Forgot Password')

@section("content")
<div class="container-fluid">
    <div class="row d-flex justify-content-center align-items-center min-vh-100">
        <div class="col-lg-4">
            <div class="card shadow">
                <div class="card-header">
                    <h2 class="fw-bold text-secondary">Forgot Password</h2>
                </div>
                <div class="card-body p-5">
                  <form action="#" method="POST" id="login_form">
                    @csrf
                    <div>
                        <div class="mb-3 text-secondary">
                            Enter your e-mail address. Reset password link will be sent.
                        </div>
                    </div>
                    <div class="md-3">
                        <input type="email" name="email" id="email" class="form-control rounded-0" placeholder="E-mail">
                        <div class="invalid-feedback"></div>
                    </div>
                    
                       
                    <div class="mb-3 d-grid">
                        <input type="submit" value="Reset Password" class="btn btn-dark rounded-0" id="forgot_btn">
                    </div>
                    <div class="text-center text-secondary">
                        <div>Back to<a href="/" class="text-decoration-none">Login Page</a></div>
                    </div>
                  </form>
                </div>
            </div>
        </div>
    </div>
</div>
    
@endsection

@section('script')
    
@endsection
