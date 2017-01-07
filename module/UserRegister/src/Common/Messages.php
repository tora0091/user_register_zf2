<?php

namespace UserRegister\Common;

class Messages
{
    // バリデーションメッセージ
    
    // 社員番号
    const NUMBER_INVAL_FORMAT = "社員番号の形式が異なります";
    const NUMBER_IS_EMPTY = "社員番号は必須です";
    
    // 名前（姓）
    const FAMILY_NAME_IS_EMPTY = "名前（姓）は必須です";
    const FAMILY_NAME_TOO_SHORT = "名前（姓）は20文字以内で入力してください";
    const FAMILY_NAME_TOO_LONG = "名前（姓）は20文字以内で入力してください";

    // 名前（名）
    const LAST_NAME_IS_EMPTY = "名前（名）は必須です";
    const LAST_NAME_TOO_SHORT = "名前（名）は20文字以内で入力してください";
    const LAST_NAME_TOO_LONG = "名前（名）は20文字以内で入力してください";
    
    // 名前（セイ）
    const FAMILY_NAME_KANA_IS_EMPTY = "名前（セイ）は必須です";
    const FAMILY_NAME_KANA_TOO_SHORT = "名前（セイ）は40文字以内で入力してください";
    const FAMILY_NAME_KANA_TOO_LONG = "名前（セイ）は40文字以内で入力してください";

    // 名前（メイ）
    const LAST_NAME_KANA_IS_EMPTY = "名前（メイ）は必須です";
    const LAST_NAME_KANA_TOO_SHORT = "名前（メイ）は40文字以内で入力してください";
    const LAST_NAME_KANA_TOO_LONG = "名前（メイ）は40文字以内で入力してください";
    
    // 性別
    const SEX_IS_EMPTY = "性別は必須です";
    const SEX_NOT_IN_ARRAY = "性別に不正な値が設定されています";

    // 電話番号
    const PHONE_NUMBER_IS_EMPTY = "電話番号は必須です";
    const PHONE_NUMBER_NOT_DIGITS = "電話番号は数値で入力してください";
    const PHONE_NUMBER_LENGTH = "電話番号は10文字で入力してください";

    // 携帯電話番号
    const MOBILE_PHONE_NUMBER_IS_EMPTY = "携帯電話番号は必須です";
    const MOBILE_PHONE_NUMBER_NOT_DIGITS = "携帯電話番号は数値で入力してください";
    const MOBILE_PHONE_NUMBER_LENGTH = "携帯電話番号は11文字で入力してください";
    
    // 郵便番号
    const POST_CODE_IS_EMPTY = "郵便番号は必須です";
    const POST_CODE_NOT_DIGITS = "郵便番号は数値で入力してください";
    const POST_CODE_LENGTH = "郵便番号は7文字で入力してください";

    // 都道府県
    const PREFECTURE_IS_EMPTY = "都道府県は必須です";
    const PREFECTURE_INVAL_DATA = "都道府県に不正な値が設定されています";
    
    // 市区町村
    const ADDRESS_CITY_IS_EMPTY = "市区町村は必須です";
    const ADDRESS_CITY_LENGTH = "市区町村は40文字以内で入力してください";
    
    // 住所その他
    const ADDRESS_CITY_OTHER = "その他は40文字以内で入力してください";
    
    // 所属部署
    const SECTION_IS_EMPTY = "所属部署は必須です";
    const SECTION_INVAL_DATA = "所属部署に不正な値が設定されています";
    
    // バリデータ関連
    const INVALID_STRING_KATAKANA_ZENKAKU = "全角カタカナで入力してください";
    const INVALID_STRING_KATAKANA_HANKAKU = "半角カタカナで入力してください";
}
