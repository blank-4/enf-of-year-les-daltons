<?php require 'functions.php'; ?>

<!DOCTYPE html>

<html>
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Mots Melax</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" media="screen" href="css/main.css" />
        <link rel="stylesheet" href="css/mobiledesign.css" type="text/css" media="screen and (max-width: 450px)">
        <link href="https://fonts.googleapis.com/css?family=Nova+Flat" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Grand+Hotel" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=ZCOOL+QingKe+HuangYou" rel="stylesheet">
    </head>
    <body>
        <div id='cssmenu'>
            <ul>
                <li><a href='../Page-accueil/index.php'><span>Accueil</span></a></li>
                <li class='active'><a href='../Page-inscription-connexion/connexion.php'><span>Connexion</span></a></li>
                <li><a href='../Page-Game/game.php'><span>Jouer</span></a></li>
                <li><a href='../Page-Score/score.php'><span>Scores</span></a></li>
                <!-- <li class='last'><a href='#'><span>Contact</span></a></li> -->
            </ul>
        <header>
            <h1>Mots Melax</h1>
        </header>
        </div>
        <div class="wrap-gif">
            <div id="login-box">
                <div class="left">
                <h2>Se connecter</h2>
                <form action="" method="">
                    <input type="text" name="pseudo" placeholder="Pseudo" />
                    <input type="password" name="password" placeholder="Mot de Passe" />
                    <input type="submit" name="signin_submit" value="Connexion" />
                </form>
                </div>

                <div class="right">

                <?php 
                    if (!empty($_POST)) {

                        $errors = array();
                        require_once 'bdd.php';

                        if (empty($_POST['pseudo'])) {
                            $errors['pseudo'] = "Votre pseudo n'est pas valide";
                        } else {
                            $req = $pdo->prepare('SELECT id FROM membres WHERE pseudo = ?');
                            $req->execute([$_POST['pseudo']]);
                            $user = $req->fetch();
                            if ($user) {
                                $errors['pseudo'] = 'Ce pseudo est déjà pris';
                            }
                        }

                        if (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                            $errors['email'] = "Votre email n'est pas valide";
                        } else {
                            $req = $pdo->prepare('SELECT id FROM membres WHERE email = ?');
                            $req->execute([$_POST['email']]);
                            $user = $req->fetch();
                            if ($user) {
                                $errors['email'] = 'Cet email est déjà utilisé par un autre compte';
                            }
                        }

                        if (empty($_POST['pass']) || $_POST['pass'] != $_POST['passconfirm']) {
                            $errors['pass'] = "Vous devez rentrer un mot de passe valide";
                        }

                        if (empty($errors)) {
                            $req = $pdo->prepare("INSERT INTO membres SET pseudo = ?, pass = ?, email = ?");
                            $password = password_hash($_POST['pass'], PASSWORD_BCRYPT);
                            $req->execute([$_POST['pseudo'], $password, $_POST['pass']]);
                            die('Votre compte a bien été créé');
                        }

                        
                        /* debug($errors); */
                    }
                ?>

                    <h2>S'inscrire</h2>

                    <?php if (!empty($errors)): ?>
                        <div id="error-inscription">
                            <p>Vous n'avez pas remplis le formulaire correctement</p>
                            <ul>
                                <?php foreach($errors as $error): ?>
                                    <li><?= $error; ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form action="" method="POST">
                        <input type="text" name="pseudo" id="pseudo" placeholder="Pseudo" />
                        <input type="text" name="email" id="email" placeholder="E-mail" />
                        <input type="password" name="pass" id="pass" placeholder="Mot de Passe" />
                        <input type="password" name="passconfirm" id="passconfirm" placeholder="Confirmation Mot de Passe" />
                        <input type="submit" name="signup_submit" value="Soumettre" />
                    </form>
                </div>

                <div class="or">OU</div>
            </div>
        </div>
        <footer>
            <p>Copyright © 2019 - Les Daltons</p>
        </footer>
    </body>
</html>