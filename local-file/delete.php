<?php
header('Content-Type: application/json'); // Ensure the response is JSON

$response = ['success' => true, 'message' => 'Files and/or folders deleted successfully.'];

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $paths = $_POST['paths'] ?? [];

        foreach ($paths as $path) {
            $realPath = realpath($path);

            if ($realPath === false || !file_exists($realPath)) {
                throw new Exception("File or folder not found: $realPath");
            }

            if (is_dir($realPath)) {
                $files = new RecursiveIteratorIterator(
                    new RecursiveDirectoryIterator($realPath, RecursiveDirectoryIterator::SKIP_DOTS),
                    RecursiveIteratorIterator::CHILD_FIRST
                );

                foreach ($files as $fileinfo) {
                    $todo = ($fileinfo->isDir() ? 'rmdir' : 'unlink');
                    $todo($fileinfo->getRealPath());
                }
                rmdir($realPath); // Remove the directory itself
            } else {
                if (!unlink($realPath)) {
                    throw new Exception("Failed to delete file: $realPath");
                }
            }
        }
    } else {
        throw new Exception('Invalid request method.');
    }
} catch (Exception $e) {
    $response['success'] = false;
    $response['message'] = $e->getMessage();
}

echo json_encode($response);
?>