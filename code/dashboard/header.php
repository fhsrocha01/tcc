<?php
$id_logged = $_SESSION['id_user'];
$sql = "SELECT name, type FROM users WHERE id_user=$id_logged";
$result = mysql_query($sql,$connection) or die ("Error in table selection.");
$row_logged = mysql_fetch_assoc($result); // recebe os dados do result
$totalRows_logged = mysql_num_rows($result); // numero de registros encontrados
?>
<header id="header" class="clearfix" data-current-skin="blue">
	<ul class="header-inner">
		<li id="menu-trigger" data-trigger="#sidebar">
			<div class="line-wrap">
				<div class="line top"></div>
				<div class="line center"></div>
				<div class="line bottom"></div>
			</div>
		</li>

		<li class="logo hidden-xs">
			<a href="index.php">We Learn</a>
		</li>

		<li class="pull-right">
			<ul class="top-menu">
				<li id="top-search">
					<a href=""><i class="tm-icon zmdi zmdi-search"></i></a>
				</li>
				<li class="dropdown">
					<a data-toggle="dropdown" href=""><i class="tm-icon zmdi zmdi-account-circle"></i></a>
					<ul class="dropdown-menu dm-icon pull-right">
						<li class="skin-switch">
							<?php echo $row_logged['name']; ?>
						</li>
						<li class="divider"></li>
						<li>
							<a href="profile.php?id=<?php echo $_SESSION['id_user']; ?>"><i class="fa fa-user"></i> Perfil</a>
						</li>
						<li>
							<a href="settings.php"><i class="fa fa-cogs"></i> Configurações</a>
						</li>
						<li>
							<a href="logout.php"><i class="fa fa-sign-out"></i> Sair</a>
						</li>
					</ul>
				</li>
			</ul>
		</li>
	</ul>


	<!-- Top Search Content -->
	<div id="top-search-wrap">
		<div class="tsw-inner">
			<form method="POST"  action="index.php">
				<i id="top-search-close" class="zmdi zmdi-close-circle"></i>
				<input type="text" name='search_course' placeholder="Pesquise por cursos...">
			</form>
		</div>
	</div>
</header>
