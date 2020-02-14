<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Filesystem\Filesystem;

Class UploaderHelper
{ 
    const UPLOADS = 'uploads'; // path of app's public upload directory
    const IMAGES = 'images';

    private $uploadsPath;

    public function __construct(string $uploadsPath) // use construc to import uploadsPath parametres...
    {
        $this->uploadsPath = $uploadsPath;
    }

    public function uploadArticleImage(UploadedFile $uploadedFile): string
    {
        $destination = $this->uploadsPath . '/' . self::IMAGES;
        $orignalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
        $newFilename = $orignalFilename . '-' . uniqid() . '.' . $uploadedFile->guessExtension(); // add Urlizer::urlize

        $uploadedFile->move(
            $destination,  
            $newFilename
        );

        return $newFilename; 
    }

    public function getPublicPath()
    {
        return '/' . self::UPLOADS;
    }

    public function removeFile($directory, $imageFilename)
    {
        FileSystem::remove($this->uploadsPath . '/' . $directory . '/' . $imageFilename);
    }
}
