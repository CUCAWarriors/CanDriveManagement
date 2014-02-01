<?php 

error_reporting( 0 );




//PAGE NUMBER, RESULTS PER PAGE, AND OFFSET OF THE SEARCH RESULTS
if($_GET["page"]){
    $pagenum = $_GET["page"];
} else {
    $pagenum = 1;
}

$rowsperpage = 3;
$offset = ($pagenum - 1) * $rowsperpage;

//SEPARATES THE ENTIRE SEARCH TERM INTO KEYWORDS
$t = trim(eregi_replace(" +", " ", $_GET["q"]));
$x = explode(" ", $t);

foreach($x as $z)
{
    $w++;
    if($w==1)
    {
    $u .= "title LIKE '%$z%'";
    }
    else
    {
    $u .= "OR title LIKE '%$z%'";
    }
}

$q = $db->query("SELECT * FROM $table WHERE $u ORDER BY id DESC LIMIT $offset, $rowsperpage");
$page_nums = $db->num_rows($q); //NUMBER OF RESULTS FOR THE PAGE

//QUERY FOR ALL RESULTS OF THE SEARCH
$total_q = $db->query("SELECT * FROM $table WHERE $u");
$total_nums = $db->num_rows($total_q); //TOTAL NUMBER OF RESULTS
$total_pages = ceil($total_nums/$rowsperpage); //NUMBER OF PAGES

//IF THERE ARE RESULTS
if($total_nums)
{
        if($pagenum<1||$pagenum>$total_pages)
    {
        header("Location: results.php?q=$t");
    }
    
        while($r=mysql_fetch_array($q))
    {
        $title = $r["title"];
        $profile = $r["profile"];
        
        echo '<div class="result"><div>'.$title.'<div/></div>';
    }
    
    echo '<br>';
    $range = 2;    if($pagenum>1)
    {
        $page = $pagenum - 1;
        $first = '<a class="page" id="1">First</a> ';
        $prev = '<a class="page" id="'.$page.'"><img src="http://cdn4.iconfinder.com/data/icons/markerstyle_icons/PNG/64px/previous.png" height="20" width="20"></a> ';
    }
    
    //IF NOT ON THE LAST PAGE OF RESULTS
    if($pagenum<$total_pages)
    {
        $page = $pagenum + 1;
        $next = '<a class="page" id="'.$page.'"><img src="http://cdn4.iconfinder.com/data/icons/markerstyle_icons/PNG/64px/next.png" height="20" width="20"></a> ';
        $last = '<a class="page" id="'.$total_pages.'">Last</a> ';
    }
    
    for($page=($pagenum-$range); $page<=($pagenum+$range); $page++)
    {
        
        if($page>=1&&$page<=$total_pages)
        {
            if($total_pages>1)
            {
                if($page==$pagenum)
                {
                    $nav .= '<span class="pagenum">'.$page.'</span> ';
                }
                else
                {
                    $nav .= '<a class="page" id="'.$page.'">'.$page.'</a> ';
                }
            }
        }
    }
    
        echo $first . $prev . $nav . $next. $last;
}
else
{
echo ' No Documents for <b>"'.$t.'"</b>';
}

?>