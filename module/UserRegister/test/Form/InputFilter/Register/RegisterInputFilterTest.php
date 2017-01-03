<?php

namespace UserRegisterTest\Form\InputFilter\Register;

use UserRegister\Common\Messages;
use UserRegister\Form\InputFilter\Register\RegisterInputFilter;
use Zend\Validator\NotEmpty;

class RegisterInputFilterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * テストケース初回時（1回のみ呼ばれる） 
     */    
    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();
    }

    /**
     * テストケースメソッド開始時（メソッド毎に呼ばれる）
     */
    public function setUp()
    {
        parent::setUp();
    }
    
    /**
     * テストケースメソッド終了時（メソッド毎に呼ばれる）
     */
    public function tearDown()
    {
        parent::tearDown();
    }

    /**
     * 有効な値の検証
     */    
    public function testInputFilter()
    {
        // 有効値の確認
        $input = $this->createInputFilter();
        $this->assertTrue($input->isValid());

        // 有効値のためエラーメッセージが存在しないことを確認
        $message = $input->getMessages();
        $this->assertEmpty($message);
    }
    
    /**
     * 社員番号の検証
     */
    public function testNumber()
    {
        // 社員番号が空の場合
        $input = $this->createInputFilter(['number' => '']);
        $this->assertFalse($input->isValid());

        $message = $input->getMessages();
        $this->assertThat($message, $this->arrayHasKey('number'));
        $this->assertEquals($message['number'], [NotEmpty::IS_EMPTY => Messages::NUMBER_IS_EMPTY]);
    }

    private function createInputFilter(array $data = [])
    {
        $input = new RegisterInputFilter();
        $input->setData(array_merge($this->inputData(), $data ? : []));
        return $input;
    }
    
    private function inputData()
    {
        return [
            'number' => 'A00001',
            'family_name' => '姓',
            'last_name' => '名',
            'family_name_kana' => 'セイ',
            'last_name_kana' => 'メイ',
            'phone_number' => '0311112222',
            'mobile_phone_number' => '',
            'post_code1' => '100',
            'post_code2' => '0001',
            'prefecture_id' => '1',
            'address_city' => '市区町村',
            'address_other' => 'その他',
            'section_id' => '2',
        ];
    }
}
