$(function(){
$("#q").keyup(function(){
var q = $(this).val();

$.get("/scripts/search.php?q="+q, function(data){
if(q){
$(".results").html(data);
} else {
$(".results").html("");
}
});
});
$(".page").live("click", function(){
var q = $("#q").val();
var page = $(this).attr("id");

$(".results").load("search.php?q="+q+"&page="+page);
});
});
