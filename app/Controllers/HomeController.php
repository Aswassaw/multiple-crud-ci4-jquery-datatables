<?php

namespace App\Controllers;

class HomeController extends BaseController
{
	public function index()
	{
		$data['title'] = 'Home - Starter App';

		return view('home_view/v_index', $data);
	}
}
