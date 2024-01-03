<?php
namespace App\lib;
class Encrypt{
    private $_requestOBJ;
    private $_secretKey;

    public function __construct($requestObj){
        $this->_requestObj = $requestObj;
        $this->_secretKey = env('SECRET_KEY');
    }   

    public function encrypt(){
        $datas = json_decode(json_encode($this->_requestObj) , true);
        foreach($datas as &$data){
           $data = encrypt($data, $this->_secretKey);
        }
        $datasEncryptedObj = json_decode(json_encode($datas));
        return $datasEncryptedObj;
    }

    public function decrypt(){
        $datas = json_decode(json_encode($this->_requestObj) , true);
        $arrayExclode = ['id','tanggal_lahir','kartu','created_at'];
        $newData = array_diff_key($datas, array_flip($arrayExclode));
       
        foreach($newData as &$data){
            if(!empty($data)){
                $data = decrypt($data, $this->_secretKey);
            }
        }
        $newData['created_at'] = $datas['created_at'];
        $newData['id'] = $datas['id'];

        $datasDecryptedObj = json_decode(json_encode($newData));
        //dd($datasDecryptedObj);

        //var_dump($datasDecryptedObj);die();
        return $datasDecryptedObj;
    }
}