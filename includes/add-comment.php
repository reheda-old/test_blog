<div class="block">
  <a href="#comment-add-form">Добавить свой</a>
  <h3>Комментарии к статье</h3>
  <div class="block__content">
    <div class="articles articles__vertical">

      <?php 
        $comments = mysqli_query ($connection, "SELECT * FROM `comments` WHERE `articles_id`= " . $art['id'] . " ORDER BY `id` DESC");
        
        if (mysqli_num_rows($comments)==0){
          echo "Нет комментариев!";
        } else {

          while ($comment = mysqli_fetch_assoc($comments)) {
            ?>
            <article class="article">
              <div class="article__image" style="background-image: url(https://www.gravatar.com/avatar/<?php echo md5($comment['email']); ?>?s=125)"></div>
              <div class="article__info">
                <a href="/article.php?id=<?php echo $comment['articles_id']; ?>"><?php echo $comment['nickname'] ?></a>
                <div class="article__info__meta"></div>
                <div class="article__info__preview"><?php echo $comment['text']; ?></div>
              </div>
            </article>
          <?php 
          }
        }
      ?>

    </div>
  </div>
</div>

<div class="block" id="comment-add-form">
  <h3>Добавить комментарий</h3>
  <div class="block__content">
    <form class="form" method="POST" action="/article.php?id=<?php echo $art['id'] ?>#comment-add-form">
      <?php 
        if (isset($_POST['do_post'])){
          $errors = array();
          if ($_POST['name']==''){
            $errors[] = 'Введите имя';
          }
           if ($_POST['nickname']==''){
            $errors[] = 'Введите никнейм';
          }
           if ($_POST['email']==''){
            $errors[] = 'Введите e-mail';
          }
           if ($_POST['text']==''){
            $errors[] = 'Введите текст';
          }

          if (empty($errors)){

            mysqli_query($connection, "INSERT INTO `comments` (`author`, `nickname`, `email`, `text`, `articles_id`) VALUES ('".$_POST['name']."', '".$_POST['nickname']."', '".$_POST['email']."', '".$_POST['text']."', '".$art['id']."')" );
             echo '<span style="color:green; font-weight:bold; margin-bottom:10px; display:block;">Комментарий успешно добавлен</span>';
          } else {
            echo '<span style="color:red; font-weight:bold; margin-bottom:10px; display:block;">'.$errors['0'] . '</span>';
          }
        }

       ?>

      <div class="form__group">
        <div class="row">
          <div class="col-md-4">
            <input type="text" class="form__control" name="name" placeholder="Имя" value="<?php echo $_POST['name'] ?>">
          </div>
          <div class="col-md-4">
            <input type="text" class="form__control" name="nickname" placeholder="Никнейм" value="<?php echo $_POST['nickname'] ?>">
          </div>
          <div class="col-md-4">
            <input type="text" class="form__control" name="email" placeholder="E-mail (не будет показан)" value="<?php echo $_POST['email'] ?>">
          </div>
        </div>
      </div>
      <div class="form__group">
        <textarea name="text" class="form__control" placeholder="Текст комментария ..."><?php echo $_POST['text'] ?></textarea>
      </div>
      <div class="form__group">
        <input type="submit" class="form__control" name="do_post" value="Добавить комментарий">
      </div>
    </form>
  </div>
</div>