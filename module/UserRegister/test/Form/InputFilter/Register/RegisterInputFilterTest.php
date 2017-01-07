<?php

namespace UserRegisterTest\Form\InputFilter\Register;

use UserRegister\Common\Messages;
use UserRegister\Form\InputFilter\Register\RegisterInputFilter;
use UserRegister\Form\Validator\StringKatakana;
use Zend\Validator\Between;
use Zend\Validator\Digits;
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

    /**
     * お名前（名）の検証
     */    
    public function testLastName()
    {
        // 必須チェック
        $input = $this->createInputFilter(['last_name' => '']);
        $this->assertFalse($input->isValid());

        $message = $input->getMessages();
        $this->assertThat($message, $this->arrayHasKey('last_name'));
        $this->assertEquals($message['last_name'], [NotEmpty::IS_EMPTY => Messages::LAST_NAME_IS_EMPTY]);

        // 文字列長チェック（1-20）0文字の場合は必須チェックでエラーとなる
        $lastNameOkList = [
            'あ',
            'あいうえおあいうえおあいうえおあいうえお',
            'abcdeabcdeabcdeabcde',
            'ＡＢＣＤＥＡＢＣＤＥＡＢＣＤＥＡＢＣＤＥ',
        ];
        foreach ($lastNameOkList as $name) {
            $input = $this->createInputFilter(['last_name' => $name]);
            $this->assertTrue($input->isValid());
        }
        
        $lastNameNgList = [
            'あいうえおあいうえおあいうえおあいうえおあ',
            'abcdeabcdeabcdeabcdea',
            'ＡＢＣＤＥＡＢＣＤＥＡＢＣＤＥＡＢＣＤＥＡ',
        ];
        foreach ($lastNameNgList as $name) {
            $input = $this->createInputFilter(['last_name' => $name]);
            $this->assertFalse($input->isValid());

            $message = $input->getMessages();
            $this->assertThat($message, $this->arrayHasKey('last_name'));
            $this->assertEquals($message['last_name'][StringLength::TOO_LONG][StringLength::TOO_LONG], Messages::LAST_NAME_TOO_LONG);
        }
    }

    /**
     * お名前（セイ）の検証
     */    
    public function testFamilyNameKana()
    {
        // 必須チェック
        $input = $this->createInputFilter(['family_name_kana' => '']);
        $this->assertFalse($input->isValid());

        $message = $input->getMessages();
        $this->assertThat($message, $this->arrayHasKey('family_name_kana'));
        $this->assertEquals($message['family_name_kana'], [NotEmpty::IS_EMPTY => Messages::FAMILY_NAME_KANA_IS_EMPTY]);

        // 文字列長チェック（1-40）0文字の場合は必須チェックでエラーとなる
        $okList = [
            'ア',
            'アイウエオアイウエオアイウエオアイウエオアイウエオアイウエオアイウエオアイウエオ',
        ];
        foreach ($okList as $name) {
            $input = $this->createInputFilter(['family_name_kana' => $name]);
            $this->assertTrue($input->isValid());
        }
        
        $ngList = [
            'アイウエオアイウエオアイウエオアイウエオアイウエオアイウエオアイウエオアイウエオア',
        ];
        foreach ($ngList as $name) {
            $input = $this->createInputFilter(['family_name_kana' => $name]);
            $this->assertFalse($input->isValid());

            $message = $input->getMessages();
            $this->assertThat($message, $this->arrayHasKey('family_name_kana'));
            $this->assertEquals($message['family_name_kana'][StringLength::TOO_LONG][StringLength::TOO_LONG], Messages::FAMILY_NAME_KANA_TOO_LONG);
        }
        
        // カタカナ文字以外はエラーとする
        $okList = [
            'ｱｲｳｴｵ',    // 半角カタカナ、半角カタカナは全角カタカナに返還される
        ];
        foreach ($okList as $name) {
            $input = $this->createInputFilter(['family_name_kana' => $name]);
            $this->assertTrue($input->isValid());
        }

        $ngList = [
            '12345',        // 数値
            'abcde',        // 英字
            'あいうえお',   // 全角文字
            '+:*@---',      // 記号
        ];
        foreach ($ngList as $name) {
            $input = $this->createInputFilter(['family_name_kana' => $name]);
            $this->assertFalse($input->isValid());

            $message = $input->getMessages();
            $this->assertThat($message, $this->arrayHasKey('family_name_kana'));
            $this->assertEquals($message['family_name_kana'], [StringKatakana::INVALID_ZENKAKU => Messages::INVALID_STRING_KATAKANA_ZENKAKU]);
        }
    }

    /**
     * お名前（セイ）の検証
     */    
    public function testLastNameKana()
    {
        // 必須チェック
        $input = $this->createInputFilter(['last_name_kana' => '']);
        $this->assertFalse($input->isValid());

        $message = $input->getMessages();
        $this->assertThat($message, $this->arrayHasKey('last_name_kana'));
        $this->assertEquals($message['last_name_kana'], [NotEmpty::IS_EMPTY => Messages::LAST_NAME_KANA_IS_EMPTY]);

        // 文字列長チェック（1-40）0文字の場合は必須チェックでエラーとなる
        $okList = [
            'ア',
            'アイウエオアイウエオアイウエオアイウエオアイウエオアイウエオアイウエオアイウエオ',
        ];
        foreach ($okList as $name) {
            $input = $this->createInputFilter(['last_name_kana' => $name]);
            $this->assertTrue($input->isValid());
        }
        
        $ngList = [
            'アイウエオアイウエオアイウエオアイウエオアイウエオアイウエオアイウエオアイウエオア',
        ];
        foreach ($ngList as $name) {
            $input = $this->createInputFilter(['last_name_kana' => $name]);
            $this->assertFalse($input->isValid());

            $message = $input->getMessages();
            $this->assertThat($message, $this->arrayHasKey('last_name_kana'));
            $this->assertEquals($message['last_name_kana'][StringLength::TOO_LONG][StringLength::TOO_LONG], Messages::LAST_NAME_KANA_TOO_LONG);
        }
        
        // カタカナ文字以外はエラーとする
        $okList = [
            'ｱｲｳｴｵ',    // 半角カタカナ、半角カタカナは全角カタカナに返還される
        ];
        foreach ($okList as $name) {
            $input = $this->createInputFilter(['last_name_kana' => $name]);
            $this->assertTrue($input->isValid());
        }

        $ngList = [
            '12345',        // 数値
            'abcde',        // 英字
            'あいうえお',   // 全角文字
            '+:*@---',      // 記号
        ];
        foreach ($ngList as $name) {
            $input = $this->createInputFilter(['last_name_kana' => $name]);
            $this->assertFalse($input->isValid());

            $message = $input->getMessages();
            $this->assertThat($message, $this->arrayHasKey('last_name_kana'));
            $this->assertEquals($message['last_name_kana'], [StringKatakana::INVALID_ZENKAKU => Messages::INVALID_STRING_KATAKANA_ZENKAKU]);
        }
    }
    
    /**
     * 電話番号
     */
    public function testPhoneNumber()
    {
        // 桁数チェック 9桁
        $input = $this->createInputFilter(['phone_number' => '031111222']);
        $this->assertFalse($input->isValid());

        $message = $input->getMessages();
        $this->assertThat($message, $this->arrayHasKey('phone_number'));
        $this->assertEquals($message['phone_number'][StringLength::TOO_SHORT][StringLength::TOO_SHORT], Messages::PHONE_NUMBER_LENGTH);

        // 桁数チェック 11桁
        $input = $this->createInputFilter(['phone_number' => '03111122229']);
        $this->assertFalse($input->isValid());

        $message = $input->getMessages();
        $this->assertThat($message, $this->arrayHasKey('phone_number'));
        $this->assertEquals($message['phone_number'][StringLength::TOO_LONG][StringLength::TOO_LONG], Messages::PHONE_NUMBER_LENGTH);

        // 数値以外
        $ngList = [
            'aaaaaaaaaa',
            'ａａａａａａａａａａ',
            'ああああああああああ',
            'アアアアアアアアアア',
            'ｱｱｱｱｱｱｱｱｱｱ',
            '０３１１１１２２２２',
        ];
        foreach ($ngList as $number) {
            $input = $this->createInputFilter(['phone_number' => $number]);
            $this->assertFalse($input->isValid());

            $message = $input->getMessages();
            $this->assertThat($message, $this->arrayHasKey('phone_number'));
            $this->assertEquals($message['phone_number'], [Digits::NOT_DIGITS => Messages::PHONE_NUMBER_NOT_DIGITS]);
        }
        
        // 空値は正常とする
        $input = $this->createInputFilter(['phone_number' => '', 'mobile_phone_number' => '08011112222']);
        $this->assertTrue($input->isValid());
    }

    /**
     * 携帯電話番号
     */
    public function testMobliePhoneNumber()
    {
        // 桁数チェック 10桁
        $input = $this->createInputFilter(['mobile_phone_number' => '0801111222']);
        $this->assertFalse($input->isValid());

        $message = $input->getMessages();
        $this->assertThat($message, $this->arrayHasKey('mobile_phone_number'));
        $this->assertEquals($message['mobile_phone_number'][StringLength::TOO_SHORT][StringLength::TOO_SHORT], Messages::MOBILE_PHONE_NUMBER_LENGTH);

        // 桁数チェック 12桁
        $input = $this->createInputFilter(['mobile_phone_number' => '080111122229']);
        $this->assertFalse($input->isValid());

        $message = $input->getMessages();
        $this->assertThat($message, $this->arrayHasKey('mobile_phone_number'));
        $this->assertEquals($message['mobile_phone_number'][StringLength::TOO_LONG][StringLength::TOO_LONG], Messages::MOBILE_PHONE_NUMBER_LENGTH);

        // 数値以外
        $ngList = [
            'aaaaaaaaaaa',
            'ａａａａａａａａａａａ',
            'あああああああああああ',
            'アアアアアアアアアアア',
            'ｱｱｱｱｱｱｱｱｱｱｱ',
            '０８０１１１１２２２２',
        ];
        foreach ($ngList as $number) {
            $input = $this->createInputFilter(['mobile_phone_number' => $number]);
            $this->assertFalse($input->isValid());

            $message = $input->getMessages();
            $this->assertThat($message, $this->arrayHasKey('mobile_phone_number'));
            $this->assertEquals($message['mobile_phone_number'], [Digits::NOT_DIGITS => Messages::MOBILE_PHONE_NUMBER_NOT_DIGITS]);
        }
        
        // 空値は正常とする
        $input = $this->createInputFilter(['phone_number' => '0311112222', 'mobile_phone_number' => '']);
        $this->assertTrue($input->isValid());
    }

    /**
     * 電話番号または検体電話番号が必須
     */    
    public function testPhoneNumberOrMobilePhoneNumber()
    {
        // 両方設定されている場合
        $input = $this->createInputFilter(['phone_number' => '0311112222', 'mobile_phone_number' => '08011112222']);
        $this->assertTrue($input->isValid());

        // 電話番号のみの場合
        $input = $this->createInputFilter(['phone_number' => '0311112222', 'mobile_phone_number' => '']);
        $this->assertTrue($input->isValid());

        // 携帯電話番号のみの場合
        $input = $this->createInputFilter(['phone_number' => '', 'mobile_phone_number' => '08011112222']);
        $this->assertTrue($input->isValid());

        // 両方とも空の場合
        $input = $this->createInputFilter(['phone_number' => '', 'mobile_phone_number' => '']);
        $this->assertFalse($input->isValid());

        $message = $input->getMessages();
        $this->assertThat($message, $this->arrayHasKey('phone_number'));
        $this->assertEquals($message['phone_number'], [NotEmpty::IS_EMPTY => Messages::PHONE_NUMBER_IS_EMPTY]);
        $this->assertThat($message, $this->arrayHasKey('mobile_phone_number'));
        $this->assertEquals($message['mobile_phone_number'], [NotEmpty::IS_EMPTY => Messages::MOBILE_PHONE_NUMBER_IS_EMPTY]);
    }

    /**
     * 郵便番号1の検証
     */    
    public function testPostCode1()
    {
        // 必須チェック
        $input = $this->createInputFilter(['post_code1' => '']);
        $this->assertFalse($input->isValid());

        $message = $input->getMessages();
        $this->assertThat($message, $this->arrayHasKey('post_code1'));
        $this->assertEquals($message['post_code1'], [NotEmpty::IS_EMPTY => Messages::POST_CODE_IS_EMPTY]);

        // 文字列長チェック 2桁
        $input = $this->createInputFilter(['post_code1' => '12']);
        $this->assertFalse($input->isValid());

        $message = $input->getMessages();
        $this->assertThat($message, $this->arrayHasKey('post_code1'));
        $this->assertEquals($message['post_code1'][StringLength::TOO_SHORT][StringLength::TOO_SHORT], Messages::POST_CODE_LENGTH);

        // 文字列長チェック 4桁
        $input = $this->createInputFilter(['post_code1' => '1234']);
        $this->assertFalse($input->isValid());

        $message = $input->getMessages();
        $this->assertThat($message, $this->arrayHasKey('post_code1'));
        $this->assertEquals($message['post_code1'][StringLength::TOO_LONG][StringLength::TOO_LONG], Messages::POST_CODE_LENGTH);

        // 数値以外
        $ngList = [
            'aaa',
            'ａａａ',
            'あああ',
            'アアア',
            'ｱｱｱ',
            '１１１',
        ];
        foreach ($ngList as $number) {
            $input = $this->createInputFilter(['post_code1' => $number]);
            $this->assertFalse($input->isValid());

            $message = $input->getMessages();
            $this->assertThat($message, $this->arrayHasKey('post_code1'));
            $this->assertEquals($message['post_code1'], [Digits::NOT_DIGITS => Messages::POST_CODE_NOT_DIGITS]);
        }
    }

    /**
     * 郵便番号2の検証
     */    
    public function testPostCode2()
    {
        // 必須チェック
        $input = $this->createInputFilter(['post_code2' => '']);
        $this->assertFalse($input->isValid());

        $message = $input->getMessages();
        $this->assertThat($message, $this->arrayHasKey('post_code2'));
        $this->assertEquals($message['post_code2'], [NotEmpty::IS_EMPTY => Messages::POST_CODE_IS_EMPTY]);

        // 文字列長チェック 3桁
        $input = $this->createInputFilter(['post_code2' => '123']);
        $this->assertFalse($input->isValid());

        $message = $input->getMessages();
        $this->assertThat($message, $this->arrayHasKey('post_code2'));
        $this->assertEquals($message['post_code2'][StringLength::TOO_SHORT][StringLength::TOO_SHORT], Messages::POST_CODE_LENGTH);

        // 文字列長チェック 5桁
        $input = $this->createInputFilter(['post_code2' => '12345']);
        $this->assertFalse($input->isValid());

        $message = $input->getMessages();
        $this->assertThat($message, $this->arrayHasKey('post_code2'));
        $this->assertEquals($message['post_code2'][StringLength::TOO_LONG][StringLength::TOO_LONG], Messages::POST_CODE_LENGTH);

        // 数値以外
        $ngList = [
            'aaaa',
            'ａａａａ',
            'ああああ',
            'アアアア',
            'ｱｱｱｱ',
            '１１１１',
        ];
        foreach ($ngList as $number) {
            $input = $this->createInputFilter(['post_code2' => $number]);
            $this->assertFalse($input->isValid());

            $message = $input->getMessages();
            $this->assertThat($message, $this->arrayHasKey('post_code2'));
            $this->assertEquals($message['post_code2'], [Digits::NOT_DIGITS => Messages::POST_CODE_NOT_DIGITS]);
        }
    }

    /**
     * 都道府県の検証
     */    
    public function testPrefectureId()
    {
        // 必須チェック
        $input = $this->createInputFilter(['prefecture_id' => '']);
        $this->assertFalse($input->isValid());

        $message = $input->getMessages();
        $this->assertThat($message, $this->arrayHasKey('prefecture_id'));
        $this->assertEquals($message['prefecture_id'], [NotEmpty::IS_EMPTY => Messages::PREFECTURE_IS_EMPTY]);

        // 範囲外チェック
        $input = $this->createInputFilter(['prefecture_id' => '0']);
        $this->assertFalse($input->isValid());

        $message = $input->getMessages();
        $this->assertThat($message, $this->arrayHasKey('prefecture_id'));
        $this->assertEquals($message['prefecture_id'], [Between::NOT_BETWEEN => Messages::PREFECTURE_INVAL_DATA]);
        
        $input = $this->createInputFilter(['prefecture_id' => '48']);
        $this->assertFalse($input->isValid());

        $message = $input->getMessages();
        $this->assertThat($message, $this->arrayHasKey('prefecture_id'));
        $this->assertEquals($message['prefecture_id'], [Between::NOT_BETWEEN => Messages::PREFECTURE_INVAL_DATA]);

        // 有効なIDの確認
        for ($i = 1; $i <= 47; $i++) {
            $prefCode = strval($i);
            $input = $this->createInputFilter(['prefecture_id' => $prefCode]);
            $this->assertTrue($input->isValid());
        }
    }

    /**
     * 市区町村の検証
     */    
    public function testAddressCity()
    {
        // 必須チェック
        $input = $this->createInputFilter(['address_city' => '']);
        $this->assertFalse($input->isValid());

        $message = $input->getMessages();
        $this->assertThat($message, $this->arrayHasKey('address_city'));
        $this->assertEquals($message['address_city'], [NotEmpty::IS_EMPTY => Messages::ADDRESS_CITY_IS_EMPTY]);

        // 桁数チェック 41桁
        $input = $this->createInputFilter(['address_city' => 'あいうえおあいうえおあいうえおあいうえおあいうえおあいうえおあいうえおあいうえおあ']);
        $this->assertFalse($input->isValid());

        $message = $input->getMessages();
        $this->assertThat($message, $this->arrayHasKey('address_city'));
        $this->assertEquals($message['address_city'][StringLength::TOO_LONG][StringLength::TOO_LONG], Messages::ADDRESS_CITY_LENGTH);
    }

    /**
     * 住所その他の検証
     */    
    public function testAddressOther()
    {
        // 空値でもOK
        $input = $this->createInputFilter(['address_other' => '']);
        $this->assertTrue($input->isValid());

        // 桁数チェック 41桁
        $input = $this->createInputFilter(['address_other' => 'あいうえおあいうえおあいうえおあいうえおあいうえおあいうえおあいうえおあいうえおあ']);
        $this->assertFalse($input->isValid());

        $message = $input->getMessages();
        $this->assertThat($message, $this->arrayHasKey('address_other'));
        $this->assertEquals($message['address_other'][StringLength::TOO_LONG][StringLength::TOO_LONG], Messages::ADDRESS_CITY_OTHER);
    }

    /**
     * 所属部署の検証
     */    
    public function testSectionId()
    {
        // 必須チェック
        $input = $this->createInputFilter(['section_id' => '']);
        $this->assertFalse($input->isValid());

        $message = $input->getMessages();
        $this->assertThat($message, $this->arrayHasKey('section_id'));
        $this->assertEquals($message['section_id'], [NotEmpty::IS_EMPTY => Messages::SECTION_IS_EMPTY]);

        // 数値以外
        $ngList = [
            'aaaa',
            'ａａａａ',
            'ああああ',
            'アアアア',
            'ｱｱｱｱ',
            '１１１１',
        ];
        foreach ($ngList as $number) {
            $input = $this->createInputFilter(['section_id' => $number]);
            $this->assertFalse($input->isValid());

            $message = $input->getMessages();
            $this->assertThat($message, $this->arrayHasKey('section_id'));
            $this->assertEquals($message['section_id'], [Digits::NOT_DIGITS => Messages::SECTION_INVAL_DATA]);
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
