<?php

namespace Tests\Unit;

use App\ShoppingCart\Cart;
use App\ShoppingCart\CartItem;
use App\ShoppingCart\CartServiceProvider;
use App\ShoppingCart\InvalidRowIDException;
use Mockery;
use PHPUnit\Framework\Assert;
use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Event;
use Illuminate\Session\SessionManager;
use Illuminate\Contracts\Auth\Authenticatable;
use Tests\TestCase;

class CartTest extends TestCase
{
    use CartAssertions;

    /**
     * Set the package service provider.
     *
     * @param \Illuminate\Foundation\Application $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [CartServiceProvider::class];
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('cart.database.connection', 'testing');

        $app['config']->set('session.driver', 'array');

        $app['config']->set('database.default', 'testing');
        $app['config']->set('database.connections.testing', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
    }

    /** @test */
    public function it_has_a_default_instance()
    {
        $cart = $this->getCart();

        $this->assertEquals(Cart::DEFAULT_INSTANCE, $cart->currentInstance());
    }

    /** @test */
    public function it_can_have_multiple_instances()
    {
        $cart = $this->getCart();

        $cart->add([
            'id' => 1,
            'name' => 'First item',
            'price' => 10,
            'period' => 1,
            'qty' => 1,
        ]);

        $cart->instance('wishlist')->add([
            'id' => 1,
            'name' => 'Second item',
            'price' => 10,
            'period' => 1,
            'qty' => 1,
        ]);

        $this->assertItemsInCart(1, $cart->instance(Cart::DEFAULT_INSTANCE));
        $this->assertItemsInCart(1, $cart->instance('wishlist'));
    }
    
    /** @test */
    public function it_can_add_an_item()
    {
        $cart = $this->getCart();

        $cart->add([
            'id' => 1,
            'name' => 'First item',
            'price' => 10,
            'period' => 1,
            'qty' => 1,
        ]);

        $this->assertEquals(1, $cart->count());
    }

    /** @test */
    public function it_can_add_item_with_options()
    {
        $cart = $this->getCart();

        $cartItem = $cart->add([
            'id' => 1,
            'name' => 'Item with options',
            'price' => 10,
            'period' => 1,
            'qty' => 1,
            'options' => [
                'option_1' => 'First option',
                'option_2' => 'Second option',
            ]
        ]);

        $this->assertEquals(1, $cart->count());
        $this->assertEquals(2, count($cartItem->options));
        $this->assertEquals('First option', $cartItem->options->option_1);
        $this->assertEquals('Second option', $cartItem->options->option_2);
    }

    /** @test */
    public function it_can_add_an_option_with_existing_options()
    {
        $cart = $this->getCart();

        $cartItem = $cart->add([
            'id' => 1,
            'name' => 'Item with options',
            'price' => 10,
            'period' => 1,
            'qty' => 1,
            'options' => [
                'option_1' => 'First option',
                'option_2' => 'Second option',
            ]
        ]);

        $cart->updateItem($cartItem->rowId, ['options' => ['option_3' => 'Third option']]);
        $this->assertEquals(3, count($cart->get($cartItem->rowId)->options));
    }

    /** @test */
    public function it_can_add_multiple_options()
    {
        $cart = $this->getCart();

        $cartItem = $cart->add([
            'id' => 1,
            'name' => 'Item with options',
            'price' => 10,
            'period' => 1,
            'qty' => 1,
        ]);

        $cart->updateItem($cartItem->rowId, [
            'options' => [
                'option_1' => 'First option',
                'option_2' => 'Second option'
            ]
        ]);

        $this->assertEquals(2, count($cart->get($cartItem->rowId)->options));
    }

    /** @test */
    public function it_can_add_multiple_options_with_existing_options()
    {
        $cart = $this->getCart();

        $cartItem = $cart->add([
            'id' => 1,
            'name' => 'Item with options',
            'price' => 10,
            'period' => 1,
            'qty' => 1,
            'options' => [
                'option_1' => 'First option',
                'option_2' => 'Second option',
            ]
        ]);

        $cart->updateItem($cartItem->rowId, [
            'options' => [
                'option_3' => 'Third option',
                'option_4' => 'Fourth option'
            ]
        ]);

        $this->assertEquals(4, count($cart->get($cartItem->rowId)->options));
    }

    /** @test */
    public function it_will_overwrite_an_existing_option_if_updated_with_same_option_key()
    {
        $cart = $this->getCart();

        $cartItem = $cart->add([
            'id' => 1,
            'name' => 'Item with options',
            'price' => 10,
            'period' => 10,
            'qty' => 1,
            'options' => [
                'option_1' => 'First option',
                'option_2' => 'Second option',
            ]
        ]);

        $cart->updateItem($cartItem->rowId, ['options' => ['option_2' => 'Changed option']]);
        $this->assertEquals(2, count($cart->get($cartItem->rowId)->options));
        $this->assertEquals('Changed option', $cart->get($cartItem->rowId)->options->option_2);
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Please supply a valid identifier.
     */
    public function it_will_validate_the_identifier()
    {
        $cart = $this->getCart();

        $cart->add([
            'id' => null,
            'name' => 'First item',
            'price' => 10,
            'period' => 1,
            'qty' => 1,
        ]);
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Please supply a valid name.
     */
    public function it_will_validate_the_name()
    {
        $cart = $this->getCart();

        $cart->add([
            'id' => 1,
            'name' => null,
            'price' => 10,
            'period' => 1,
            'qty' => 1,
        ]);
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Please supply a valid quantity.
     */
    public function it_will_validate_the_quantity()
    {
        $cart = $this->getCart();

        $cart->add([
            'id' => 1,
            'name' => 'First item',
            'price' => 10,
            'period' => 1,
            'qty' => 'invalid',
        ]);
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Please supply a valid price.
     */
    public function it_will_validate_the_price()
    {
        $cart = $this->getCart();

        $cart->add([
            'id' => 1,
            'name' => 'First item',
            'price' => 'invalid',
            'period' => 1,
            'qty' => 1,
        ]);
    }

    /** @test */
    public function it_can_update_an_existing_item_in_the_cart_from_an_array()
    {
        $cart = $this->getCart();

        $cartItem = $cart->add([
            'id' => 1,
            'name' => 'First item',
            'price' => 10,
            'period' => 1,
            'qty' => 1,
        ]);

        $cart->updateItem($cartItem->rowId, ['name' => 'Different description']);

        $this->assertItemsInCart(1, $cart);
        $this->assertEquals('Different description', $cart->get($cartItem->rowId)->name);
    }

    /**
     * @test
     * @expectedException \App\ShoppingCart\InvalidRowIDException
     */
    public function it_will_throw_an_exception_if_a_rowid_was_not_found()
    {
        $cart = $this->getCart();

        $cart->add([
            'id' => 1,
            'name' => 'First item',
            'price' => 10,
            'period' => 1,
            'qty' => 1,
        ]);

        $cart->updateItem('none-existing-rowid', [
            'id' => 1,
            'name' => 'Different description',
            ]);
    }

    /** @test */
    public function it_can_remove_an_item_from_the_cart()
    {
        $cart = $this->getCart();

        $cartItem = $cart->add([
            'id' => 1,
            'name' => 'First item',
            'price' => 10,
            'period' => 1,
            'qty' => 1,
        ]);

        $cart->remove($cartItem->rowId);

        $this->assertItemsInCart(0, $cart);
        $this->assertRowsInCart(0, $cart);
    }

    /** @test */
    public function it_can_get_the_content_of_the_cart()
    {
        $cart = $this->getCart();

        $cart->add([
            'id' => 1,
            'name' => 'First item',
            'price' => 10,
            'period' => 1,
            'qty' => 1,
        ]);
        $cart->add([
            'id' => 2,
            'name' => 'Second item',
            'price' => 10,
            'period' => 1,
            'qty' => 1,
        ]);

        $content = $cart->content();

        $this->assertInstanceOf(Collection::class, $content);
        $this->assertCount(2, $content);
    }

    /** @test */
    public function it_will_return_an_empty_collection_if_the_cart_is_empty()
    {
        $cart = $this->getCart();

        $content = $cart->content();

        $this->assertInstanceOf(Collection::class, $content);
        $this->assertCount(0, $content);
    }

    /** @test */
    public function it_can_destroy_a_cart()
    {
        $cart = $this->getCart();

        $cart->add([
            'id' => 1,
            'name' => 'First item',
            'price' => 10,
            'period' => 1,
            'qty' => 1,
        ]);

        $this->assertItemsInCart(1, $cart);

        $cart->destroy();

        $this->assertItemsInCart(0, $cart);
    }

    /** @test */
    public function it_can_get_the_total_price_of_the_cart_content()
    {
        $cart = $this->getCart();

        $cart->add([
            'id' => 1,
            'name' => 'First item',
            'price' => 10,
            'period' => 1,
            'qty' => 1,
        ]);
        $cart->add([
            'id' => 2,
            'name' => 'Second item',
            'price' => 10,
            'period' => 1,
            'qty' => 2,
        ]);

        $this->assertItemsInCart(3, $cart);
        $this->assertEquals(30.00, $cart->subtotal());
    }

    /** @test */
    public function it_can_return_a_formatted_total()
    {
        $cart = $this->getCart();

        $cart->add([
            'id' => 1,
            'name' => 'First item',
            'price' => 2000,
            'period' => 1,
            'qty' => 1,
        ]);
        $cart->add([
            'id' => 2,
            'name' => 'Second item',
            'price' => 1500,
            'period' => 1,
            'qty' => 2,
        ]);

        $this->assertItemsInCart(3, $cart);
        $this->assertEquals('5.000,00', $cart->subtotal(2, ',', '.'));
    }

    /**
     * Get an instance of the cart.
     *
     * @return Cart
     */
    private function getCart()
    {
        $session = $this->app->make('session');
        $events = $this->app->make('events');

        return new Cart($session, $events);
    }

    /**
     * Set the config number format.
     * 
     * @param int    $decimals
     * @param string $decimalPoint
     * @param string $thousandSeperator
     */
    private function setConfigFormat($decimals, $decimalPoint, $thousandSeperator)
    {
        $this->app['config']->set('cart.format.decimals', $decimals);
        $this->app['config']->set('cart.format.decimal_point', $decimalPoint);
        $this->app['config']->set('cart.format.thousand_seperator', $thousandSeperator);
    }
}
