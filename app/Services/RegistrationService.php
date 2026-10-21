<?php

namespace App\Services;

use App\Models\Event;
use App\Models\Registration;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class RegistrationService
{
    public function register(User $user, Event $event): Registration
    {
        return DB::transaction(
            function () use ($user, $event) {
                if ($event->isCanceled()) {
                    throw new \DomainException(
                        'Não é possível se inscrever em um evento cancelado.'
                    );
                }

                if ($event->hasStarted()) {
                    throw new \DomainException(
                        'Não é possível se inscrever em um evento que já começou.'
                    );
                }

                $registration = Registration::where('user_id', $user->id)
                    ->where('event_id', $event->id)
                    ->first();

                if ($registration && $registration->isConfirmed()) {
                    throw new \DomainException(
                        'Você já está inscrito neste evento.'
                    );
                }

                $confirmedCount = Registration::where('event_id', $event->id)
                    ->where('status', 'confirmed')
                    ->count();

                if ($confirmedCount >= $event->capacity) {
                    throw new \DomainException(
                        'Não existem vagas disponíveis.'
                    );
                }

                if ($registration) {
                    $registration->update([
                        'status' => 'confirmed',
                        'registered_at' => now(),
                        'canceled_at' => null,
                    ]);

                    return $registration->fresh();
                }

                return Registration::create([
                    'user_id' => $user->id,
                    'event_id' => $event->id,
                    'status' => 'confirmed',
                    'registered_at' => now(),
                ]);
            }
        );
    }

    public function cancel(User $user, Registration $registration): void
    {
        if ($registration->user_id !== $user->id) {
            abort(403);
        }

        if ($registration->isCanceled()) {
            throw new \DomainException(
                'Esta inscrição já foi cancelada.'
            );
        }

        $event = $registration->event;

        if ($event->hasStarted()) {
            throw new \DomainException(
                'Não é possível cancelar a inscrição após o início do evento.'
            );
        }

        $registration->update([
            'status' => 'canceled',
            'canceled_at' => now(),
        ]);
    }
}