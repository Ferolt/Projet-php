<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Home</h1>
    <p>
        Bonjour <?php echo $_SESSION["user_firstname"] ?>
    </p>
    <a href="/se-deconnecter">Se deconnecter</a>
</body>
</html>