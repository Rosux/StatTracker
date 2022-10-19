// ================================GENERAL FUNCTIONS================================ //
// dont need jquery anymore
Element.prototype.hide=function(){
    this.style.display = "none";
}
Element.prototype.show=function(){
    this.style.removeProperty('display');
}
Object.prototype.hide=function(){
    this.forEach(e=>{e.style.display = "none";});
}
Object.prototype.show=function(){
    this.forEach(e=>{e.style.removeProperty('display')});
}
String.prototype.toBool=function(){
    return/^true$/i.test(this);
};
// ================================COOKIES================================ //
// set a cookie with params
function setCookie(name, val, time) {
    var date = new Date();
    if(time){date.setDate(date.getDate() + time);}else{date.setDate(date.getDate() + 5);}
    document.cookie = name + "=" + encodeURIComponent(val) + ';expires=' + date + ',sameSite: "strict"; secure;';
}
// gets cookie value from cookiename
function getCookie(name) {
    const value = `; ${document.cookie}`;
    const parts = value.split(`; ${name}=`);
    if (parts.length === 2) return parts.pop().split(';').shift();
}
///////////////////////////////////////////////////////////////////
///// DARK MODE MINIEFIED (https://github.com/Rosux/DarkMode) /////
///////////////////////////////////////////////////////////////////
class Darkmode{constructor(e,t,o=!0){this.darkModeTheme=e,this.lightModeTheme=t,this.getCookie("Rosux-Darkmode")?this.dark=this.getCookie("Rosux-Darkmode").toBool():(o?this.dark=!0:this.dark=!1,this.updateCookie()),this.updateDocument(),this.addButtonListeners()}switch(){this.dark=!this.dark,this.updateCookie(),this.updateDocument()}on(){this.dark=!0,this.updateCookie(),this.updateDocument()}off(){this.dark=!1,this.updateCookie(),this.updateDocument()}updateCookie(){this.getCookie("Rosux-Darkmode")||this.setCookie("Rosux-Darkmode",this.dark,30),this.setCookie("Rosux-Darkmode",this.dark,30)}getMode(){return this.dark}async addButtonListeners(){if("complete"===document.readyState||"interactive"===document.readyState){let e=document.querySelectorAll("*[darkmode-selector]");t(e)}else window.addEventListener("DOMContentLoaded",()=>{let e=document.querySelectorAll("*[darkmode-selector]");t(e)});function t(e){for(let t=0;t<e.length;t++)e[t].addEventListener("change",o=>{"1"==o.target.getAttribute("darkmode-selector")?o.target.checked?darkmode.off():darkmode.on():"2"==e[t].getAttribute("darkmode-selector")&&(o.target.checked?darkmode.on():darkmode.off())})}}updateDocument(){"complete"===document.readyState||"interactive"===document.readyState?(this.dark?document.body.style.cssText=this.darkModeTheme:document.body.style.cssText=this.lightModeTheme,this.updateButtons()):window.addEventListener("DOMContentLoaded",()=>{this.dark?document.body.style.cssText=this.darkModeTheme:document.body.style.cssText=this.lightModeTheme,this.updateButtons()})}async updateButtons(){let e=this.dark,t=document.querySelectorAll("*[darkmode-selector]");for(let o=0;o<t.length;o++)e?"1"==t[o].getAttribute("darkmode-selector")||"s"==t[o].getAttribute("darkmode-selector")?t[o].checked=!1:"2"==t[o].getAttribute("darkmode-selector")&&(t[o].checked=!0):"1"==t[o].getAttribute("darkmode-selector")||"s"==t[o].getAttribute("darkmode-selector")?t[o].checked=!0:"2"==t[o].getAttribute("darkmode-selector")&&(t[o].checked=!1)}setCookie(e,t,o=30){var s=new Date;s.setDate(s.getDate()+o),document.cookie=e+"="+encodeURIComponent(t)+";expires="+s+',sameSite: "strict"; secure;'}getCookie(e){let t=`; ${document.cookie}`,o=t.split(`; ${e}=`);if(2===o.length)return o.pop().split(";").shift()}}
// ===========================Setting Up Darkmode=========================== //
let darkModeTheme = "--background-ashpalt-texture: url('../images/asfalt-light.png');--header-color:hsl(0,0%,20%);--text-color:#d3d3d3;--background-color:hsl(0,0%,9%);--accent-color-1:#202020;--accent-color-2:#303030;";
let lightModeTheme = "--background-ashpalt-texture: url('../images/asfalt-dark.png');--header-color:hsl(0,0%,80%);--text-color:hsl(0,0%,17%);--background-color:hsl(0,0%,91%);--accent-color-1:hsl(0,0%,87%);--accent-color-2:hsl(0,0%,81%);";
let darkmode = new Darkmode(darkModeTheme, lightModeTheme, true);