<?php

namespace Tests\Browser\Pages;

use App\Notifications\GymBoxClassBooked;
use Illuminate\Support\Facades\Notification;
use Laravel\Dusk\Browser;
use Laravel\Dusk\Page as BasePage;

class GymBoxGridironBooking extends BasePage
{
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return 'https://gymbox.legendonlineservices.co.uk/enterprise/account/login';
    }

    /**
     * Assert that the browser is on the page.
     *
     * @param  Browser  $browser
     * @return void
     */
    public function assert(Browser $browser)
    {
        $browser->assertSee('Members Area')
            ->assertSee('Email')
            ->assertSee('Password')
            ->type('login.Email', env('GYMBOX_LOGIN_EMAIL'))
            ->type('login.Password', env('GYMBOX_LOGIN_PASSWORD'))
            ->click('input#login')
            ->assertPathIs('/enterprise/account/home')
            ->assertSee('Welcome Dushaun Alderson-claeys')
            ->clickLink('Make a booking')
            ->assertSee('Online Bookings')
            ->assertVisible('#mainbody > div > div.formOffset > div.formInput > div.cscRightPane > div.cscRightPaneContent')
            ->assertVisible('#View_Activity > form:nth-child(9)')
            ->waitFor('#activities')
            ->assertVisible('#activities > div:nth-child(8) > label > input')
            ->click('#activities > div:nth-child(8) > label > input')
            ->waitFor('#bottomsubmit')
            ->click('#bottomsubmit')
            ->waitFor('#TB_iframeContent', 10);

        $browser->driver->switchTo()->frame('TB_iframeContent');

        $browser->assertSeeIn('#resultContainer > div > div:nth-child(17)', 'Gridiron')
            ->assertVisible('#resultContainer > div > div:nth-child(19) > div > table > tbody > tr:nth-child(2) > td:nth-child(8)')
            ->click('#resultContainer > div > div:nth-child(19) > div > table > tbody > tr:nth-child(2) > td:nth-child(8) > a')
            ->waitFor('#TB_iframeContent', 10);

        $browser->driver->switchTo()->frame('TB_iframeContent');

        $browser->clickLink('OK');

        $browser->driver->switchTo()->defaultContent();

        $browser->assertSee('My Basket')
            ->assertVisible('#btnPayNow')
            ->click('#btnPayNow')
            ->assertSee('Basket Processed')
            ->screenshot('GymBoxGridiron');
    }

    /**
     * Get the element shortcuts for the page.
     *
     * @return array
     */
    public function elements()
    {
        return [
            '@schedule' => 'iframe#TB_iframeContent',
        ];
    }
}
