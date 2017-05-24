<?php 
  require '../includes/config.php';
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?php echo $config['title'] ?></title>

  <!-- Bootstrap Grid -->
  <link rel="stylesheet" type="text/css" href="/media/assets/bootstrap-grid-only/css/grid12.css">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">

  <!-- Custom -->
  <link rel="stylesheet" type="text/css" href="/media/css/style.css">
</head>
<body>

  <div id="wrapper">
  
    <!-- header -->
    <?php include '../includes/header.php' ?>

    <div id="content">
      <div class="container">
        <div class="row">
          <section class="content__left col-md-8">
            <div class="block">
              
              <h3>Все статьи</h3>
              <div class="block__content">
                <div class="articles articles__horizontal">
                  
                  <?php 
                    $per_page = 4;
                    $page = 1;

                    if (isset($_GET['page'])){
                      $page = (int) $_GET['page'];
                    }

                    $category = 0;
                    if (isset($_GET['category'])){
                      $category = (int) $_GET['category'];   
                    } 

                    if ($category > 0){
                      $total_count_q = mysqli_query ($connection, "SELECT COUNT(`id`) as 'total_count' FROM `articles` WHERE `category_id` = " . $category);
                    } else {
                      $total_count_q = mysqli_query ($connection, "SELECT COUNT(`id`) as 'total_count' FROM `articles`");
                    }
                    $total_count =  mysqli_fetch_assoc($total_count_q);
                    $total_count =  $total_count['total_count'];

                    $total_pages = ceil($total_count / $per_page);
                    if ($page <=1 || $page > $total_pages){
                      $page = 1;
                    }

                    $offset = ($per_page * $page) - $per_page;


                    if ($category > 0){
                      $articles = mysqli_query ($connection, "SELECT * FROM `articles` WHERE `category_id` = '" . $category . "' ORDER BY `id` DESC LIMIT $offset,$per_page");                      
                    } else {
                      $articles = mysqli_query ($connection, "SELECT * FROM `articles` ORDER BY `id` DESC LIMIT $offset,$per_page");                      
                    }

                    $articles_exists = true;

                    if (mysqli_num_rows($articles)<= 0 ){
                      echo '<article  class="article">';
                      echo "Нет статей!";
                      echo '</article>';
                      $articles_exists = false;
                    }
                    
                      while ($art = mysqli_fetch_assoc($articles)) {
                  ?>
                        <article class="article">
                          <div class="article__image" style="background-image: url(/static/images/<?php echo $art['image']; ?>);"></div>
                          <div class="article__info">
                            <a href="/pages/article.php?id=<?php echo $art['id']; ?>"><?php echo $art['title']; ?></a>
                            <div class="article__info__meta">

                              <?php 
                                $art_cat = false;

                                foreach($categories as $cat){
                                  if ($cat['id'] == $art['category_id']){
                                    $art_cat = $cat;
                                    break;
                                  }
                                }
                              ?>

                              <small>Категория: <a href="/pages/articles.php?category=<?php echo $art_cat['id'] ?>"><?php echo $art_cat['title'] ?></a></small>
                            </div>
                            <div class="article__info__preview"><?php echo mb_substr(strip_tags($art['text']), 0, 100, 'utf-8') . ' ...'?></div>
                          </div>
                        </article>
                <?php 
                      }

                ?>    
                  

                </div>

                <?php 

                  if ($articles_exists){
                    echo '<div class="paginator">';
                    if ($page > 1){
                      echo '<a href="/pages/articles.php?page='.($page-1).'&category='.$category.'">&laquo; Предыдущая </a>';
                    }

                    if ($page < $total_pages) {
                      echo '<a href="/pages/articles.php?page='.($page+1).'&category='.$category.'"> Следующая &raquo;</a>';
                    }
                    echo '</div>';
                  } ?>
              </div>
            </div>
          

          </section>
          <section class="content__right col-md-4">
            <?php include '../includes/sidebar.php' ?>
          </section>
        </div>
      </div>
    </div>
    
    <!-- footer -->
    <?php include '../includes/footer.php' ?>

  </div>

</body>
</html>