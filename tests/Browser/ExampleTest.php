<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

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
                ->waitForText('JustBookr')
                ->assertSee('JustBookr');
        });
    }

    public function testBasicRegister()
    {
        $this->browse(function (Browser $browser) {
            $browser->maximize()
                ->visit('/sign-up')
                ->type('full_name', 'Test Account')
                ->type('email', 'testAccount@outlook.com')
                ->type('password', 'secretPassword');
            $browser->script('window.scrollTo(0, document.body.scrollHeight);');
            $browser->press('Sign up')
                ->waitForText('Your university')
                ->assertSee('Your university');
        });
    }

    public function testBasicSetUni()
    {
        $this->browse(function (Browser $browser) {
            $browser->maximize()
                ->visit('/your-university')
                ->type('.col-md-7 > input[type="search"]', 'IUM')
                ->waitForText('Monaco')
                ->click('#app > div.app-layout > div > div > div:nth-child(3)')
                ->waitForText('Discover')
                ->assertSee('Discover');
        });
    }

    public function testBasicPost()
    {
        $this->browse(function (Browser $browser) {
            $browser->maximize()
                ->visit('/sell/9780273753360')
                ->waitForText('Sell books')
                ->waitForText('Post description')
                ->type('#description', 'BROWSER TEST POST')
                ->press('Post')
                ->waitForText('Boost your post')
                ->assertSee('Share');
        });
    }

    public function testBasicSignOut()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/discover')
                ->resize(1024, 768)
                ->waitForText('Sell a book')
                ->click('.dropdown > a')
                ->assertSee('Logout')
                ->clickLink('Logout')
                ->waitForText('Log in')
                ->assertSee('Sign up');
        });
    }

    public function testBasicLogin()
    {
        $this->browse(function (Browser $browser) {
            $browser->maximize()
                ->visit('/login')
                ->waitForText('JustBookr')
                ->assertSee('Login to JustBookr')
                ->type('email', 'testAccount@outlook.com')
                ->type('password', 'secretPassword');
            $browser->script('window.scrollTo(0, document.body.scrollHeight);');
            $browser->press('Login')
                ->waitForText('Sell a book')
                ->assertSee('Sell a book');
        });
    }
}
