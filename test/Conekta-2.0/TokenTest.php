<?php

namespace Conekta;

class TokenTest extends BaseTest
{
  public static $validTokenWithCheckout = array(
      'checkout'    => array(
        'returns_control_on' => 'Token'
      ),
    );

  public function testSuccesfulCreateTokenWithCheckout()
  {
    $this->setApiKey();
    $token = Token::create(self::$validTokenWithCheckout);
    $this->assertTrue(strpos(get_class($token), 'Token') !== false);
    $this->assertTrue(strpos(get_class($token->checkout), 'Checkout') !== false);

    print_r($token->checkout);die();
    $this->assertEquals(false, $token->checkout->multifactor_authentication);
    $this->assertEquals(array("cash", "card", "bank_transfer"), (array) $token->checkout->allowed_payment_methods);
    $this->assertEquals(true, $token->checkout->monthly_installments_enabled);
    $this->assertEquals(array(3, 6, 9, 12), (array) $token->checkout->monthly_installments_options);
    $this->assertTrue( strlen($token->checkout->id) == 36);
    $this->assertEquals('checkout', $token->checkout->object);
    $this->assertEquals('Integration', $token->checkout->type);
  }

}
