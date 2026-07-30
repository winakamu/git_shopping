<?php

class Controller_Dashboard extends Controller
{
    public function action_index()
    {
        return View::forge('dashboard');
    }
}