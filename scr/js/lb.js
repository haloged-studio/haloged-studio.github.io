var time=2000;
    let content = document.querySelector('.banner-imgBox2');
    let switchBtn = document.querySelector('.banner-imgBox-div');
    switchBtn.children[0].classList.add('on2');
    let index=0;
    let x=0;
    function marginLeft(right) {
        if(right){
            switchBtn.children[index].classList.remove('on2');
            if(index==switchBtn.children.length-1){
                index=0;
                content.innerHTML+=content.innerHTML;
                x++;
            }else {
                index++;
                x++;
            }
            switchBtn.children[index].classList.add('on2');
            content.style.marginLeft=x*-1530+"px"
        }else{
            switchBtn.children[index].classList.remove('on2');
            if(index==0){
                index=switchBtn.children.length-1;
                if(x==0){
                    x=0
                }else{
                    x--;
                }
            }else {
                index--;
                x--;
            }
            switchBtn.children[index].classList.add('on2');
            content.style.marginLeft=x*-1530+"px"
        }

    }


    var interval = setInterval(() => {
        marginLeft(true)
    }, time);


    let container = document.querySelector('.banner-imgBox');
    // 鼠标经过时清除定时器
    container.onmouseover = function () {
        clearInterval(interval);
    }
    // 鼠标移开时设置定时器
    container.onmouseout = function () {
        // 先清除定时器
        clearInterval(interval);
        // 往右滑动并开启定时器
        // marginLeft(true)
        interval = setInterval(() => {
            marginLeft(true)
        }, time);
    }