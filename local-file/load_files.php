<?php
if (isset($_POST['folder'])) {
    $dir = realpath($_POST['folder']); // Ensure the folder path is secure and absolute

    if (is_dir($dir)) {
        $folders = scandir($dir);

        foreach ($folders as $folder) {
            if ($folder !== '.' && $folder !== '..') {
                $fullPath = realpath($dir . '/' . $folder);
                if (is_dir($fullPath)) {
                    echo "<li>
                            <div class=\"d-flex flex-column text-center align-items-center justify-content-center m-2 p-3 border rounded folder-item\"
                                 data-path=\"$fullPath\" style=\"cursor: pointer; width: 150px;\">
                                <img src=\"images/folder.png\" style=\"width: 50px;\" alt=\"Folder Icon\">
                                <h6 class=\"mt-2 text-truncate\" style=\"width:100%\">$folder</h6>
                            </div>
                          </li>";
                } else {
                    echo "<li class=\"text-muted\">$folder</li>"; // For files, just show the file name
                }
            }
        }
    } else {
        echo "<li>No folders found.</li>";
    }
}