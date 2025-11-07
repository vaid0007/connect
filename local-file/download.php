<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $files = $_POST['files']; // Array of file paths to be downloaded

    if (count($files) === 1) {
        // Single file download
        $file = $files[0];
        if (file_exists($file)) {
            ob_end_clean(); // Clean any previous output buffer
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($file) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));

            flush(); // Flush system output buffer
            readfile($file);
            exit;
        } else {
            echo json_encode(['success' => false, 'message' => 'File does not exist.']);
        }
    } else {
        // Multiple files download (zipping them)
        $zip = new ZipArchive();
        $zipFile = 'download/' . uniqid('download_', true) . '.zip';

        if ($zip->open($zipFile, ZipArchive::CREATE) === TRUE) {
            foreach ($files as $file) {
                if (file_exists($file)) {
                    $zip->addFile($file, basename($file));
                }
            }
            $zip->close();

            if (file_exists($zipFile)) {
                ob_end_clean(); // Clean any previous output buffer
                header('Content-Description: File Transfer');
                header('Content-Type: application/zip');
                header('Content-Disposition: attachment; filename="' . basename($zipFile) . '"');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . filesize($zipFile));

                flush(); // Flush system output buffer
                readfile($zipFile);
                unlink($zipFile); // Optionally delete the ZIP file after download
                exit;
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to create ZIP file.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to create ZIP file.']);
        }
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>