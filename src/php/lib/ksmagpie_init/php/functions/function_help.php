<?php


/**
 * @brief Retrieves a file extension from its name
 *
 * @note will only return the first file found.
 *
 * @param string $urlFile indicate file url + path
 * @return array An array containing the extracted information:
 * 
 * @author Kerogs
 * 
 */
function ksmagpie_foundExtension(string $urlFile)
{
    $fichiers = glob($urlFile . ".*");

    if (count($fichiers) > 0) {
        $nomFichierAvecExtension = basename($fichiers[0]);
        return $nomFichierAvecExtension;
    } else {
        return null;
    }
}






/**
 * @brief Deletes a folder and its subfolders.
 *
 * @note Deletes with subfolders present (use with care)
 *
 * @param string $path specify folder url
 * @return array true if OK or FALSE if not found
 * 
 * @author Kerogs
 */
function ksmagpie_deleteFolder(string $path)
{
    if (!is_dir($path)) {
        return false;
    }

    $folder = opendir($path);

    while (($file = readdir($folder)) !== false) {
        if ($file != '.' && $file != '..') {
            $fileOrSubfolder = $path . '/' . $file;

            if (is_dir($fileOrSubfolder)) {
                ksmagpie_deleteFolder($fileOrSubfolder);
            } else {
                unlink($fileOrSubfolder);
            }
        }
    }

    closedir($folder);

    rmdir($path);

    return true;
}









/**
 * @brief Search in a folder
 *
 * Calculation with a percentage for a better result.
 *
 * @param string $searchValue Value used for search
 * @param string $directoryPath Folder to search in
 * @return array Returns the closest value to the least close value.
 *  
 * @author Kerogs
 */
function ksmagpie_searchInDir(string $searchValue, string $directoryPath)
{
    $files = scandir($directoryPath);

    $matches = array();

    foreach ($files as $file) {
        if ($file === '.' || $file === '..') {
            continue;
        }

        $similarity = similar_text(strtolower($searchValue), strtolower($file), $percent);

        $matches[] = array('name' => $file, 'similarity' => $similarity);
    }

    usort($matches, function ($a, $b) {
        return $b['similarity'] - $a['similarity'];
    });

    return $matches;
}











/**
 * @brief Save a cookie quickly
 *
 * Save by default for 30 days and save in root "/".
 *
 * @param string $cookieName name of cookie (can be any format)
 * @param string $cookieValue Value in cookie (can be any format)
 * @return array returns nothing
 * 
 * @author Kerogs
 */
function ksmagpie_cookieSave($cookieName, $cookieValue)
{
    $time = time() + (86400 * 30); // cookie expires in 30 days
    setcookie($cookieName, $cookieValue, $time, "/");
}












/**
 * @brief Returns random files/folders
 * 
 *
 * @param string $directory Path of folder to be searched
 * @param int $numberOfFolders number of folders/files to return (1 by default)
 * @return array returns value (array) otherwise nothing
 * 
 * @author Kerogs
 */
function ksmagpie_getRandomFolders(string $directory, int $numberOfFolders = 1)
{
    $folders = array();

    if (is_dir($directory)) {
        $folderList = scandir($directory);

        foreach ($folderList as $item) {
            if (is_dir($directory . "/" . $item) && $item != "." && $item != "..") {
                $folders[] = $item;
            }
        }

        shuffle($folders);

        return array_slice($folders, 0, $numberOfFolders);
    } else {
        return null;
    }
}

/**
 * @brief Générateur de token
 *
 * Format utilisé peut être utilisé pour la création de fichier.
 * 
 * @note pour s'assurer d'avoir un resultat 100% aléatoire alors ajouter dans le suffixe ou prefixe la fonction "uniqid()"
 *
 * @param int $length   longueur du token
 * @param string $suffixe   Permet d'ajouter un string au début du token
 * @param string $prefixe   Permet d'ajouter un string à la fin du token
 * @throws \Exception par défaut 66 sans suffixe/prefixe
 * 
 * @copyright  2022 Kerogs Infinite
 *  
 * @version    2.1.7
 * @since      2.1.7
 * 
 * @author Kerogs
 * @return void
 */
function ksmagpie_generateToken(int $longueur = 66, string $suffixe = '', string $prefixe = '')
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ_-';
    $token = '';
    $charactersLength = strlen($characters);

    for ($i = 0; $i < $longueur; $i++) {
        $randomChar = $characters[rand(0, $charactersLength - 1)];
        $token .= $randomChar;
    }

    if($suffixe != '') $token = $suffixe.$token;
    if($suffixe != '') $token = $token.$prefixe;

    return $token;
}

