<?php

namespace App\Http\Controllers;

use Stripe\Plan;
use Stripe\SetupIntent;
use Illuminate\Http\Request;
use Laravel\Cashier\Cashier;
use Stripe\Stripe;

class HomeController extends Controller
{
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$data['intent'] = SetupIntent::create(
				[],
				Cashier::stripeOptions()
		);
		$unused = 0;

		Stripe::setApiKey(config('test.stripe_secret_key'));
		$plans = Plan::all();

		foreach ($plans as $plan) {
			$data['plans'][$plan['id']] = $plan['id'];
		}
//dd($plans);
		return view('home')->with($data);
//        return view('home', compact('intent'));
	}
}
