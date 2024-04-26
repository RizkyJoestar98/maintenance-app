<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

    <title><?= $title_pdf ?></title>

    <style type="text/script">
        .table{
                height: 5cm;
                width: 10cm;
                margin: 0 auto;
                border: 1px solid black;
            }
            
    </style>
</head>

<body>
    <?php if (!empty($material_codes)) : ?>
        <?php foreach ($material_codes as $data) : ?>
            <table class="table table-borderless">
                <thead>
                    <tr>
                        <th scope="col" colspan="3" style="border: 1px solid black; text-align: center;">
                            <h4><?= $data['code_material'] ?></h4>
                        </th>
                        <th scope="col" style="border: 1px solid black; text-align: center;">
                            <img src="<?= base_url() ?>/assets/image/logo/logo mii.png" alt="logo-isuzu.png" width="50" height="50">
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="3" style="border: 1px solid black; text-align: center;">
                            <h4><?= $data['code_category'] ?></h4>
                            <h4>
                                <?php
                                // Pastikan $data adalah string sebelum memanggil fungsi getBarcode
                                $data_str = strval($data['code_material']);
                                $generator = new Picqer\Barcode\BarcodeGeneratorHTML();
                                echo $generator->getBarcode($data_str, $generator::TYPE_CODE_128);
                                ?>
                            </h4>
                        </td>
                        <td rowspan="1" style="border: 1px solid black; vertical-align: middle; text-align: center;">
                            <b>Location</b>
                            <h6><?= $data['location'] ?></h6>
                        </td>
                    </tr>
                </tbody>
            </table>
            <hr style="border-top: 3px dashed #000; width: 100%;">
            <p></p>
        <?php endforeach; ?>
    <?php else : ?>
        <p>No material codes available.</p>
    <?php endif; ?>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous">
    </script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>
    -->
</body>

</html>