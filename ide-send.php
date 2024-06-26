<?php

require_once __DIR__ . '/src/php/core.php';

$userPathIDE = "$accountPathUrl/ide";
is_dir($userPathIDE) ? null : mkdir($userPathIDE);

$action = $_GET['a'];

if ($action == 'newfolder') {
    mkdir("$userPathIDE/" . uniqid());
    header('Location: ide');
    exit;
}

// Vérification et changement de nom de dossier si $_POST['file'] est vide
if ($_SERVER["REQUEST_METHOD"] == "POST" && empty($_POST['file'])) {
    // Récupérer le nom du dossier actuel et le nouveau nom de dossier
    $folder = $_POST['folder']; // Nom du dossier actuel
    $newFolderName = $_POST['newFileName']; // Nouveau nom du dossier

    // Chemin complet du dossier actuel
    $folderPath = "$userPathIDE/$folder";

    // Vérifier si le dossier existe
    if (is_dir($folderPath)) {
        // Construire le nouveau chemin complet pour le dossier
        $newFolderPath = "$userPathIDE/$newFolderName";

        // Changer le nom du dossier
        rename($folderPath, $newFolderPath);

        // Redirection vers le nouveau chemin du dossier
        header("Location: ./ide?folder=$newFolderName");
        exit;
    } else {
        // Gérer le cas où le dossier n'existe pas
        echo "Le dossier spécifié n'existe pas.";
        exit;
    }
}



if ($action == 'newfile' && isset($_GET['folder'])) {
    $folder = $_GET['folder'];
    // Vérification si le dossier existe
    $folderPath = "$userPathIDE/$folder";
    if (is_dir($folderPath)) {
        // Création du nom de fichier unique
        $filename = uniqid() . '.txt'; // Par exemple, créer un fichier texte
        // Création du fichier
        $filepath = "$folderPath/$filename";
        $file = fopen($filepath, 'w'); // Ouvrir le fichier en mode écriture
        if ($file) {
            fclose($file); // Fermer le fichier
            header("Location: ide?folder=$folder");
            exit;
        } else {
            echo "Erreur lors de la création du fichier.";
            exit;
        }
    } else {
        echo "Le dossier spécifié n'existe pas.";
        exit;
    }
}

if ($action == 'removeFile' && isset($_GET['folder'], $_GET['file'])) {
    $folder = $_GET['folder'];
    $file = $_GET['file'];
    $filePath = "$userPathIDE/$folder/$file";
    unlink($filePath);
    header("Location: ide?folder=$folder");
    exit;
}

if ($action == 'removeFolder' && isset($_GET['folder'])) {
    $folder = $_GET['folder'];
    $filePath = "$userPathIDE/$folder";
    // echo $filePath;
    rmdir($filePath);
    header("Location: ide");
    exit;
}

// if ($action == 'newsubfolder' && isset($_GET['folder'])) {
//     $folder = $_GET['folder'];
//     // Création du sous-dossier avec un nom unique
//     mkdir("$userPathIDE/$folder/" . uniqid());
//     header("Location: ide?folder=$folder");
//     exit;
// }

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifie si les données POST nécessaires sont présentes
    if (isset($_POST['file'], $_POST['folder'], $_POST['newFileName'], $_POST['fileContent'])) {
        $file = $_POST['file'];
        $folder = $_POST['folder'];
        $newFileName = $_POST['newFileName'];
        $fileContent = $_POST['fileContent'];

        // Chemin complet du fichier
        $filePath = $userPathIDE . '/' . $folder . '/' . $file;

        // Chemin complet du nouveau fichier si le nom de fichier est modifié
        $newFilePath = $userPathIDE . '/' . $folder . '/' . $newFileName;

        // Vérifie si le fichier existe
        if (file_exists($filePath)) {
            // Si le nom de fichier est modifié, renommer le fichier
            if ($file !== $newFileName) {
                rename($filePath, $newFilePath);
            }

            // Écrire le contenu dans le fichier
            file_put_contents($newFilePath, $fileContent);

            // Rediriger l'utilisateur vers une page de confirmation ou une autre page de votre choix
            header("Location: ide.php?folder=$folder&file=$newFileName");
            exit;
        }
    }
}
