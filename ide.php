<?php

require_once __DIR__ . '/src/php/core.php';

$userPathIDE = "$accountPathUrl/ide";
is_dir($userPathIDE) ? null : mkdir($userPathIDE);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Magpie</title>

    <link rel="stylesheet" href="./src/css/style.css">
    <link rel="stylesheet" href="./src/css/markdown.css">

    <?php require_once __DIR__ . '/src/php/inc/head.php'; ?>
</head>

<body>

    <main>
        <?php require_once './src/php/inc/header.php'; ?>
        <div class="content">
            <div class="sub_content">

                <div class="ide">
                    <div class="left">
                        <div class="top">
                            <?php
                            if (!isset($_GET['folder'])) {
                                echo '<a href="ide-send.php?a=newfolder"><button id="newFolder"><i class="bx bxs-folder-plus"></i></button></a>';
                            } else {
                                $parentFolder = dirname($_GET['folder']);
                                $foldersInParent = glob($parentFolder . '/*', GLOB_ONLYDIR);
                                echo '<a title="back" href="ide"><button><i class="bx bx-chevrons-left"></i></button></a>';
                                // Affiche le bouton de retour si le dossier parent contient plus d'un dossier
                                if (count($foldersInParent) < 1) {
                                    echo '<a title="back" href="ide?folder=' . urlencode($parentFolder) . '/"><button><i class="bx bx-chevron-left"></i></button></a>';
                                }
                                echo '<a title="new file" href="ide-send.php?a=newfile&folder=' . urlencode($_GET['folder']) . '"><button id="newFolder"><i class="bx bxs-file-plus"></i></button></a>';
                                if (!isset($_GET['folder'])) {
                                    echo '<a title="new folder" href="ide-send.php?a=newsubfolder&folder=' . urlencode($_GET['folder'])  . '"><button><i class="bx bxs-folder-plus"></i></button></a>';
                                }
                                if(isset($_GET['folder'])) {
                                    echo '<a title="Remove file" href="ide-send.php?a=removeFolder&folder=' . urlencode($_GET['folder'])  . '"><button><i class="bx bxs-folder-minus" ></i></button></a>';
                                }
                                if (isset($_GET['file'])) {
                                    echo '<a title="Edit" href="ide?folder=' . urlencode($_GET['folder']) . '&file=' . $_GET['file'] . '&edit=true"><button><i class="bx bxs-edit-alt"></i></button></a>';
                                    echo '<a title="Remove file" href="ide-send.php?a=removeFile&folder=' . urlencode($_GET['folder'])  . '&file=' . $_GET['file'] . '"><button><i class="bx bxs-trash"></i></button></a>';
                                } else {
                                    echo '<a title="Edit" href="ide?folder=' . urlencode($_GET['folder']) . '&edit=true"><button><i class="bx bxs-edit-alt"></i></button></a>';
                                }
                            }
                            ?>
                            <hr>
                        </div>
                        <ul>
                            <?php
                            function afficherDossiers($cheminDossier)
                            {
                                foreach (scandir($cheminDossier) as $element) {
                                    if ($element == '.' || $element == '..') continue;
                                    $chemin = $cheminDossier . '/' . $element;
                                    if (is_dir($chemin)) {
                                        echo '<a href="?folder=' . urlencode($_GET['folder'] . $element . '/') . '"><li><i class="bx bxs-folder"></i>' . $element . '</li></a>';
                                    }
                                }
                            }

                            function afficherFichiers($cheminDossier)
                            {
                                echo '<ul>';
                                foreach (scandir($cheminDossier) as $element) {
                                    if ($element == '.' || $element == '..') continue;
                                    $chemin = $cheminDossier . '/' . $element;
                                    if (is_file($chemin)) {
                                        $icon = "<i class='bx bxs-file-blank'></i>"; // Par défaut
                                        switch (pathinfo($element)['extension']) {
                                            case 'txt':
                                                $icon = "<i class='bx bxs-file-txt'></i>";
                                                break;
                                            case 'doc':
                                                $icon = "<i class='bx bxs-file-doc'></i>";
                                                break;
                                            case 'dockerfile':
                                                $icon = "<i class='bx bxl-docker'></i>";
                                                break;
                                            case 'html':
                                                $icon = "<i class='bx bxl-html5'></i>";
                                                break;
                                            case 'css':
                                                $icon = "<i class='bx bxl-css3'></i>";
                                                break;
                                            case 'js':
                                                $icon = "<i class='bx bxs-file-js'></i>";
                                                break;
                                            case 'json':
                                                $icon = "<i class='bx bxs-file-json'></i>";
                                                break;
                                            case 'md':
                                                $icon = "<i class='bx bxl-markdown'></i>";
                                                break;
                                            case 'png':
                                                $icon = "<i class='bx bxs-file-png'></i>";
                                                break;
                                            case 'jpg':
                                            case 'jpeg':
                                                $icon = "<i class='bx bxs-file-jpg'></i>";
                                                break;
                                            case 'gif':
                                                $icon = "<i class='bx bxs-file-gif'></i>";
                                                break;
                                            case 'php':
                                                $icon = "<i class='bx bxl-php'></i>";
                                                break;
                                            case 'rb':
                                                $icon = "<i class='bx bxs-diamond'></i>";
                                                break;
                                            case 'sass':
                                            case 'scss':
                                                $icon = "<i class='bx bxl-sass'></i>";
                                                break;
                                            default:
                                                $icon = "<i class='bx bx-file'></i>"; // Icône par défaut pour les extensions non reconnues
                                                break;
                                        }
                                        echo '<a href="?folder=' . urlencode($_GET['folder']) . '&file=' . urlencode($element) . '"><li>' . $icon . $element . '</li></a>';
                                    }
                                }
                                echo '</ul>';
                            }

                            if (!isset($_GET['folder'])) {
                                afficherDossiers($userPathIDE);
                            } else {
                                $currentFolder = $_GET['folder'];
                                echo '<li><i class="bx bxs-folder-open"></i> ' . $currentFolder . '</li>';
                                $cheminDossier = $userPathIDE . '/' . $currentFolder;
                                if (is_dir($cheminDossier)) {
                                    afficherDossiers($cheminDossier);
                                    afficherFichiers($cheminDossier);
                                } else {
                                    echo "Le dossier spécifié n'existe pas.";
                                }
                            }
                            ?>
                        </ul>
                    </div>

                    <div class="right">
                        <?php
                        if (isset($_GET['file']) || isset($_GET['folder'])) {
                            $fichier = $userPathIDE . '/' . $_GET['folder'] . '/' . $_GET['file'];
                            if (file_exists($fichier)) {
                                $editMode = isset($_GET['edit']) && $_GET['edit'] === 'true';

                                $fileContent = file_get_contents($fichier);

                                if ($editMode) {
                        ?>
                                    <form method="post" action="ide-send.php">
                                        <input type="hidden" name="file" value="<?= $_GET['file'] ?>">
                                        <input type="hidden" name="folder" value="<?= $_GET['folder'] ?>">
                                        <input type="text" id="newFileName" name="newFileName" value="<?php echo isset($_GET['file']) ? $_GET['file'] : basename($_GET['folder']) ?>"><br>
                                        <textarea placeholder="Write here" id="fileContent" name="fileContent"><?= htmlspecialchars($fileContent) ?></textarea><br>
                                        <button title="save"><i class='bx bxs-save'></i></button>
                                    </form>
                        <?php } else {
                                    // Si le mode édition n'est pas activé, affiche simplement le contenu du fichier

                                    // Si fichier md
                                    if (pathinfo($fichier)['extension'] == 'md') {
                                        echo '<div class="markdown">' . (new Parsedown())->text($fileContent) . '</div>';
                                    } else {
                                        echo '<pre>' . htmlspecialchars($fileContent) . '</pre>';
                                    }
                                }
                            } else {
                                echo "<span class='error'>Erreur, fichier non trouvé.</span>";
                            }
                        }
                        ?>
                    </div>
                </div>


            </div>
        </div>
    </main>

</body>

</html>