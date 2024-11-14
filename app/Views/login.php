<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card card-dark">
                    <div class="card-header">
                        <div class="d-flex justify-content-center">
                            <img src="<?= base_url() ?>/public/images/logo.png" width="100px" height="auto" />
                        </div>

                        <ul class="nav nav-tabs card-header-tabs">
                            <li class="nav-item">
                                <a class="nav-link active" href="#login-tab" data-bs-toggle="tab">Login</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#register-tab" data-bs-toggle="tab">Register</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="login-tab" role="tabpanel" aria-labelledby="login-tab">  
                                <form method="POST" action="<?=base_url("/toLogin")?>">
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1" class="form-label">Email</label>
                                        <input type="email" class="form-control" name="lgn_email" aria-describedby="emailHelp">
                                    </div>
                                    <div class="mb-3">
                                        <label for="exampleInputPassword1" class="form-label">Password</label>
                                        <input type="password" class="form-control" name="lgn_password">
                                    </div>
                                    <button type="submit" class="btn custom-btn">Login</button>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="register-tab" role="tabpanel" aria-labelledby="register-tab">
                                <form method="POST" action="<?=base_url("/toRegist")?>">
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1" class="form-label">Nama <span style="color: red;">*</span></label>
                                        <input type="text" class="form-control" id="exampleInputEmail1" name="rgs_nama" aria-describedby="emailHelp">
                                    </div>
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1" class="form-label">telp</label>
                                        <input type="text" class="form-control" id="exampleInputEmail1" name="rgs_telp" aria-describedby="emailHelp">
                                    </div>
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1" class="form-label">Email <span style="color: red;">*</span></label>
                                        <input type="email" class="form-control" id="exampleInputEmail1" name="rgs_email" aria-describedby="emailHelp">
                                    </div>
                                    <div class="mb-3">
                                        <label for="exampleInputPassword1" class="form-label">Password <span style="color: red;">*</span></label>
                                        <input type="password" class="form-control" id="exampleInputPassword1" name="rgs_password">
                                    </div>
                                    <div class="mb-3">
                                        <label for="exampleInputPassword1" class="form-label">Password Confirmation <span style="color: red;">*</span></label>
                                        <input type="password" class="form-control" id="exampleInputPassword1" name="rgs_confirmation">
                                    </div>
                                    <button type="submit" class="btn custom-btn">Register</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>