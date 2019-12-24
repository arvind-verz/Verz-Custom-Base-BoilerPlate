<footer class="footer-container">
			<div class="container">
				<div class="row">
					<div class="col-xl-3 col-lg-3 col-md-3">	
						<a class="logo" href="{{url('/')}}">													
							<img src="images/law-society-logo.png" alt="Law Society" />
						</a>
					</div>	
					<div class="col-xl-6 col-lg-5 col-md-4">	
						<div class="info">
							<h4>Support</h4>
							<div class="row">
								<div class="col-6">					
									<ul class="links">
										{!!get_parent_menu(2,$page->id)!!}
									</ul>
								</div>
								<div class="col-6">						
									<ul class="links">
										{!!get_parent_menu(3,$page->id)!!}
									</ul>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xl-3 col-lg-4 col-md-5">	
						<h4>Connect With Us</h4>
						<ul class="socials">
							<li><a class="fab fa-facebook" href="https://www.facebook.com/" target="_blank">facebook</a></li>
							<li><a class="fab fa-linkedin" href="https://www.linkedin.com/" target="_blank">linkedin</a></li>
						</ul>
						<a href="#" class="btn-1 btn-block">Visit Law Society Website <i class="fas fa-external-link-alt"></i></a>
					</div>	
				</div>
			</div>		
			<div class="copyright">
				<div class="container">
					&copy; Copyright 2019 by The Law Society Singapore
				</div>
			</div>
        </footer>