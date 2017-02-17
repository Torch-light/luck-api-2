<?php  
/**
* 
*/
namespace App\Interfaces;
use App\Interfaces\BaseActionInterface;
use App\Model\Action;
class ActionInterface implements BaseActionInterface
{
	
	function __construct()
	{
        
	}


    public function getModel()
    {
       
    	 return Action::class;
    }
    public function find($obj)
    {
            $dd=$this->getModel();
            $date=$dd::where('id',$obj)->first();
            return $date;
    }

    public function delete($obj){
       
    }
    public function create($obj){
       $re=new Action;
        $re->name=$obj['name'];
        $re->num=$obj['num'];
        $re->money=$obj['money'];
        $re->action=$obj['type'];
        $re->multiple=$obj['multiple'];
        // $re->mark=$obj['mark'];
        $re->save();
         return $re;
    }
    public function update($obj){
           $dd=$this->getModel();
           $model=$dd::find($obj['aid']);
           $model->state=2;
           $model->prize= $obj['type'];
           $bol=$model->save();
           if($bol){
            return $model;
           }else{
             return $bol;   
           }
    }

    public function getAll($obj){
         $dd=$this->getModel();
         switch ($obj['role_id']) {
             case 0:
             case 1:
                 $date=$dd::where('num',$obj['num'])
        ->orderBy('created_at','desc')
        ->get(['id','name','num','action','money','created_at']);
                 break;
             case 2:
                 $date=$dd::where(['num'=>$obj['num'],'mark'=>$obj['id']])
        ->orderBy('created_at','desc')
        ->get(['id','name','num','action','money','created_at']);
                 break;
             
             default:
                $date=$dd::where(['num'=>$obj['num'],'mark'=>$obj['mark']])
        ->orderBy('created_at','desc')
        ->get(['id','name','num','action','money','created_at']);
                 break;
         }
        
        return $date;
    }

    public function delaction($obj){
        $de=$this->getModel()::find($obj->get('id'));
        $de->deleted_at=date("Y-m-d H:i:s");
        if($de->save()){
            return $de; 
        }else{
            return false;
        }
    }

    public function getaction($obj){
         $dd=$this->getModel();
        $date=$dd::where(['name'=>$obj['name']])
        ->limit(10)
        ->orderBy('created_at','desc')
        ->get(['action','money','multiple','num','created_at','prize']);
        return $date;
    }

    public function getactionv1($obj){
        $dd=$this->getModel();
        $date=$dd::where(['num'=>$obj['cathe_id']+1,'name'=>$obj['name'],'deleted_at'=>NULL])->get(['id','name','multiple','action','money']);
        return $date;
    }


    public function dayHistory($obj){
        $dd=$this->getModel();
        $date=$dd::where(['name'=>$obj['name'],'deleted_at'=>NULL])->where('created_at','>',$obj['sTime'])->where('created_at','<',$obj['eTime'])->orderBy('id','desc')->get(['id','name','multiple','action','money','state','prize','num','created_at']);
        return $date;   
    }

    public function waitAction($obj){
        $dd=$this->getModel();
        $data=$dd::where(['num'=>$obj['id'],'state'=>NULL])->get();
        return $data;
    }
}
