<?php

namespace Antoree\Http\Controllers\Admin;

use Antoree\Http\Controllers\ViewController;
use Antoree\Models\Helpers\DateTimeHelper;
use Illuminate\Http\Request;

use Antoree\Http\Requests;
use Illuminate\Support\Facades\Storage;

class DocumentController extends ViewController
{
    private function makeDirectory() {
        $own_directory = $this->auth_user->ownDirectory;
        $storage = Storage::disk('file_manager');

        if (!$storage->exists($own_directory)) {
            $storage->makeDirectory($own_directory);
        }
    }

    public function index(Request $request)
    {
        $this->makeDirectory();

        return view($this->themePage('my_documents.index'), [
            'dateFormat' => DateTimeHelper::shortDateFormat(),
            'timeFormat' => DateTimeHelper::shortTimeFormat(),
        ]);
    }
}
