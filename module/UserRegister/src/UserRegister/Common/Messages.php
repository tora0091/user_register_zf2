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

    // 名前（名）
    const LAST_NAME_IS_EMPTY = "名前（名）は必須です";
    
    // 名前（セイ）
    const FAMILY_NAME_KANA_IS_EMPTY = "名前（セイ）は必須です";

    // 名前（メイ）
    const LAST_NAME_KANA_IS_EMPTY = "名前（メイ）は必須です";
    
    // 都道府県
    const PREFECTURE_IS_EMPTY = "都道府県は必須です";
    const PREFECTURE_INVAL_DATA = "都道府県に不正な値が設定されています";
}
