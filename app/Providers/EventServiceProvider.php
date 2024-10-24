<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * La mappa degli eventi e dei listener dell'applicazione.
     *
     * @var array
     */
    protected $listen = [
        // 'App\Events\SomeEvent' => [
        //     'App\Listeners\EventListener',
        // ],
    ];

    /**
     * Registra qualsiasi evento per la tua applicazione.
     */
    public function boot()
    {
        parent::boot();
    }
}
