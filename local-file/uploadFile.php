<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the target path from the POST data
    $targetPath = isset($_POST['path']) ? $_POST['path'] : '';

    if (!$targetPath) {
        echo json_encode(['success' => false, 'message' => 'No target path specified.']);
        exit;
    }

    // Validate the file upload
    if (isset($_FILES['replacementFile']) && $_FILES['replacementFile']['error'] === UPLOAD_ERR_OK) {
        $uploadedFile = $_FILES['replacementFile']['tmp_name'];
        $fileName = basename($_FILES['replacementFile']['name']);
        $destination = rtrim($targetPath, '/') . '/' . $fileName;

        // Move the uploaded file to the target directory
        if (move_uploaded_file($uploadedFile, $destination)) {
            echo json_encode(['success' => true, 'message' => 'File uploaded successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to upload the file.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'No file uploaded or an error occurred during upload.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}
?>