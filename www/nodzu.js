// -------------Kompresja ---------------
function kompresja() {
  var tekst = document.getElementById("kompresja").value;
  var pokompresji = "";
  var probability = document.getElementById("myRange").value;
  var splitted = tekst.split(" ");
  for (var i = 0; i < splitted.length; i++) {
    if (probability / 100 < Math.random()) {
      pokompresji = pokompresji + splitted[i] + " ";
    }
  }
  document.getElementById("kompresja").value = pokompresji;

}
function clone(src, deep) {

    var toString = Object.prototype.toString;
    if (!src && typeof src != "object") {
        // Any non-object (Boolean, String, Number), null, undefined, NaN
        return src;
    }

    // Honor native/custom clone methods
    if (src.clone && toString.call(src.clone) == "[object Function]") {
        return src.clone(deep);
    }

    // DOM elements
    if (src.nodeType && toString.call(src.cloneNode) == "[object Function]") {
        return src.cloneNode(deep);
    }

    // Date
    if (toString.call(src) == "[object Date]") {
        return new Date(src.getTime());
    }

    // RegExp
    if (toString.call(src) == "[object RegExp]") {
        return new RegExp(src);
    }

    // Function
    if (toString.call(src) == "[object Function]") {

        //Wrap in another method to make sure == is not true;
        //Note: Huge performance issue due to closures, comment this :)
        return (function(){
            src.apply(this, arguments);
        });
    }

    var ret, index;
    //Array
    if (toString.call(src) == "[object Array]") {
        //[].slice(0) would soft clone
        ret = src.slice();
        if (deep) {
            index = ret.length;
            while (index--) {
                ret[index] = clone(ret[index], true);
            }
        }
    }
    //Object
    else {
        ret = src.constructor ? new src.constructor() : {};
        for (var prop in src) {
            ret[prop] = deep
                ? clone(src[prop], true)
                : src[prop];
        }
    }
    return ret;
};

// -------------Nodzu/Playlisty---------------
var ile = 0;
function nowyElement() {
  if(ile>40)
  {
    document.getElementById("war").innerHTML = "Max. 40 utworów!";
  }else{
  ile++;

  var x = document.createElement("li");
  x.append(clone(chacha,chacha));
  document.getElementById("lista").appendChild(x);
}}
function zapisz()
{
  var z = document.getElementsByName("selekt");

  var result="";
  if(document.getElementById("nazwap").value=="")
  {
    document.getElementById("war").innerHTML = "Podaj nazwę playlisty!";
  }else if(z.length==0)
  {
    document.getElementById("war").innerHTML = "Playlista jest pusta!";
  }
  else if(z.length>40)
  {
    document.getElementById("war").innerHTML = "Nie kombinuj dziubeczku!";
  }else{
  for (var i = 0; i < z.length; i++) {
    result = result + z[i].value + ",";
  }
  document.getElementById("plejlista").value = result;
document.getElementById("potwierdzenie").submit();
}
}
var a;
function stop()
{
  for (var i = 0; i < nodzu.length; i++) {
    nodzu[i].load();
    nodzu[i].pause();
    a=0;
  }
}
function sleep(ms) { return new Promise(resolve => setTimeout(resolve, ms)); }
async function playplaylist(co)
{
a=1;
var ss = co.split(",");
  console.log(ss.length);
  for (var i = 0; i < ss.length- 1; i++) {

    if(a){
    nodzu[ss[i]].play();

    await sleep(nodzu[ss[i]].duration*1000);}
  }

}
async function playrandom(co)
{
      a=1;
while(a){

    var ss = co.split(",");
    var nr=Math.random()*(ss.length-1)*5;
    nr = Math.floor(nr);
    nr = nr % (ss.length-1);
    if(a){
      console.log(nr);
    nodzu[ss[nr]].play();
    await sleep(nodzu[ss[nr]].duration*1000);
}
}
}
