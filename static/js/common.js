/**
 * 异步加载图片
 * $imgContainer 需要具有 imgsrc,imgstyle 2个属性
 */
function loadImg($imgContainer){
    var imgUrl = $imgContainer.attr('imgsrc'),
        imgStyle = {'style':$imgContainer.attr('imgstyle')};
    $imgContainer.get(0).innerHTML = ReferrerKiller.imageHtml(imgUrl,imgStyle);
}