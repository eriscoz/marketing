<nav class="navbar navbar-expand-lg cust-nav sticky-top" aria-label="Offcanvas navbar large">
  <div class="container-fluid">
    <a class="navbar-brand" href="<?= base_url() ?>">
      <img src="<?= base_url() ?>/public/images/logo.png" width="50px" height="auto" />
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar2"
      aria-controls="offcanvasNavbar2" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasNavbar2"
      aria-labelledby="offcanvasNavbar2Label">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasNavbar2Label"><?= $company_name ?></h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body">
        <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="<?= base_url() ?>">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?= base_url('/location') ?>">Location</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?= base_url('/contact') ?>">Contact Us</a>
          </li>
        </ul>


        <?php
        if (session()->has('user')) {
          ?>
          <div class="btn-group" role="group">
            <button id="btnGroupDrop1" type="button" class="btn custom-btn dropdown-toggle" data-bs-toggle="dropdown"
              aria-expanded="false">
              <?=session('user')->Nama?>
            </button>
            <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
              <li><a class="dropdown-item" href="<?=base_url('/logout')?>">Logout</a></li>
            </ul>
          </div>
          <?php
        } else {
          ?>
          <button class="btn custom-btn" type="submit" onclick="location.href='<?= base_url('/login') ?>'">Login</button>
          <?php
        }
        ?>



      </div>
    </div>
  </div>
</nav>