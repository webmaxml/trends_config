<? 
global $config;

require 'head.php' 
?>
<body class="login">
<div>
	<div class="login_wrapper">

		<? switch ( $_GET[ 'login_status' ] ) { 
			   case '1': ?>
				<div class="alert alert-danger alert-dismissible" style="position: absolute; top: -30px; width: 100%">
					<button type="button" class="close" data-dismiss="alert">
						<span>&times;</span>
					</button>
		 			Невереный логин или пароль!
				</div>
				<? break; ?>
			<? case '2' ?>
				<!-- for changing password - success -->
				<? break; ?>
			<? case '3' ?>
				<!-- for changing password - failure -->
				<? break; ?>
		<? } ?>

		<div class="form login_form">
			<section class="login_content">
				<form action="/login" method="post">
					<h1>Trends Config</h1>
					<div>
						<input type="text" class="form-control" placeholder="Логин" required="" name="login" />
					</div>
					<div>
						<input type="password" class="form-control" placeholder="Пароль" required="" name="password" />
					</div>
					<div>
						<button class="btn btn-primary submit btn-lg">Войти</button>
					</div>
				</form>
			</section>
		</div>

	</div>
</div>

	<!-- jQuery -->
    <script src="/assets/vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="/assets/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- PNotify -->
    <script src="/assets/vendors/pnotify/dist/pnotify.js"></script>
    <script src="/assets/vendors/pnotify/dist/pnotify.buttons.js"></script>
    <script src="/assets/vendors/pnotify/dist/pnotify.nonblock.js"></script>
    <!-- Custom Theme Scripts -->
    <script src="/assets/js/custom.js"></script>
    <script src="/assets/js/main.js"></script>

</body>
</html>