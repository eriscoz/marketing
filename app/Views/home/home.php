<section class="container-fluid">
  <div class="row bg-img-slideshow">
    <div class="col-md-6 d-flex flex-column align-items-center justify-content-center order-1 order-md-1"
      style=" background-color: rgba(0, 0, 0, 0.75);">
      <div class="p-2" style="height: 100%;"></div>
      <div class="p-2">
        <h1 class="display-1" style="font-weight: bolder;"><?= $homepage_title ?></h1>
      </div>
      <div class="p-2">
        <p>
          <?= $homepage_subtitle ?>
        </p>
      </div>


      <div class="p-2">

      </div>
      <div class="image-container">
        <!-- <iframe width="100%" height="100%" src="<?= $url_video ?>" frameborder="0" allow="autoplay; loop; muted"></iframe> -->

        <button class="btn custom-btn contact-btn" onclick="location.href='<?= base_url('/contact') ?>'">Contact
          Us</button>
      </div>
    </div>
    <div class="col-md-6 order-2 order-md-2" style=" background-color: rgba(0, 0, 0, 0.75);">
      <div class="d-none">
        <h1><?= $company_name ?></h1>
        <p><?= $slogan ?></p>
        <div class="container-fluid">
          <form method="GET" action="<?= base_url("/toMap") ?>">
            <div class="mb-3">
              <label for="exampleFormControlInput1" class="form-label">Lokasi Asal</label>
              <input type="text" class="form-control auto-text" name="map_asal">
            </div>
            <div class="mb-3">
              <label for="exampleFormControlInput1" class="form-label">Lokasi Tujuan</label>
              <input type="text" class="form-control auto-text" name="map_tujuan">
            </div>
            <div class="mb-3">
              <label for="exampleFormControlInput1" class="form-label">Jenis Kendaraan</label>
              <select name="map_kendaraan" class="form-control">
                <?php foreach ($jenis_kendaraan as $key) {
                  ?>
                  <option value="<?= $key['ID'] ?>"><?= $key['Deskripsi'] ?></option>
                  <?php
                }
                ?>
              </select>
            </div>
            <div class="mb-3" style="float: right;">
              <button class="btn btn-outline-success" type="submit">Cek Harga</button>
            </div>
          </form>
        </div>
      </div>
    </div>

  </div>
</section>





<div class="container text-center p-5" style="width: 75%;">
  <?php
  $arr = explode(" ", $slogan);
  foreach ($arr as $k => $v) {
    $text_align = 'right';
    fmod($k, 2) == 0 ? $text_align = 'right' : $text_align = 'left';
    ?>
    <h3 class="display-3 stylish-font <?= $text_align ?>" style="text-align: <?= $text_align ?>;"><?= $v ?></h3>
    <?php
  }
  ?>
</div>


<div class="container-flud black-bg">
  <div class="row">
    <div class="col-md-6 d-flex flex-column order-1 order-md-1">
      <div class="p-2" style="height: 2%;"></div>
      <div class="px-5 py-2">
        <h5 class="display-5" style="font-weight: bolder;">Who Are We?</h5>
      </div>
    </div>
    <div class="col-md-6 d-flex flex-column order-2 order-md-2">
    <div class="p-2" style="height: 2%;"></div>
      <div class="px-5 py-2">
        <p>
          <?=$whoarewe?>
        </p>
      </div>
    </div>
  </div>
</div>

<section class="black-bg py-5">
  <div class="container">
    <div class="row gy-4 gx-4">
      <div class="col-12 text-center mb-4">
        <h2><?= $homepage_section ?></h2>
      </div>


      <?php foreach ($homepage_content as $key) {
        ?>
        <div class="col-md-4">
          <div class="card bg-dark" style="width: 100%;">
            <div class="image-container"
              style="background-image: url('<?= base_url() ?>/public/images/homepage/<?= $key['Gambar'] ?>'); background-size: cover; background-position: center; ">

            </div>
            <div class="card-body">
              <p class="card-text"><?= $key['Judul'] ?></p>
              <span>
                <?= $key['Deskripsi'] ?>
              </span>
            </div>
          </div>

        </div>
        <?php
      }

      ?>
    </div>
  </div>
</section>


<script>
  let img = [
    "<?= base_url() ?>/public/images/slideshow/1.jpg",
    "<?= base_url() ?>/public/images/slideshow/2.jpg",
    "<?= base_url() ?>/public/images/slideshow/3.jpg",
    "<?= base_url() ?>/public/images/slideshow/4.jpg",
    "<?= base_url() ?>/public/images/slideshow/5.jpg"
  ];

  let currentIndex = 0;
  function changeImage() {
    img = shuffle(img);
    $('.bg-img-slideshow').css('background-image', 'url(' + img[currentIndex] + ')');
    currentIndex = (currentIndex + 1) % img.length;
  }

  function shuffle(array) {
    var currentIndex = array.length, randomIndex;

    while (currentIndex != 0) {

      randomIndex = Math.floor(Math.random() * currentIndex);
      currentIndex--;
      [array[currentIndex], array[randomIndex]] = [
        array[randomIndex], array[currentIndex]];
    }

    return array;

  }

  $(document).ready(function () {
    setInterval(changeImage, 10000);
    changeImage();

  });
</script>