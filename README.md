# Base64 file to FileUploaded Laravel
Convert base64 file to UploadedFile of Laravel

## Requirements
php >= 7.2

## Installation
composer require th3khan/base64-to-uploaded-file

## Example
### Create File
* Create an instance of the class `Base64ToUploadedFile`

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use th3khan\Base64ToUploadedFile\Base64ToUploadedFile;

class FileController extends Controller
{
    public function save_base64 (Request $request) {
        $Base = new Base64ToUploadedFile($request->base64file);
    }
}
```
+ With the instance created, you will be able to access the data in the file, as well as save in the Storage of the project.

## Get file information
### Get filename
```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use th3khan\Base64ToUploadedFile\Base64ToUploadedFile;

class FileController extends Controller
{
    public function save_base64 (Request $request) {
        $Base = new Base64ToUploadedFile($request->base64file);
        ++ $filename = $Base->getFilename();
    }
}
```
