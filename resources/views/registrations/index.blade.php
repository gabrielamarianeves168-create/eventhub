<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Registration;
use App\Services\RegistrationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RegistrationController extends Controller
{
    public function index(): View
    {
        $registrations = auth()->user()
            ->registrations()
            ->with([
                'event.category',
            ])
            ->latest('registered_at')
            ->get();

        return view(
            'registrations.index',
            compact('registrations')
        );
    }

    public function store(
        Event $event,
        RegistrationService $service
    ): RedirectResponse {
        try {
            $service->register(
                auth()->user(),
                $event
            );
        } catch (\DomainException $exception) {
            return back()->with(
                'error',
                $exception->getMessage()
            );
        }

        return redirect()
            ->route('events.show', $event)
            ->with(
                'success',
                'Inscrição realizada com sucesso.'
            );
    }

    public function destroy(
        Registration $registration,
        RegistrationService $service
    ): RedirectResponse {
        try {
            $service->cancel(
                auth()->user(),
                $registration
            );
        } catch (\DomainException $exception) {
            return back()->with(
                'error',
                $exception->getMessage()
            );
        }

        return redirect()
            ->route('registrations.index')
            ->with(
                'success',
                'Inscrição cancelada com sucesso.'
            );
    }
}