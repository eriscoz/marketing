<section class="container my-5">
    <div class="row">
        <div class="col-md-6 order-1 order-md-1">
            <h1>Contact Us</h1>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">

                        <label for="name" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="name" aria-describedby="nameHelp">
                    </div>
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" aria-describedby="emailHelp">
                    </div>

                </div>
                <div class="row">
                    <div class="col-12">
                        <label for="subject" class="form-label">Subjek</label>
                        <input type="text" class="form-control" id="subject">
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <label for="message" class="form-label">Pesan</label>
                        <textarea class="form-control" id="message" rows="3"></textarea>
                    </div>
                </div>

                <br>
                <div class="mb-3" style="float: right;">
                    <button type="submit" class="btn custom-btn">Kirim</button>
                </div>

            </div>
        </div>


        <div class="col-md-6 d-flex align-items-center justify-content-center order-2 order-md-2">
            <div class="card" style="width: 100%;">
                <div class="map-container">
                    <iframe class="gmap_iframe" width="100%" height="100%" frameborder="0" scrolling="no"
                        marginheight="0" marginwidth="0" src="<?=$company_map?>"></iframe>
                </div>
                <div class="card-body">
                    <p class="card-text">Tel. <?=$company_telp?></p>
                    <p class="card-text">Alamat. <?=$company_address?></p>
                    <p class="card-text">Email. <?=$company_email?></p>
                </div>
            </div>
        </div>
    </div>
</section>