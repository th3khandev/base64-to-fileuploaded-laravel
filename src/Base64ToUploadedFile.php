<?php

namespace th3khan\Base64ToUploadedFile;

use Exception;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;

class Base64ToUploadedFile {
    private $base64;
    private $ext;
    private $filename;
    private $fileType;
    private $fileUploaded;

    public function __construct(string $base64)
    {
        $this->base64 = $base64;
        $this->getFileOfBase64();
    }

    private function getFileOfBase64 () {
        // decode the base64 file
        // $fileData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64File));
        try {
            $base_to_php = explode(',', $this->base64);
            $fileData = base64_decode($base_to_php[1]);
    
            // save it to temporary dir first.
            $tmpFilePath = sys_get_temp_dir() . '/' . Str::uuid()->toString();
            file_put_contents($tmpFilePath, $fileData);
    
            // this just to help us get file info.
            $tmpFile = new File($tmpFilePath);
    
            $this->fileUploaded = new UploadedFile(
                $tmpFile->getPathname(),
                $tmpFile->getFilename(),
                $tmpFile->getMimeType(),
                0,
                true // Mark it as test, since the file isn't from real HTTP POST.
            );
            $this->ext = $this->fileUploaded->clientExtension();
            $this->filename = $this->fileUploaded->getClientOriginalName();
            $this->fileType = $this->fileUploaded->getMimeType();
        } catch (Exception $e) {
            throw new Exception('Base64 File is Invallid.!');
        }
    }

    public function file (): UploadedFile {
        return $this->fileUploaded;
    }

    public function getExtension (): string {
        return $this->ext;
    }

    public function getFilename (): string {
        return $this->filename;
    }

    public function getFullPath (): string {
        return $this->filename.'.'.$this->ext;
    }

    public function getFileType (): string {
        return $this->fileType;
    }

    public function getAllinfo (): array {
        return [
            'file'      => $this->file(),
            'extension' => $this->getExtension(),
            'filename'  => $this->getFilename(),
            'full_path' => $this->getFullPath(),
            'file_type' => $this->getFileType()
        ];
    }
}