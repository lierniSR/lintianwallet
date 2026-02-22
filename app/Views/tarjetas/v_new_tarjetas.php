<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir cuenta</title>
</head>

<body>
    <form action="<?= base_url('tarjetas/crear') ?>" method="post">
        <label for="saldoTotal">Saldo Total</label>
        <input type="number" name="saldoTotal" id="saldoTotal">
        <label for="id_categoria">Categoria</label>
        <input type="number" name="id_categoria" id="id_categoria">
        <button type="submit">Añadir</button>
    </form>
</body>

</html>