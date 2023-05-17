import{K as _,n as x,o as y,c as k,b as t,t as C,u as a,a as s,w as l,E as o,e as r,V as n,d as S,W as M,j as L}from"./app-6686f679.js";import{g as p,h as A,S as B,B as D}from"./mdi-d71a3133.js";const q={class:"h-min-full h-screen relative grid grid-cols-12 gap-3"},I={id:"sidebar",class:"sidebar h-[100vh] md:h-[95vh] overflow-y-auto w-2/4 z-20 md:w-2/12 bg-teal-400 md:rounded-xl fixed top-0 md:top-3 md:fixed md:block md:col-span-2 -translate-x-[100%] md:-translate-x-0 transition-all duration-300 shadow-lg md:shadow-lg overflow-x-hidden print:hidden"},j=t("div",{class:"w-full p-3 flex md:hidden items-center bg-teal-100 top-0"},"Pentas PAIS",-1),E={class:"w-full mt-3 md:mt-0 bg-gray-100 py-5"},N=t("img",{src:"/img/peserta.png",alt:"Avatar",class:"rounded-full bg-white w-[100px] mx-auto shadow"},null,-1),P={class:"text-center text-teal-800"},V={class:"mt-2"},z=["onClick"],T=t("li",null,[t("a",{href:"#",class:"block hover:bg-white md:hover:bg-opacity-70 px-8 py-2"},"C")],-1),K={class:"absolute bottom-0 w-full"},R={class:"main-wrap col-span-12 md:col-span-10 md:px-3 print:col-span-12"},U={class:"bg-white p-3 md:rounded-xl shadow z-20 top-0 right-0 left-0 flex justify-between items-center print:hidden md:translate-x-[263px]"},W={class:"md:mt-3 px-3 md:px-0 print:p-0 print:m-0 md:rounded-br-lg md:translate-x-[263px] print:translate-x-[0] bg-gray-100 print:col-span-12"},H={__name:"Dash",setup($){const g=_(),b=()=>{document.querySelector("#sidebar").classList.toggle("-translate-x-[100%]")},d=e=>{let i=e.target,u=i.querySelector(".ikon");i.classList.contains("active")||u.classList.remove("hidden")},c=e=>{let i=e.target,u=i.querySelector(".ikon");i.classList.contains("active")||u.classList.add("hidden")},v=()=>{L.post("/logout").then(e=>{window.location.href=route("login")})},f=e=>{document.querySelector("#sidebar").getBoundingClientRect()},w=e=>{e.target.closest("li").querySelector("ul").classList.toggle("hidden")},m=e=>route().current()==e,h=e=>!!e.includes(route().current());return x(()=>{window.addEventListener("scroll",f)}),(e,i)=>(y(),k("div",q,[t("div",I,[j,t("div",E,[N,t("h3",P,"@"+C(a(g).props.auth.user.name),1)]),t("ul",V,[t("li",null,[s(a(n),{href:e.route("dashboard"),class:o(["flex items-center py-2 px-3 md:hover:bg-opacity-70 md:hover:bg-white md:hover:shadow md:hover:pl-5 transition-all duration-500",e.route().current()=="dashboard"?"active":""]),onMouseover:d,onMouseleave:c},{default:l(()=>[s(a(p),{class:o(["ikon h-5 transition-all duration-500",e.route().current()=="dashboard"?"":"hidden"])},null,8,["class"]),r(" Dashboard ")]),_:1},8,["href","class"])]),t("li",null,[t("a",{href:"#",class:o(["parent flex items-center py-2 px-3 md:hover:bg-opacity-70 md:hover:bg-white md:hover:shadow md:hover:pl-5 transition-all duration-500",h(["dashboard.peserta","dashboard.panitia"])?"active":""]),onMouseover:d,onMouseleave:c,onClick:S(w,["prevent"])},[s(a(p),{class:o(["ikon h-5 transition-all duration-500",h(["dashboard.peserta","dashboard.panitia"])?"":"hidden"])},null,8,["class"]),r(" Utama ")],42,z),t("ul",{class:o(["child-menu duration-500 transition-all ease-in-out bg-white bg-opacity-25",h(["dashboard.peserta","dashboard.panitia"])?"":"hidden"])},[t("li",null,[s(a(n),{href:e.route("dashboard.peserta"),class:o(["block hover:bg-white md:hover:bg-opacity-70 px-8 py-2",m("dashboard.peserta")?"bg-white bg-opacity-70":""])},{default:l(()=>[r("Data Peserta")]),_:1},8,["href","class"])]),t("li",null,[s(a(n),{href:e.route("dashboard.panitia"),class:o(["block hover:bg-white md:hover:bg-opacity-70 px-8 py-2",m("dashboard.panitia")?"bg-white bg-opacity-70":""])},{default:l(()=>[r("Data Panitia")]),_:1},8,["href","class"])]),T],2)]),t("li",null,[s(a(n),{href:e.route("administrasi"),class:o(["flex items-center py-2 px-3 md:hover:bg-opacity-70 md:hover:bg-white md:hover:shadow md:hover:pl-5 transition-all duration-500 active:bg-white",e.route().current()=="administrasi"?"active":""]),onMouseover:d,onMouseleave:c},{default:l(()=>[s(a(p),{class:o(["ikon h-5 transition-all duration-500",e.route().current()=="administrasi"?"":"hidden"])},null,8,["class"]),r(" Administrasi ")]),_:1},8,["href","class"])])]),t("ul",K,[t("li",{class:"flex cursor-pointer p-3 bg-red-100 w-full justify-end gap-1 hover:bg-red-400 hover:text-white transition-all hover:transition-all hover:justify-end duration-200 ease-in-out",onClick:v},[s(a(B),{type:"mdi",path:a(A)},null,8,["path"]),r(" Keluar ")])])]),t("div",R,[t("nav",U,[r(" Navbar "),s(a(D),{class:"h-6 cursor-pointer md:hidden",onClick:b})]),t("main",W,[M(e.$slots,"default")])])]))}};export{H as _};