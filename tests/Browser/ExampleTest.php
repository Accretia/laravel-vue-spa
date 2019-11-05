<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
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
            $browser->visit('/')
                ->assertSee('Gallerly');

            $browser->visit('/login')
                ->type('email', "kittinun@merchant.co.th")
                ->type('password', '123123Abc')
                ->press('Log In')
                ->assertSee('Overview');
        });


    }
}