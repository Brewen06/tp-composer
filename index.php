<?php
$couleur = "#FFFFFF"; // Couleur par défaut (noir)

if (isset($_COOKIE["couleur_preferee"])) 
    $couleur = $_COOKIE["couleur_preferee"];
    
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['couleur']))
{
    $couleur = $_POST['couleur'];
    setcookie("couleur_preferee", $couleur, time() + 3600, "/");
}

?>
<html>
<head>
    <style>
        body {
            background-color: <?php print($couleur); ?>;
            text : <?php print($texte); ?>;
        }
    </style>
</head>
<body>
    <h1>Bienvenue sur notre site !</h1>

    <form method="post">
        <label for="couleur">Choisissez votre couleur préférée :</label>
        <input type="color" id="couleur" name="couleur">
        <button type="submit">Valider</button>
    </form>

    <form method="post">
        <label for="texte">Choisissez la couleur du texte :</label>
        <input type="color" id="texte" name="texte">
        <button type="submit">Valider</button>
    </form>
</body>
</html>