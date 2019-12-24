@extends('layouts.app')

@section('content')
<div class="main-wrap login-wrap">   
				<div class="container">
					<div class="tb-col">
						<div class="bcol">
							<div class="box">
								<h1 class="title-1 text-center">Login</h1>
								<a class="fab fa-linkedin-in btn-social" href="#">Login with LinkedIn</a>
								<a class="fab fa-google btn-social" href="#">Login with Google</a>
								<div class="or"><span>or</span></div>
								<div class="input-group ig-1 break-block">
									<div class="input-group-prepend">
										<span class="input-group-text"><span class="required">*</span> EMAIL</span>
									</div>
									<input type="text" class="form-control" placeholder="Enter Email Address" />
								</div>
								<div class="input-group ig-1 break-block-2">
									<div class="input-group-prepend">
										<span class="input-group-text"><span class="required">*</span> PASSWORD</span>
									</div>
									<input id="password-field" type="password" class="form-control" placeholder="Enter Password" />
									<div class="input-group-append">
										<span class="input-group-text"><span toggle="#password-field" class="fas fa-eye-slash toggle-password"></span></span>
									</div>
								</div>
								<div class="row forgot-wrap break-375">
									<div class="col-6 bcol">
										<div class="checkbox">
											<input type="checkbox" id="remember" />
											<label for="remember">Remember Me</label>
										</div>
									</div>
									<div class="col-6 bcol text-right">
										<a class="link-1" href="forgot-pass.html">Forgot Password?</a>
									</div>
								</div>
								<button class="btn-1" type="submit">Login Account</button>
								<div class="text-center space-4"><a class="link-1" href="register.html">Don’t have an account with us? Register now!</a></div>
							</div>
						</div> 
					</div>
				</div>
            </div>
@endsection
