<?php
if (isset($_POST['login']) AND isset($_POST['pass']))
{
    $login = $_POST['login'];
    $pass_crypte = crypt($_POST['pass']); // On ("chiffre") le mot de passe

echo '<p>Ligne copiée dans le .htBasicPassword :<br />' . $login . ':' . $pass_chiffre . '</p>';
// Mettre le résultat dans le fichier /etc/apache2/.htpasswd
$file = '/etc/apache2/.htpasswd';
file_put_contents($file, $login . ':' . $pass_chiffre ."\n", FILE_APPEND);
echo '<a href = "index.html" > Revenir au menu parincipal </a>';

}

else // On n'a pas encore rempli le formulaire
{
?>

<p>Entrez votre login et votre mot de passe à chiffrer avec la fonction crypt() de php DES sans salt</p>

<form method="post">
    <p>
        Login : <input type="text" name="login"><br />
        Mot de passe : <input type="text" name="pass"><br /><br />
    
        <input type="submit" value="chiffrer !">
</p>
<p>
  <a href = "index.html" > Revenir au menu parincipal </a>
</p>
</form>

<?php
}
?>