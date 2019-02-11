<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employe extends Model
{
    protected $fillable = [
        'name','email','phone','address','designation','image','user_id'
    ];

    public function getBase64Image($path){
        return base64_encode(file_get_contents($path));
    }
    public function getBarCode(){
        return \BCD1::getBarcodeSVG($this->name, "C39",1,33,"black",true);
    }
}
