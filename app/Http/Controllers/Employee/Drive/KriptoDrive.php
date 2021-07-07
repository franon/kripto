<?php

namespace App\Http\Controllers\Employee\Drive;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CustomController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Spatie\Dropbox\Client;

class KriptoDrive extends CustomController
{
    protected $dropbox;
    public function __construct()
    {
        $this->dropbox = Storage::disk('dropbox')->getDriver()->getAdapter()->getClient();
    }

    public function index(){
        $result = $this->dropbox->listFolder('/encrypted');
        dd($result);
    }

    public function uploadFiles($path, $content){
        return Storage::disk('dropbox')->put($path,$content);
    }

    public function downloadFiles(){

    }

    public function removeFiles(){

    }
}
