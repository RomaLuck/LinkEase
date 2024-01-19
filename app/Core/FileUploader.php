<?php

namespace Core;

use finfo;
use RuntimeException;

class FileUploader
{
    public static function upload(string $designatedFolderPath): string
    {
        if (
            !isset($_FILES['upfile']['error']) ||
            is_array($_FILES['upfile']['error'])
        ) {
            throw new RuntimeException('Invalid parameters.');
        }

        switch ($_FILES['upfile']['error']) {
            case UPLOAD_ERR_OK:
                break;
            case UPLOAD_ERR_NO_FILE:
                throw new RuntimeException('No file sent.');
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                throw new RuntimeException('Exceeded filesize limit.');
            default:
                throw new RuntimeException('Unknown errors.');
        }

        if ($_FILES['upfile']['size'] > 1000000) {
            throw new RuntimeException('Exceeded filesize limit.');
        }

        $finfo = new finfo(FILEINFO_MIME_TYPE);
        if (false === $ext = array_search(
                $finfo->file($_FILES['upfile']['tmp_name']),
                [
                    'jpg' => 'image/jpeg',
                    'png' => 'image/png',
                    'gif' => 'image/gif',
                ],
                true
            )) {
            throw new RuntimeException('Invalid file format.');
        }

        $fileNameAndPath = sprintf($designatedFolderPath . '/%s.%s',
            sha1_file($_FILES['upfile']['tmp_name']),
            $ext
        );
        if (!move_uploaded_file(
            $_FILES['upfile']['tmp_name'],
            $fileNameAndPath
        )) {
            throw new RuntimeException('Failed to move uploaded file.');
        }
        echo 'File is uploaded successfully.';
        return $fileNameAndPath;
    }
}