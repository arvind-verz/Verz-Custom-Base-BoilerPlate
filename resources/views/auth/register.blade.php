@extends('layouts.app')

@section('content')
<div class="main-wrap login-wrap">   
				<div class="container">
					<div class="tb-col">
						<div class="bcol">
							<div class="box full">
								<h1 class="title-1 text-center">Register</h1>
								<div class="row sp-row-4 align-items-center content">
									<div class="col-md-6 bcol">
										<form action="register-step-1.html">
											<div class="radio-group">
												<div class="btnradio">
													<input id="applicant" type="radio" name="type" checked />
													<label for="applicant"><span>Job Applicant</span></label>
												</div>
												<div class="btnradio">
													<input id="recruiter" type="radio" name="type" />
													<label for="recruiter"><span>Recruiter</span></label>
												</div>
											</div>
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
											<div class="input-group ig-1 break-block-2">
												<div class="input-group-prepend">
													<span class="input-group-text"><span class="required">*</span> Confirm PASSWORD</span>
												</div>
												<input id="password-field-2" type="password" class="form-control" placeholder="Enter Password" />
												<div class="input-group-append">
													<span class="input-group-text"><span toggle="#password-field-2" class="fas fa-eye-slash toggle-password"></span></span>
												</div>
											</div>
											<button class="btn-1" type="submit">Next <i class="fas fa-angle-right"></i></button>
										</form>
									</div>
									<div class="or-2"><span>or</span></div>	
									<div class="col-md-6 bcol">				
										<h2 class="text-center">Register Via</h2>
										<a class="fab fa-linkedin-in btn-social" href="#">Login with LinkedIn</a>
										<a class="fab fa-google btn-social" href="#">Login with Google</a>
									</div>
								</div>		
								<div class="text-center"><a class="link-1" href="login.html">Already have an account with us? Login here.</a></div>
							</div>
						</div>
					</div>
				</div>
            </div>
@endsection
