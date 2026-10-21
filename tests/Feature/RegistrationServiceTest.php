<?php 
namespace Tests\Feature; 
use App\Models\Event; 
use App\Models\Registration; 
use App\Models\User; 
use App\Services\RegistrationService; 
use Illuminate\Foundation\Testing\RefreshDatabase; 
use Tests\TestCase; 
class RegistrationServiceTest extends TestCase 
{ 
use RefreshDatabase; 
public function test_user_can_register_for_event(): void 
{ 
$user = User::factory()->create(); 
$event = Event::factory()->create([ 
'capacity' => 10, 
]); 
$service = app(RegistrationService::class); 
$registration = $service->register( 
$user, 
$event 
); 
$this->assertDatabaseHas( 
'registrations', 
 
            [ 
                'id' => $registration->id, 
                'user_id' => $user->id, 
                'event_id' => $event->id, 
                'status' => 'confirmed', 
            ] 
        ); 
    } 
 
    public function test_user_cannot_register_twice(): void 
    { 
        $user = User::factory()->create(); 
 
        $event = Event::factory()->create(); 
 
        Registration::factory()->create([ 
            'user_id' => $user->id, 
            'event_id' => $event->id, 
            'status' => 'confirmed', 
        ]); 
 
        $service = app(RegistrationService::class); 
 
        $this->expectException( 
            \DomainException::class 
        ); 
 
        $service->register( 
            $user, 
            $event 
        ); 
    } 
 
    public function test_user_cannot_register_when_event_is_full(): void 
    { 
        $event = Event::factory()->create([ 
            'capacity' => 1, 
        ]); 
 
        $firstUser = User::factory()->create(); 
 
        Registration::factory()->create([ 
            'user_id' => $firstUser->id, 
            'event_id' => $event->id, 
            'status' => 'confirmed', 
        ]); 
 
        $secondUser = User::factory()->create(); 
 
        $service = app(RegistrationService::class); 
 
        $this->expectException( 
            \DomainException::class 
        ); 
 
 
        $service->register( 
            $secondUser, 
            $event 
        ); 
    } 
 
    public function test_canceled_registration_can_be_reactivated(): void 
    { 
        $user = User::factory()->create(); 
 
        $event = Event::factory()->create([ 
            'capacity' => 10, 
        ]); 
 
        Registration::factory()->create([ 
            'user_id' => $user->id, 
            'event_id' => $event->id, 
            'status' => 'canceled', 
            'canceled_at' => now(), 
        ]); 
 
        $service = app(RegistrationService::class); 
 
        $registration = $service->register( 
            $user, 
            $event 
        ); 
 
        $this->assertEquals( 
            'confirmed', 
            $registration->status 
        ); 
 
        $this->assertNull( 
            $registration->canceled_at 
        ); 
    } 
 
    public function test_user_cannot_register_for_canceled_event(): void 
    { 
        $user = User::factory()->create(); 
 
        $event = Event::factory()->create([ 
            'status' => 'canceled', 
        ]); 
 
        $service = app(RegistrationService::class); 
 
        $this->expectException( 
            \DomainException::class 
        ); 
 
        $service->register( 
$user, 
$event 
); 
} 
} 