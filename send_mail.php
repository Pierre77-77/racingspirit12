<?php
// Vérification si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Récupération et nettoyage des données
    $nom = strip_tags(trim($_POST["name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $message = trim($_POST["message"]);
    $consent = isset($_POST["consent"]);

    // Vérification des champs
    if (empty($nom) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL) || !$consent) {
        // Redirection avec erreur si champs invalides
        header("Location: contact.html?status=error");
        exit;
    }

    // Destinataire (votre adresse email)
    $recipient = "contact@racingspirit12.fr";

    // Sujet de l'email
    $subject = "Nouveau message de $nom via Racing Spirit 12";

    // Contenu de l'email
    $email_content = "Nom: $nom\n";
    $email_content .= "Email: $email\n\n";
    $email_content .= "Message:\n$message\n";

    // En-têtes de l'email
    $email_headers = "From: $nom <$email>";

    // Envoi de l'email
    if (mail($recipient, $subject, $email_content, $email_headers)) {
        // Redirection avec succès
        header("Location: contact.html?status=success");
    } else {
        // Redirection avec erreur serveur
        header("Location: contact.html?status=server_error");
    }

} else {
    // Si la page est accédée directement sans soumettre le formulaire
    header("Location: contact.html");
    exit;
}
?>