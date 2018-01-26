<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Tests\Browser\Pages\GymBoxGridironBooking;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ExampleTest extends DuskTestCase
{
    /**
     * A basic browser test example.
     *
     * @return void
     */
    public function testBasicExample()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new GymBoxGridironBooking());
        });
    }
}
