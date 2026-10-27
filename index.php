<?php
//load config.php
include("config/config.php");
 
//untuk api_key newsapi.org
$api_key="acd26e26c8704880bc3aaa19d344a1e3";
 
//url api untuk ambil berita headline di us
$url="https://newsapi.org/v2/top-headlines?country=us&category=technology&apiKey=".$api_key;
 
//menyimpan hasil dalam variabel
$data=http_request_get($url);
 
//konversi data json ke array
$hasil=json_decode($data,true);
 
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rest Client dengan cURL</title>
    
    <!-- CSS Bootstrap via CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
 
<!-- navbar -->
<nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-info">
  <a class="navbar-brand" href="#">RestClient</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="#">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">News</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">About</a>
      </li>
    </ul>
  </div>
</nav>
<!-- navbar -->

<div class="container" style="margin-top: 75px;">
    <div class="row">
 
<!-- looping hasil data di array article -->
<?php if (!empty($hasil['articles'])) { ?>
    <?php foreach ($hasil['articles'] as $row) { ?>
        <div class="col-md-4" style="margin-top: 10px; margin-bottom: 10px;">
            <div class="card" style="width: 18rem;">
              <img src="<?php echo $row['urlToImage']; ?>" class="card-img-top" height="180px" alt="Gambar Berita">
              <div class="card-body">
                <p class="card-text"><i>Oleh <?php echo $row['author'] ? $row['author'] : 'Anonim'; ?></i> ~ <?php echo $row['title']; ?></p>
                <p class="text-right"><a href="<?php echo $row['url']; ?>" target="_blank" class="btn btn-sm btn-info">Selengkapnya..</a></p>
              </div>
            </div>
        </div>
    <?php } ?>
<?php } else { ?>
    <div class="col-12">
        <div class="alert alert-warning" role="alert">
            Data berita gagal dimuat atau API Key melebihi batas limit.
        </div>
    </div>
<?php } ?>
 
    </div>
</div>
 
<!-- JS Bootstrap & Dependencies via CDN -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>