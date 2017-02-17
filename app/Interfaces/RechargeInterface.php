<?php  
/**
* 
*/
namespace App\Interfaces;
use App\Interfaces\BaseRechargeInterface;
use App\Model\Recharge;
class RechargeInterface implements BaseRechargeInterface
{
    
    function __construct()
    {
        
    }


    public function getModel()
    {
       
         return Recharge::class;
    }
    public function find($obj)
    {
            $dd=$this->getModel();
            $date=$dd::where(['deleted_at'=>null,'ispass'=>false,'id'=>$obj->get('id')])
                     ->first();
            return $date;
    }

    public function delete($obj){
       
    }
    public function create($obj){
       $re=new Recharge;
        $re->name=$obj['name'];
        $re->money=$obj['money'];
        $re->uid=$obj['id'];
        $re->mark=$obj['mark_id'];
        $re->ispass=false;
        $re->recharge_type=$obj['recharge_type'];
        $re->state=0;
        $bol=$re->save();
        if($bol){
            return $re;
        }
        return $bol;
    }

    public function update($obj){

    }
    public function findId($obj){
         $re=$this->getModel()::where(['id'=>$obj->get('recharge_id')])->get()->first();
         return $re;
    }
    public function getRechange($obj,$type=1){
        if($type==1){
            $re=$this->getModel()::where(['uid'=>$obj['id'],'deleted_at'=>NULL])
          ->orderBy('created_at','desc')
          ->get(['id','mark','money','updated_at','ispass','state','recharge_type'])
          ->first();
        }else{
          $re=$this->getModel()::where(['uid'=>$obj['id'],'deleted_at'=>NULL])
          ->orderBy('created_at','desc')
          ->get(['id','mark','name','money','updated_at','ispass','state','recharge_type']);  
        }
          return $re;
    }

    public function getReview($obj){
    $data=$this->getModel()::where(['mark'=>$obj['id'],'deleted_at'=>NUll,'state'=>1,'ispass'=>0])->get()->count();  
    return $data; 
    } 

    public function waitingReviewRecharge($obj){
         $re=$this->getModel()::where(['uid'=>$obj['id'],'deleted_at'=>NULL,'ispass'=>0])
          ->orderBy('created_at','desc')
          ->get(['id','mark','money','updated_at','ispass','state','recharge_type'])
          ->first();
          return $re;
    }
    public function getReviewRecharge($obj){
         $re=$this->getModel()::where(['mark'=>$obj['id'],'deleted_at'=>NULL,'state'=>1,'ispass'=>0])
          ->orderBy('updated_at','desc')
          ->get(['id','name','mark','money','created_at','recharge_type','uid']);  
          return $re;
    }

    public function delChange($obj){
         $re=$this->getModel()::find($obj->get('rechangId'));
         $re->deleted_at=date('Y-m-d h:i:s');
         $bol=$re->save();
         return $bol;
    }
    public function updateRecharge($obj){
        if($obj['type']){
            $model=$this->find($obj);
            $model->state=1;
        }else{
            $model=$this->find($obj);
            $model->deleted_at=date('Y-m-d h:i:s');
            }
        $bol=$model->save();
        if($bol){
          return $model;
        }else{

        return false; 
        }
    }


    public function setRecharge($obj){
         if($obj['type']){
            $model=$this->findId($obj);
            $model->ispass=1;
            $model->state=2;
        }else{
            $model=$this->findId($obj);
            $model->state=3;
            }
        $bol=$model->save();
        return $bol; 
    }
}
