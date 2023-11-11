<?php
namespace App\Traits;
trait HttpResponses
{
    protected function response($data=[],$message=null,$code=200){
        return response()->json(
            [
                "data"=>$data,
                'message'=>$message
            ],$code
            );
    }

}
