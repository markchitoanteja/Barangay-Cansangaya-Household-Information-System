<?php
if (!function_exists('upload_file')) {
    function upload_file(string $key, string $destination, array $options = []): array
    {
        // Default options
        $defaults = [
            'allowed_types' => [],   // ['image/jpeg', 'image/png']
            'max_size' => 0,         // in bytes (0 = unlimited)
            'rename' => true,        // auto rename file
        ];

        $options = array_merge($defaults, $options);

        if (!isset($_FILES[$key])) {
            return ['status' => false, 'error' => 'File not found'];
        }

        $file = $_FILES[$key];

        if ($file['error'] !== UPLOAD_ERR_OK) {
            return ['status' => false, 'error' => 'Upload error code: ' . $file['error']];
        }

        // Validate file size
        if ($options['max_size'] > 0 && $file['size'] > $options['max_size']) {
            return ['status' => false, 'error' => 'File exceeds maximum size'];
        }

        // Validate MIME type
        if (!empty($options['allowed_types'])) {
            if (!in_array($file['type'], $options['allowed_types'])) {
                return ['status' => false, 'error' => 'Invalid file type'];
            }
        }

        // Ensure destination exists
        if (!is_dir($destination)) {
            mkdir($destination, 0777, true);
        }

        // Generate filename
        $filename = $file['name'];

        if ($options['rename']) {
            $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
            $filename = uniqid('upload_', true) . '.' . $ext;
        }

        $target = rtrim($destination, '/') . '/' . $filename;

        if (!move_uploaded_file($file['tmp_name'], $target)) {
            return ['status' => false, 'error' => 'Failed to move uploaded file'];
        }

        return [
            'status' => true,
            'path' => $target,
            'filename' => $filename,
            'original_name' => $file['name'],
            'size' => $file['size'],
            'type' => $file['type'],
        ];
    }
}

if (!function_exists('has_file')) {
    function has_file(string $key): bool
    {
        return isset($_FILES[$key]) && $_FILES[$key]['error'] === UPLOAD_ERR_OK;
    }
}
