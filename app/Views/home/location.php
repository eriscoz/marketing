<body>
    <div class="container py-4">
        <div class="d-flex justify-content-center">
            <h1 align="center"><?= $location_title ?></h1>
        </div>

        <br>
        <!-- <div class="d-flex justify-content-center">
            <p align="center"><?= $location_subtitle ?></p>
        </div>
        <br> -->

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">

            <?php foreach ($locations as $region => $cities): ?>
                <div class="col">
                    <div class="card h-100 black-bg">
                        <div class="card-body">
                            <h5 class="card-title" style="color: red;"><?= $region ?></h5>
                            <ul class="list-group list-group-flush">
                                <?php foreach ($cities as $city): ?>
                                    <li class="list-group-item black-bg"><?=$city?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

        </div>

    </div>
</body>