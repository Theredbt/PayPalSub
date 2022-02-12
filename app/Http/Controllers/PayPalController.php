<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Srmklive\PayPal\Services\PayPal;
use App\Models\SubscriptionModel;

class PayPalController extends Controller
{
    private $provider;

    public function __construct()
    {
        $this->provider = new PayPal();
        $this->provider->getAccessToken();
    }

    public function create()
    {
        $plans = $this->provider->listPlans();

        return Inertia::render('Paypal/Create', [
            'plans' => $plans['plans']
        ]);
    }

    public function subscriptionDetail(Request $request)
    {
        $subscription = $this->provider
            ->showSubscriptionDetails($request->get('subscription_id'));

        $plan = $this->provider
            ->showPlanDetails($subscription['plan_id']);

        $model = new SubscriptionModel();
        $model->plan_id = $subscription['plan_id'];
        $model->plan_name = $plan['name'];
        $model->plan_description = $plan['description'];
        $model->status = $subscription['status'];
        $model->status_update_time = $subscription['status_update_time'];
        $model->subscription_id = $subscription['id'];
        $model->start_time = $subscription['start_time'];
        $model->billing_info = $subscription['billing_info'];
        $model->save();

        return Inertia::location(route('membership',
            [
                'subscription_id' => $request->get('subscription_id')
            ]
        ));
    }

    public function show(Request $request)
    {

        $subscription = SubscriptionModel::where('subscription_id', $request->get('subscription_id'))
            ->first();

        if ($subscription == null) {
            return redirect(route('subscription.create'));
        }
        $subscription->next_billing = $subscription->get_next_billing_time();

        return Inertia::render('Paypal/Show', [
            'subscription' => $subscription
        ]);
    }

    public function planDetail(Request $request)
    {
        $res = $this->provider->showPlanDetails($request->get('plan_id'));
        return response()->json($res);
    }
}
