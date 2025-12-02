<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PaymentAllowed
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if booking exists
        if (!session()->has('pending_booking'))
            return redirect()->back()->with([
                'wireui.notification' => [
                    'icon' => 'warning',
                    'title' => 'No Booking Found',
                    'description' => 'Please make a booking first.',
                ]
            ]);

        // Check if booking is once-off or for a membership
        $pending_booking = session('pending_booking');
        if ($pending_booking['booking_type'] == 'once-off')
            return $next($request);


        // If user is not authorized and want a membership, they need to sign up first
        if (!$request->user()) {
            // Save Intended URL for after registration
            session()->put('url.intended', $request->fullUrl());

            return redirect(route('register'));
        }

        // Does user already have membership?
        if ($request->user()->hasMembership) // TODO: membership logic needs implementation
            return redirect(route('booking.success'));

        // Goes to payment page
        return $next($request);
    }
}
