<header class="header-container fixed-header">   
				<div class="container clearfix">
					<div class="logo">
						<a href="{{url('/')}}">													
							<img src="images/law-society-logo.png" alt="Law Society" />
						</a>
					</div>	
					<div class="btn-links hide-425">
						<a href="register.html">Register</a> / <a href="login.html">Login</a>
					</div>	
					<a href="#menu" class="control-page btn-menu">
						<span></span>
						<span></span>
						<span></span>
					</a>  	
					<nav id="menu" class="menu">	
						<div class="btn-links show-425">
							<a href="register.html">Register</a> / <a href="login.html">Login</a>
						</div>	
                        <ul>
						{!!get_parent_menu(1,$page->id)!!}
                        </ul>
					</nav>
				</div>
            </header>