<form method="POST" action="/cree-un-compte">
    <input
        type="email"
        name="email"
        placeholder="votre email"
        require>
    <br>
    <input
        type="text"
        name="firstname"
        placeholder="votre prenom"
        require>
    <br>
    <input
        type="text"
        name="lastname"
        placeholder="votre nom"
        require>
    <br>
    <input
        type="password"
        name="pwd"
        placeholder="votre mot de passe"
        require>
    <br>
    <input
        type="password"
        name="pwdConfirme"
        placeholder="confirmation"
        require>
    <br>
    <input type="submit" value="S'inscrire"><br>
</form>