<?php

class Controller_Claim extends Controller
{
    /**
     * 単位数シミュレータ
     * @param string $user_id 単位数をシミュレートしたい利用者のMongoId
     */
    public function action_simulator($user_id = '')
    {
        $view = View::forge('claim/simulator');
        return $view;
    }

    public function action_calc()
    {
        $view = View::forge('claim/result');
        return $view;
    }
}