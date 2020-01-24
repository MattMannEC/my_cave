<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;

Class UploaderHelper
{
    public function __construct(string $uploadsPath) // use construc to import uploadsPath parametres...
    {
        $this->uploadsPath = $uploadsPath;
    }

    public function uploadArticleImage(UploadedFile $uploadedFile): string
    {
        $destination = $this->uploadsPath . '/images';

        $orignalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
        $newFilename = $orignalFilename . '-' . uniqid() . '.' . $uploadedFile->guessExtension(); // add Urlizer::urlize

        $uploadedFile->move(
            $destination, 
            $newFilename
        );

        return $newFilename;
    }
}