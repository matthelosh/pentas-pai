import{o as l,c as m,b as e,a as s,u as t,w as d,e as n,V as a,W as c}from"./app-6686f679.js";import{B as h,S as u,k as _}from"./mdi-d71a3133.js";const f={class:"relative min-h-screen bg-white bg-opacity-5"},g={class:"p-3 fixed md:sticky md:top-0 shadow w-full bg-white md:flex md:items-center md:justify-between rounded-b-lg z-10 md:rounded"},p={class:"logo flex items-center justify-between md:justify-start md:items-end md:w-72"},v=e("img",{src:"img/kkg.png",alt:"Logo",class:"h-9 inline"},null,-1),x=e("span",{class:"text-lg hidden md:inline"},"Pentas PAIS",-1),y={class:"nav-items flex items-center justify-end gap-2"},b={id:"nav-list",class:"hidden md:flex md:justify-end absolute top-14 md:top-0 md:relative bg-white w-full left-0 rounded-b-lg duration-500 z-20 shadow-lg md:shadow-none"},w={class:"max-0 my-0 md:mx-1 md:my-0 hover:bg-green-400 hover:rounded duration-300"},k=e("li",{class:"max-0 my-0 md:mx-1 md:my-0 hover:bg-green-400 hover:rounded duration-300"},[e("a",{href:"#",class:"p-2 hover:text-white duration-300 block"},"Tentang")],-1),B={class:"max-0 my-0 md:mx-1 md:my-0 hover:bg-green-400 hover:rounded duration-300"},L={class:"max-0 my-0 md:mx-1 md:my-0 hover:bg-green-400 hover:rounded duration-300"},j={class:"relative top-16 py-2 md:top-20 px-3 md:py-1 md:px-0"},I={__name:"Front",setup(S){const i=o=>{document.querySelector("ul#nav-list").classList.toggle("hidden")};return(o,r)=>(l(),m("div",f,[e("nav",g,[e("div",p,[v,x,s(t(h),{class:"h-5 md:hidden",onClick:i})]),e("div",y,[e("ul",b,[e("li",w,[s(t(a),{href:"/",class:"p-2 hover:text-white duration-300 block"},{default:d(()=>[n("Beranda")]),_:1})]),k,e("li",B,[s(t(a),{href:o.route("peserta"),class:"p-2 hover:text-white duration-300 block"},{default:d(()=>[n("Data Peserta")]),_:1},8,["href"])]),e("li",L,[s(t(a),{href:o.route("daftar"),class:"p-2 hover:text-white duration-300 block"},{default:d(()=>[n("Registrasi")]),_:1},8,["href"])])]),s(t(a),{href:o.route("dashboard")},{default:d(()=>[s(t(u),{type:"mdi",path:t(_),class:"text-sky-600"},null,8,["path"])]),_:1},8,["href"])])]),e("main",j,[c(o.$slots,"default")])]))}};export{I as _};
