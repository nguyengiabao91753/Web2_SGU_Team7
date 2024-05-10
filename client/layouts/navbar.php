<?php
require_once '../backend/Order.php';
?>
<header class="no-print">
	<!-- Header desktop -->
	<div class="container-menu-desktop">
		<!-- Topbar -->
		<div class="top-bar">
			<div class="content-topbar flex-sb-m h-full container">
				<div class="left-top-bar">
					Free shipping for standard order over $100
				</div>

				<div class="right-top-bar flex-w h-full">
					<a href="#" class="flex-c-m trans-04 p-lr-25">
						Help & FAQs
					</a>

					<?php if (!isset($_COOKIE['client'])) : ?>
						<a href="./pages/login.php" class="flex-c-m p-lr-10 trans-04">
							My Account
						</a>
					<?php else : ?>
						<a href="../backend/Logout.php?client=true" class="flex-c-m p-lr-10 trans-04">
							Logout
						</a>
					<?php endif; ?>

					<!-- <a href="#" class="flex-c-m trans-04 p-lr-25">
						EN
					</a>

					<a href="#" class="flex-c-m trans-04 p-lr-25">
						USD
					</a> -->
				</div>
			</div>
		</div>

		<div class="wrap-menu-desktop">
			<nav class="limiter-menu-desktop container">

				<!-- Logo desktop -->
				<a href="index" class="logo">
					<img src="images/icons/logo-01.png" alt="IMG-LOGO">
				</a>

				<!-- Menu desktop -->
				<div class="menu-desktop">
					<ul class="main-menu">
						<li>
							<a href="index.php">Home</a>
							<!-- <ul class="sub-menu">
									<li><a href="index.html">Homepage 1</a></li>
									<li><a href="home-02.html">Homepage 2</a></li>
									<li><a href="home-03.html">Homepage 3</a></li>
								</ul> -->
						</li>

						<li>
							<a href="?content=shop">Shop</a>
						</li>

						<li>
							<a href="?content=blog">Blog</a>
						</li>

						<li>
							<a href="?content=about">About</a>
						</li>

						<li>
							<a href="?content=contact">Contact</a>
						</li>
					</ul>
				</div>

				<!-- Icon header -->
				<div class="wrap-icon-header flex-w flex-r-m">
					<!-- <div class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 js-show-modal-search">
						<i class="zmdi zmdi-search"></i>
					</div> -->
					<?php
					if (isset($_COOKIE['client'])) $countitems = countItemsInOrder();
					?>
					<div class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 icon-header-noti js-show-cart" data-notify="<?php if (isset($countitems)) echo $countitems;
																																else echo 0  ?>">
						<i class="zmdi zmdi-shopping-cart"></i>
					</div>
					<?php if (isset($_COOKIE['client'])) : ?>
						<a href="?content=profile" class="dis-block icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11">
							<i class="fa fa-user"></i>
						</a>
					<?php endif; ?>
				</div>
			</nav>
		</div>
	</div>

	<!-- Header Mobile -->
	<div class="wrap-header-mobile">
		<!-- Logo moblie -->
		<div class="logo-mobile">
			<a href="index.html"><img src="images/icons/logo-01.png" alt="IMG-LOGO"></a>
		</div>

		<!-- Icon header -->
		<div class="wrap-icon-header flex-w flex-r-m m-r-15">
			<div class="icon-header-item cl2 hov-cl1 trans-04 p-r-11 js-show-modal-search">
				<i class="zmdi zmdi-search"></i>
			</div>

			<div class="icon-header-item cl2 hov-cl1 trans-04 p-r-11 p-l-10 icon-header-noti js-show-cart" data-notify="2">
				<i class="zmdi zmdi-shopping-cart"></i>
			</div>

			<a href="#" class="dis-block icon-header-item cl2 hov-cl1 trans-04 p-r-11 p-l-10">
				<i class="zmdi zmdi-favorite-outline"></i>
			</a>
		</div>

		<!-- Button show menu -->
		<div class="btn-show-menu-mobile hamburger hamburger--squeeze">
			<span class="hamburger-box">
				<span class="hamburger-inner"></span>
			</span>
		</div>
	</div>


	<!-- Menu Mobile -->
	<div class="menu-mobile">
		<ul class="topbar-mobile">
			<li>
				<div class="left-top-bar">
					Free shipping for standard order over $100
				</div>
			</li>

			<li>
				<div class="right-top-bar flex-w h-full">
					<a href="#" class="flex-c-m p-lr-10 trans-04">
						Help & FAQs
					</a>
					<?php if (!isset($_COOKIE['client'])) : ?>
						<a href="?content=login" class="flex-c-m p-lr-10 trans-04">
							My Account
						</a>
					<?php else : ?>
						<a href="?content=login" class="flex-c-m p-lr-10 trans-04">
							Profile
						</a>
					<?php endif; ?>
					<!-- <a href="#" class="flex-c-m p-lr-10 trans-04">
						EN
					</a>

					<a href="#" class="flex-c-m p-lr-10 trans-04">
						USD
					</a> -->
				</div>
			</li>
		</ul>

		<ul class="main-menu-m">
			<li>
				<a href="index">Home</a>
				<!-- <ul class="sub-menu-m">
						<li><a href="index.html">Homepage 1</a></li>
						<li><a href="home-02.html">Homepage 2</a></li>
						<li><a href="home-03.html">Homepage 3</a></li>
					</ul> -->
				<span class="arrow-main-menu-m">
					<i class="fa fa-angle-right" aria-hidden="true"></i>
				</span>
			</li>

			<li>
				<a href="?content=shop">Shop</a>
			</li>

			<li>
				<a href="?content=shopping-cart" class="label1 rs1" data-label1="hot">Features</a>
			</li>

			<li>
				<a href="?content=blog">Blog</a>
			</li>

			<li>
				<a href="?content=about">About</a>
			</li>

			<li>
				<a href="?content=contact">Contact</a>
			</li>
		</ul>
	</div>

	<!-- Modal Search -->
	<!-- <div class="modal-search-header flex-c-m trans-04 js-hide-modal-search">
		<div class="container-search-header">
			<button class="flex-c-m btn-hide-modal-search trans-04 js-hide-modal-search">
				<img src="images/icons/icon-close2.png" alt="CLOSE">
			</button>

			<form class="wrap-search-header flex-w p-l-15">
				<button class="flex-c-m trans-04">
					<i class="zmdi zmdi-search"></i>
				</button>
				<input class="plh3" type="text" name="search" placeholder="Search...">
			</form>
		</div>
	</div> -->
</header>