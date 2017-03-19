<aside id="sidebar" class="sidebar c-overflow">

  <ul class="main-menu">
    <li>
      <a href="index.php"><i class="fa fa-home"></i> Home</a>
    </li>
    <li>
      <a href="index.php"><i class="fa fa-graduation-cap"></i> Cursos</a>
    </li>
    <li>
      <a href="teachers.php"><i class="zmdi zmdi-accounts"></i> Professores</a>
    </li>
    <li>
      <a href="students.php"><i class="zmdi zmdi-accounts-outline"></i> Alunos</a>
    </li>
    <?php if($row_logged['type']=='T'){ ?>
      <li>
        <a href="studio.php"><i class="fa fa-video-camera"></i> Estúdio de criação</a>
      </li>
      <?php } ?>
      <li>
        <a href="my_subscriptions.php"><i class="fa fa-check"></i> Minhas inscrições</a>
      </li>
      <li>
        <a href="favorites.php"><i class="fa fa-heart"></i> Favoritos</a>
      </li>
    </ul>
  </aside>
