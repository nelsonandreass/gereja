<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

Use App\wa_sent_flags;
Use App\User;


class WaController extends Controller
{

    public function curl($url,$method,$request,$contentType){
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30000,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_POSTFIELDS => $request ,
            CURLOPT_HTTPHEADER => array(
                "content-type: application/".$contentType
            ),
        ));
        
        $response = curl_exec($curl);
        $err = curl_error($curl);
        
        curl_close($curl);
        
        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            return $response;
        }
    }
   
    public function getQr(Request $request){
        $id = $request->input('id');
        $requestBody = "id=".$id."&isLegacy=false";
        $curl = $this->curl('http://127.0.0.1:8000/sessions/add','POST',$requestBody,"x-www-form-urlencoded");
        return $curl;
    }

    public function isWaConnected(Request $request){
        $isWaConnected = $this->curl("http://127.0.0.1:8000/sessions/status/Login","GET","","json");
        return $isWaConnected;
    }

    public function sendMessage($id){
        $getUser = User::select("name","tanggal_lahir","jenis_kelamin")->where("nomor_telepon","LIKE",$id)->first();
        $now = date("Y-m-d");
        $umur = date_diff(date_create($now),date_create($getUser->tanggal_lahir));
        $umur = $umur->format("%y");
        $salute="";
        if($getUser->jenis_kelamin == "Pria" && $umur >= 25){
            $salute = "Bapak";
        }
        else if($getUser->jenis_kelamin == "Wanita" && $umur >= 25){
            $salute = "Ibu";
        }
        $requestBody = array(
            "receiver" => $id,
            "message" => array(
                "text" => "Selamat Ulang Tahun ".$salute."".$getUser->name."\n"."'Kiranya diberikan-Nya kepadamu apa yang kaukehendaki dan dijadikan-Nya berhasil apa yang kaurancangkan.'(Maz 20:5) "."\n"."Dari GPdI Sahabat Allah"
            ),
        );
        $sendMessage = json_decode($this->curl("http://127.0.0.1:8000/chats/send?id=Login","POST",json_encode($requestBody),"json"));
        //$sendMessage = json_decode($this->curl("","POST",json_encode($requestBody),"json"));
      
        if($sendMessage->success){ 
            $flaggingSentBody = array(
                'phone' => $id,
                'year' => date("Y"),
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ); 
            $insertFlaggingSent = wa_sent_flags::insert($flaggingSentBody);
            return redirect()->back();
        }
        else{
            return redirect()->back();
        }
    }

    public function getWaFlag(Request $request){
        $phone = $request->input("phone");
        $year = date("Y");
     
        $isSent = wa_sent_flags::where('phone',$phone)->where('year',$year)->first();
       
        if(!is_null($isSent)){
            $response = array("success"=>true);
            return json_encode($response);
        }
        else{
            $response = array("success"=>false);
            return json_encode($response);
        }
    }
}
