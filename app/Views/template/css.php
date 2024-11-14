<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>

<link href="https://cdn.jsdelivr.net/npm/notyf@3.10.0/notyf.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link
    href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
    rel="stylesheet">

<link
    href="https://fonts.googleapis.com/css2?family=Funnel+Display:wght@300..800&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
    rel="stylesheet">

<html data-bs-theme="dark">

</html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        body {
            font-family: "Inter", sans-serif;
            font-optical-sizing: auto;
            font-style: normal;
            /* background-color: #121212;
            color: #e0e0e0; */
        }

        .cust-nav {
            background-color: #121212;
            color: #e0e0e0;
        }

        .black-bg {
            background-color: #121212;
            color: #e0e0e0;
        }

        .bg-img-slideshow {
            background-image: url('<?= base_url() ?>/public/images/slideshow/1.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            transition: background-image 5s ease-in-out;
        }




        .image-container {
            position: relative;
            width: 100%;
            height: 100px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .map-container {
            position: relative;
            width: 100%;
            height: 300px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .contact-btn {
            position: absolute;
            bottom: 8px;
            right: 17px;
        }

        .dropdown-menu {
            position: absolute;
            z-index: 50;
        }

        .custom-btn {
            background-color: red;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            font-weight: bold;
            border-radius: 0;
            transition: background-color 0.3s;

        }

        .custom-btn:hover {
            background-color: black;
        }

        .stylish-font {
            font-family: "Funnel Display", sans-serif;
            font-weight: bolder;
            color: transparent;
            -webkit-text-stroke: 1px red;
            text-stroke: 1px red;
            transform: translate(-5%, -5%);
        }
    </style>


    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>

    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
</head>

<script>

    function showToastError(message) {
        new Notyf({
            duration: 4000,
            position: {
                x: 'right',
                y: 'bottom'
            },
            ripple: true
        }).open({
            type: 'error',
            message: message,
            dismissible: true
        });
    }

    function formatRupiah(number) {
        let numStr = number.toString();
        let part = numStr.split('.');
        let formattedStr = "Rp. " + part[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");

        if (part.length > 1) formattedStr += "." + part[1];

        return formattedStr;
    }

    $(window).scroll(function () {
        var scrollTop = $(window).scrollTop();
        $('.stylish-font').each(function () {
            var heading = $(this);
            var direction = heading.hasClass('right') ? -1 : 1; 

            var offset = 50;
            var speed = 0.3;

            heading.css({
                transform: 'translateX(' + (direction * scrollTop * speed) + 'px)'
            });
        });
    });

    $(document).ready(function () {
        $(".auto-text").autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: '<?= base_url("/getAutoCompleteLocation") ?>',
                    type: "GET",
                    data: {
                        key: request.term
                    },
                    dataType: "json",
                    success: function (data) {
                        let result = [];
                        $.each(data, function (index, value) {
                            result.push(value.Address);
                        });

                        if (result.length < 2) {
                            $.ajax({
                                url: `<?= base_url("/getAutoCompleteLocationByGoogle") ?>`,
                                type: "GET",
                                data: {
                                    input: request.term
                                },
                                dataType: "json",
                                success: function (googleData) {
                                    $.each(googleData.predictions, function (index, value) {
                                        result.push(value.description);

                                        $.ajax({
                                            url: '<?= base_url("/savePlaces") ?>',
                                            type: "POST",
                                            data: {
                                                name: value.place_id,
                                                address: value.description
                                            },
                                            success: function () {
                                                console.log("Lokasi baru berhasil disimpan:", value.description);
                                            },
                                            error: function () {
                                                console.error("Gagal menyimpan lokasi:", value.description);
                                            }
                                        });
                                    });
                                },
                                error: function () {
                                    console.error("Gagal mengambil data dari Google Places API.");
                                }
                            });
                        }

                        response(result);
                    }
                });
            }
        });

        $("#myDropdownButton").click(function () {
            $("#myDropdown").toggle();
        });

        <?php if (session()->getFlashdata('error')): ?>
            showToastError("<?= session()->getFlashdata('error') ?>");
        <?php endif; ?>
    });
</script>