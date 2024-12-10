
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
</head>
<body>
    <h1>Inscription</h1>

    <?php if (isset($errors) && !empty($errors)): ?>
        <div style="color: red;">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="/cree-un-compte" method="POST">
        <label for="email">Email :</label>
        <input type="email" id="email" name="email" required>
        
        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" required>
        
        <label for="passwordConfirm">Confirmez le mot de passe :</label>
        <input type="password" id="passwordConfirm" name="passwordConfirm" required>
        
        <label for="firstname">Prénom :</label>
        <input type="text" id="firstname" name="firstname" required>
        
        <label for="lastname">Nom :</label>
        <input type="text" id="lastname" name="lastname" required>
        
        <label for="country">Pays :</label>
        <input type="text" id="country" name="country" required>
        
        <button type="submit">S'inscrire</button>
    </form>
</body>
</html>
