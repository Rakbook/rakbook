function centerContent(){

    function setmargin(){
        var content = document.getElementsByClassName("content");
    
        var margin = Math.round((window.innerHeight - content[0].getBoundingClientRect().height)/3 + 64);
        content[0].setAttribute("style", "margin-top: " + margin + "px");
    }

    window.addEventListener('resize', setmargin);
    setmargin();
}
