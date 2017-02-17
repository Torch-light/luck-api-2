<?php
namespace App\Interfaces;

Interface BaseRechargeInterface
{

    public function getModel();
    public function find($obj);
    public function update($obj);
    public function delete($obj);
    public function create($obj);
    public function delChange($obj);
    public function updateRecharge($obj);
   	public function getReviewRecharge($obj);
   	public function getRechange($obj);
}