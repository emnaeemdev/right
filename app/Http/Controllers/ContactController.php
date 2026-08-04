<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

class ContactController extends Controller
{
    public function index()
    {
        return view('pages.contact', [
            'meta' => $this->seoMeta('nav.contact', 'contact.meta_description'),
            'breadcrumbs' => $this->breadcrumbs([
                ['label' => __('nav.contact'), 'url' => null],
            ]),
        ]);
    }

    public function store(Request $request)
    {
        $key = 'contact:' . $request->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            return back()->withErrors(['rate_limit' => __('forms.rate_limit')])->withInput();
        }

        RateLimiter::hit($key, 60);

        if ($response = $this->validateSimpleCaptcha($request, 'contact')) {
            return $response;
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|max:5000',
        ]);

        ContactMessage::create($validated);

        return back()->with('success', __('forms.contact_success'));
    }
}
