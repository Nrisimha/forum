<?php
namespace Shared;

class ViewBuilder{
    public static function pagination($onPage,$totalPage,$link){
        $totalPage = ceil($totalPage);
        $result = '';
        if($onPage > 1 ){
            $pageLink = str_replace('%PAGE%',1,$link);
            $result .="<li><a href='$pageLink'><span>«</span></a></li>";
        }
        
        for ($i=-5; $i < 7; $i++) {
            $x = $onPage + $i;
            if($x > 0 && $x <= $totalPage){
                $pageLink = str_replace('%PAGE%',$x,$link);
                if($x == $onPage){
                    $result .= "<li class='active'><a href='$pageLink'>$x</a></li>";
                }else{
                    $result .= "<li><a href='$pageLink'>$x</a></li>";
                }
            }
        }
        
        if($onPage < $totalPage ){
            $pageLink = str_replace('%PAGE%',$totalPage,$link);
            $result .= "<li><a href='$pageLink'><span>»</span></a></li>";
        }
        
        return $result;
    }
    public static function paginationSubmit($onPage,$totalPage){
        $totalPage = ceil($totalPage);
        $result = '';
        if($onPage > 1 ){
            $result .="<button class='btn btn-default' name='page' type='submit' value='1'><span>«</span></button>";
        }
        
        for ($i=-5; $i < 7; $i++) {
            $x = $onPage + $i;
            if($x > 0 && $x <= $totalPage){
                if($x == $onPage){
                    $result .= "<button class='btn btn-primary' name='page' type='submit' value='$x'>$x</button>";
                }else{
                    $result .= "<button class='btn btn-default' name='page' type='submit' value='$x'>$x</button>";
                }
            }
        }
        
        if($onPage < $totalPage ){
            $result .= "<button class='btn btn-default' name='page' type='submit' value='$totalPage'><span>»</span></button>";
        }
        
        return $result;
    } 
}