<?php

namespace UserRegisterTest\Form\InputFilter\Register;

use UserRegister\Common\Messages;
use UserRegister\Form\InputFilter\Register\RegisterInputFilter;
use Zend\Validator\NotEmpty;
use Zend\Validator\StringLength;
use UserRegister\Form\Validator\NumberFormat;

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
        
        // 社員番号フォーマットチェック
        $numbers = [
            'N1234',        // 5桁
            'N123456',      // 7桁
            '123456',       // 数値のみ
            'NNNNNN',       // 英字のみ
            'N1234A',       // 末尾英字
            'NN1234',       // 先頭以外英字
            'あいうえお',   // 全角文字
            'アカサタナ',   // 全角カタカナ
            'ｱｶｻﾀﾅ'         // 半角カタカナ
        ];
        foreach ($numbers as $number) {
            // 異なるフォーマット
            $input = $this->createInputFilter(['number' => $number]);
            $this->assertFalse($input->isValid());

            $message = $input->getMessages();
            $this->assertThat($message, $this->arrayHasKey('number'));
            $this->assertEquals($message['number'], [NumberFormat::INVALID => Messages::NUMBER_INVAL_FORMAT]);
        }
    }

    /**
     * お名前（姓）の検証
     */    
    public function testFamilyName()
    {
        // 必須チェック
        $input = $this->createInputFilter(['family_name' => '']);
        $this->assertFalse($input->isValid());

        $message = $input->getMessages();
        $this->assertThat($message, $this->arrayHasKey('family_name'));
        $this->assertEquals($message['family_name'], [NotEmpty::IS_EMPTY => Messages::FAMILY_NAME_IS_EMPTY]);

        // 文字列長チェック（1-20）0文字の場合は必須チェックでエラーとなる
        $familyNameOkList = [
            'あ',
            'あいうえおあいうえおあいうえおあいうえお',
            'abcdeabcdeabcdeabcde',
            'ＡＢＣＤＥＡＢＣＤＥＡＢＣＤＥＡＢＣＤＥ',
        ];
        foreach ($familyNameOkList as $name) {
            $input = $this->createInputFilter(['family_name' => $name]);
            $this->assertTrue($input->isValid());
        }
        
        $familyNameNgList = [
            'あいうえおあいうえおあいうえおあいうえおあ',
            'abcdeabcdeabcdeabcdea',
            'ＡＢＣＤＥＡＢＣＤＥＡＢＣＤＥＡＢＣＤＥＡ',
        ];
        foreach ($familyNameNgList as $name) {
            $input = $this->createInputFilter(['family_name' => $name]);
            $this->assertFalse($input->isValid());

            $message = $input->getMessages();
            $this->assertThat($message, $this->arrayHasKey('family_name'));
            $this->assertEquals($message['family_name'][StringLength::TOO_LONG][StringLength::TOO_LONG], Messages::FAMILY_NAME_TOO_LONG);
        }
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
