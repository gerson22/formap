<?php
namespace Formap\tests;
use Formap\Form;
class FormapTest extends \PHPUnit_Framework_TestCase
{
    /** @var  Formap */
    protected $formap;
    public function setUp()
    {
        $this->formap = new Form('users');
    }

    public function testCreateForm($id, $method, $action)
    {
        return $this->formap
                    ->setId($id)
                    ->setMethod($method)
                    ->setAction($action)
                    ->all()
                    ->toHTML();
    }
}
