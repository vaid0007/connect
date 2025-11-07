<?php
function generateFolderList($dir) {
    $html = '';

    if (is_dir($dir)) {
        $items = scandir($dir);
        $folders = [];
        $files = [];
        foreach ($items as $item) {
            if ($item !== '.' && $item !== '..') {
                $path = $dir . '/' . $item;
                if (is_dir($path)) {
                    $folders[] = $item;
                } else {
                    $files[] = $item;
                }
            }
        }

        sort($folders);
        sort($files);

        foreach (array_merge($folders, $files) as $item) {
            $path = $dir . "/" . $item;
            $isFolder = is_dir($path);
            $icon = $isFolder ? 'images/folder.png' : 'images/file.png';
            $class = $isFolder ? 'folder-item' : 'file-item';
            $name = $item;
            
            $checkbox = "<input type='checkbox' class='file-checkbox position-absolute top-0 start-0 m-3' data-path='$path' checked>";
            
            $html .= "<li class='position-relative'>
                        <div class=\"d-flex flex-column text-center align-items-center justify-content-center m-2 p-3 border rounded $class\"
                             data-path=\"$path\" style=\"cursor: pointer; width: 150px;\">
                            $checkbox
                            <img src=\"$icon\" style=\"width: 50px;\" alt=\"" . ($isFolder ? 'Folder' : 'File') . " Icon\">
                            <h6 class=\"mt-2 text-truncate\" style=\"width:100%\">$name</h6>
                        </div>
                      </li>";
        }
    } else {
        $html .= "<li>No items found.</li>";
    }

    return $html;
}
// Handle the path parameter
$baseDir = '../'; // Set this to your base directory
$path = isset($_GET['path']) ? $_GET['path'] : $baseDir;

if (is_dir($path)) {
    echo generateFolderList($path);
} else {
    echo 'Invalid path.';
}

?>