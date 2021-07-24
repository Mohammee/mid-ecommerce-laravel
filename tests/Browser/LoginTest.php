<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * A Dusk test example.
     *
     * @test
     */
    public function a_user_can_not_login_with_invalid_credentials()
    {
        $this->browse(function (Browser $browser) {
            $user = User::factory()->create([
                'email' => 'mohammad@gmail.com',
                'password' => bcrypt('mohammad')
            ]);

            $browser->visit('/')
                ->visit('/login')
                ->assertSee('Returning Customer')
                ->type('email' , $user->email)
                ->type('password' , 'wrong-password')
                ->press('Login')
                ->assertPathIs('/login')
                ->assertSee('These credentials do not match our records.');
        });
    }


    /**
     * A Dusk test example.
     *
     * @test
     */
    public function a_user_can_login_with_valid_credentials()
    {
        $this->browse(function (Browser $browser) {
            $user = User::factory()->create([
                'email' => 'mohammad@gmail.com',
                'password' => bcrypt('mohammad')
            ]);

            $browser->visit('/shop')
                ->visit('/login')
                ->assertSee('Returning Customer')
                ->type('email' , $user->email)
                ->type('password' , 'mohammad')
                ->press('Login')
                ->assertPathIs('/shop');
        });
    }
}
