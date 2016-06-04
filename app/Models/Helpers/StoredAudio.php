<?php
/**
 * Created by PhpStorm.
 * User: Nguyen Tuan Linh
 * Date: 2015-10-26
 * Time: 15:07
 */

namespace Antoree\Models\Helpers;


use Illuminate\Support\Facades\Storage;

class StoredAudio extends StoredFile
{
    const PREFIX = 'audio_';

    public $audioData;

    public function fromUploadedData($data)
    {
        $data = substr($data, strpos($data, ',') + 1);
        $this->audioData = base64_decode($data);
        $this->targetFileName = $this->getGeneratedName('mp3');
        $this->save();

        return $this;
    }

    public function fromUploadedDataQuestion($data)
    {
        // dd($data);
        $this->targetFileName = $this->getGeneratedName('mp3');
        Storage::put(
            'tmp/question/'.$this->targetFileName,
            file_get_contents($data->getRealPath())
        );
        $this->targetFilePath = storage_path('app/tmp/question/' . $this->targetFileName);
        $this->targetFileAsset = asset('storage/app/tmp/question/' . $this->targetFileName);
        return $this;
    }

    public function fromUploadedDataVoiceTeacher($data, $user)
    {
        // dd($data->getClientOriginalExtension());exit;
        $this->targetFileName = $this->getGeneratedName($data->getClientOriginalExtension());
        Storage::put(
            'tmp/voice/u_'.$user->id.'/'.$this->targetFileName,
            file_get_contents($data->getRealPath())
        );
        $this->targetFilePath = storage_path('app/tmp/voice/u_'.$user->id.'/' . $this->targetFileName);
        $this->targetFileAsset = asset('storage/app/tmp/voice/u_'.$user->id.'/' . $this->targetFileName);
        return $this;
    }

    public function deleteVoiceTeacher($voice_name, $user)
    {
        if(Storage::exists('tmp/voice/u_'.$user->id.'/'.$voice_name)){
            Storage::delete('tmp/voice/u_'.$user->id.'/'.$voice_name);
            // return true;
            // dd('yes');
        }else{
            // dd('no');
        }
        return true;
    }
    
    protected function save()
    {
        Storage::disk('tmp')->put($this->targetFileName, $this->audioData);

        parent::save();
    }
}