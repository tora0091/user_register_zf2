<?php

namespace UserRegister\Service;

use UserRegister\Service\AbstractService;

class SearchService extends AbstractService
{
    public function search($data, $page = 1, $limit = 10)
    {
        return $this->getTable('UserTable')->search($data, $page, $limit);
    }
    
    public function pagenate($data, $page = 1, $limit = 10)
    {
        $row = $this->getTable('UserTable')->count($data);
        $count = intval($row['count']);
        
        $pagenate = [];
        $pagenate['isPrev'] = false;
        $pagenate['isNext'] = false;
        $pagenate['prevPage'] = 0;
        $pagenate['nextPage'] = 0;

        $current = intval($page);
        $all = ceil($count / $limit);

        if ($current < 1) {
            $current = 1;
        }
        if ($current > $all) {
            $current = $all;
        }
        // 現在のページおよび全ページ
        $pagenate['currentPage'] = $current;
        $pagenate['allPage'] = $all;

        // 前へリンク
        $prevPage = $current - 1;
        $isPrev = true;
        if ($prevPage < 1) {
            $prevPage = 1;
            $isPrev = false;
        }
        $pagenate['prevPage'] = $prevPage;
        $pagenate['isPrev'] = $isPrev;

        // 次へリンク
        $nextPage = $current + 1;
        $isNext = true;
        if ($nextPage > $all) {
            $nextPage = $all;
            $isNext = false;
        }
        $pagenate['nextPage'] = $nextPage;
        $pagenate['isNext'] = $isNext;

        return $pagenate;
    }
}