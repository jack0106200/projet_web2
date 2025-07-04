<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Suggestions et Commentaires - UNILUK</title>
  <link rel="stylesheet" href="./ico.css">
  <link rel="icon" href="images/fevicon/Logo_UNILUK.png" type="image/gif" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    body {
      font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(135deg, #e8f0fe, #f0f4ff);
      margin: 0;
      padding: 0;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }

    nav {
      background-color: #2c3e50;
      padding: 10px 0;
      text-align: center;
    }

    nav a {
      color: white;
      text-decoration: none;
      margin: 0 15px;
      font-weight: bold;
      transition: color 0.3s ease;
    }

    nav a:hover {
      color: #ffd700;
    }

    header {
      background-color: #2c3e50;
      color: white;
      text-align: center;
      padding: 30px 10px;
    }

    header h1 {
      margin-bottom: 10px;
      font-size: 28px;
    }

    main {
      flex-grow: 1;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 30px 15px;
    }

    .form-section {
      background-color: #ffffff;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 600px;
      animation: fadeIn 0.8s ease;
    }

    label {
      display: block;
      margin-bottom: 6px;
      font-weight: bold;
      color: #333;
    }

    input, textarea {
      width: 100%;
      padding: 10px;
      margin-bottom: 20px;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 14px;
      background-color: #f9f9f9;
      transition: border-color 0.3s;
    }

    input:focus, textarea:focus {
      border-color: #512da8;
      outline: none;
    }

    button {
      background-color: #512da8;
      color: white;
      border: none;
      padding: 12px 20px;
      font-size: 16px;
      border-radius: 6px;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    button:hover {
      background-color: #381d75;
    }

    footer {
      text-align: center;
      padding: 15px;
      background-color: #2c3e50;
      color: #ccc;
      font-size: 13px;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>
<body>
  <nav>
    <a href="interface.php">Accueil</a>
    <a href="service.php">Services</a>
    <a href="uniluk.com">Institution</a>
    <a href="contact.html">Contact</a>
  </nav>

  <header>
    <h1>SUGGESTION et COMENTAIRE</h1>
    <p>Votre avis compte pour améliorer les services de l’Université Adventiste de Lukanga.</p>
  </header>

  <main>
    <section class="form-section">
      <form action="traitement_suggestion.php" method="post">

        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" placeholder="Votre nom" required />

        <label for="email">Email :</label>
        <input type="email" id="email" name="email" placeholder="Votre adresse e-mail" required />

        <label for="sujet">Sujet :</label>
        <input type="text" id="sujet" name="sujet" placeholder="Objet de votre message" required />

        <label for="message">Message :</label>
        <textarea id="message" name="message" rows="6" placeholder="Écrivez ici votre suggestion ou commentaire..." required></textarea>

        <button type="submit">Envoyer</button>
      </form>
    </section>
  </main>

  <?php
$message = '';
if (isset($_GET['success'])) {
    $message = "<p style='color:green; text-align:center; font-weight:bold;'>✅ Commentaire envoyé avec succès.</p>";
} elseif (isset($_GET['error'])) {
    $message = "<p style='color:red; text-align:center; font-weight:bold;'>❌ Veuillez remplir tous les champs.</p>";
}
echo $message;
?>

  <footer class="footer-container123">
  <div class="container-fuild">
    <div class="row">
      <div class="map_section">
        <div id="map"></div>
      </div>
      <div class="footer_blog" style="display: flex; flex-direction: column; gap: 30px;">
        <div class="col-md-6">
          <div class="main-heading left_text">
            <h2>À propos</h2>
            <p>La Polyclinique UNILUK offre des soins accessibles et de qualité à toute la communauté. Un service médical moderne et humain.</p>
            <ul class="social_icons">
              <li><a class="ico" href="http://facebook.com/universiteAdeventistedeLukanga/" title="Facebook" target="_blank"><img src="images/logos/facebook.png" alt="logos" class="ico"></a></li>
                <li><a class="ico" href="https://www.google.com/search?client=ms-android-transsion&sca_esv=b88ca0c3cb826eae&sxsrf=AE3TifOZrdP_Kdp6G3_h7awhI3Hm1KjrjQ:1748335832577&q=uniluk&uds=AOm0WdEdnsx__EwxHHINK9nscFhtSlL7RV3CwXypLtQL6d835EHpquNB0c_koD2ncVodu6mdfbI2AMdg20rjQYG4sXpCxY3s2QalzE_r9iRRXfDdPX12E-6FXLcKf9hlk_kftKxAfRelakAc3Np_1h1Gud6nT14JGT9wDYKE8ge7Z3qpWp_8PhLi6d783ind26kV42nJoiIcufd5sL6Bp_hayJBTa9P0xUZaBv7gMvmBcRJT90jnw8Xmo9qU5hWTZm9jrwUeiOeDbd2CjGLF8CpNuKN7TikSz1bvMkLrzHPneIkza-g1Lm3XjafSAudGLhssv6WtRkfESoCWeCl3ymxOmajJnHq17Gc_mxHr12823Qns3OrWfXq6ojiRxwuQv5JeKY1YFZUk&si=AMgyJEsS9yFPUNnJcpkaSNMRXqlE3FckxcCTZL41OY187f2YnQ6CVThi8Ee3LscCGe-p5PWsVtZMlYBvDaUPJB1xg0E7D7uoCacPg8acx1NnUmCHC7UJ_Hk%3D&sa=X&ved=2ahUKEwjp0f7BosONAxXPZ0EAHemwGwMQk8gLegQIHxAB&ictx=1&biw=360&bih=713&dpr=2" title="Google+" target="_blank"><img src="images/logos/chrome_6125000.png" alt="logos" class="ico"></a></li>
                <li><a class="ico" href="https://x.com/uniluk1" title="Twitter" target="_blank"><img src="images/logos/twitter_4494481.png" alt="logos" class="ico"></a></li>
                <li><a class="ico" href="https://www.instagram.com/uniluk1/" title="Instagram" target="_blank"><img src="images/logos/instagram_4494489.png" alt="logos" class="ico"></a></li>
                
            </ul>
          </div>
        </div>

        <div class="col-md-6">
          <div class="main-heading left_text">
            <h2>Liens utiles</h2>
            <ul class="footer-menu">
              <li><a href="#"><i class="fa fa-angle-right"></i> Qui sommes-nous</a></li>
              <li><a href="#"><i class="fa fa-angle-right"></i> Conditions générales</a></li>
              <li><a href="#"><i class="fa fa-angle-right"></i> Politique de confidentialité</a></li>
              <li><a href="#"><i class="fa fa-angle-right"></i> Actualités</a></li>
              <li><a href="#"><i class="fa fa-angle-right"></i> Contact</a></li>
            </ul>
          </div>
        </div>

        <div class="col-md-6">
          <div class="main-heading left_text">
            <h2>Services</h2>
            <ul class="footer-menu">
              <li><a href="#"><i class="fa fa-angle-right"></i> Soins médicaux</a></li>
              <li><a href="#"><i class="fa fa-angle-right"></i> Consultations</a></li>
              <li><a href="#"><i class="fa fa-angle-right"></i> Vaccination</a></li>
              <li><a href="#"><i class="fa fa-angle-right"></i> Analyse en laboratoire</a></li>
              <li><a href="#"><i class="fa fa-angle-right"></i> Urgences</a></li>
            </ul>
          </div>
        </div>

        <div class="col-md-6">
          <div class="main-heading left_text">
            <h2>Nous contacter</h2>
            <p>Nord-Kivu/Butembo,  Lukanga 'Université Adventiste de Lukanga'<br> Lukanga, RD Congo<br>
              <span style="font-size:18px;"><a href="tel:+243812345678">+243 823 881 864</a></span>
            </p>

            <div class="footer_mail-section">
              <form>
                <fieldset>
                  <div class="field">
                    <input placeholder="Votre adresse e-mail" type="text">
                    <button class="button_custom"><i class="fa fa-envelope" aria-hidden="true"></i></button>
                  </div>
                </fieldset>
              </form>
            </div>

            <div class="admin-access-box" style="margin-top: 20px;">
              <h3>Espace Administrateur</h3>
              <p>Réservé au personnel autorisé pour la gestion des inscriptions.</p>
              <a href="Admi/admi_connect.php" class="btn-admin-connexion">Se connecter</a>
            </div>
          </div>
        </div>
      </div>

      <div class="cprt">
        <p>Université Adventiste de Lukanga © Tous droits réservés</p>
      </div>
    </div>
  </div>
</footer>
</body>
</html>
