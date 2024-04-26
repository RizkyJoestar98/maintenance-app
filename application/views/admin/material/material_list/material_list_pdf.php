<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

    <title><?= $title_pdf; ?></title>

    <style type="text/script">
        .table{
                margin:auto;
                border:1px solid black;
            }
            
    </style>
</head>

<body>
    <h5>Total Material List : <?= count($material_codes); ?></h5>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Material Code</th>
                <th>Barcode</th>
                <th>Specification</th>
                <th>Qty</th>
                <th>Uom</th>
                <th>Location</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($material_codes)) : ?>
                <?php foreach ($material_codes as $data) : ?>
                    <tr>
                        <td><?= $data['code_material'] ?></td>
                        <td><?php
                            // Pastikan $material_code adalah string sebelum memanggil fungsi getBarcode
                            $material_code_str = strval($data['code_material']);
                            $generator = new Picqer\Barcode\BarcodeGeneratorHTML();
                            echo $generator->getBarcode($material_code_str, $generator::TYPE_CODE_128);
                            ?></td>
                        <td><?= $data['specification_material'] ?></td>
                        <td><?= $data['qty_stock'] ?></td>
                        <td><?= $data['uom'] ?></td>
                        <td><?= $data['location'] ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <p>No material codes available.</p>
            <?php endif; ?>
        </tbody>
    </table>

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