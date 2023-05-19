import{r as d,c as v,a as r,u as a,w as g,F as x,o as c,Z as w,b as e,d as y,e as f,f as h,v as b,g as k,h as u,i as m,j as U}from"./app-01791401.js";import{_ as B}from"./Front-da5faa60.js";import{L as C,U as L,E as V,a as j,A as E}from"./mdi-c4c90586.js";import I from"./AlertBox-2fdc7126.js";import"./_plugin-vue_export-helper-c27b6911.js";const N={class:"container md:flex md:items-center md:h-[580px]"},P={class:"container bg-white w-full rounded shadow-lg columns-1 md:columns-2 gap-4 md:w-9/12 mx-auto"},S=e("div",{class:"w-full h-96 flex items-center justify-center bg-teal-700"},[e("div",null,[e("img",{src:"img/peserta.png",alt:"Avatar",class:"mx-auto rounded-full aspect-square shadow-md border p-1 bg-gray-200",width:"100"}),e("h3",{class:"text-center text-white"},"Selamat Datang!")])],-1),$={class:"w-full h-96 flex items-center justify-center"},A=["onSubmit"],D={class:"mb-5"},M={class:"text-2xl flex items-center"},F=e("label",{for:"name"},"Username",-1),T={class:"flex relative items-center"},q=["disabled"],Z={class:"my-3"},z=e("label",{for:"password"},"Password",-1),G={class:"relative flex items-center"},H=["type","disabled"],J={class:"flex justify-center"},K=["disabled"],ee={__name:"Login",setup(O){const l=d(!1),t=d(!1),p=d(null),o=d({}),_=async()=>{t.value=!0,await U.post("/login",o.value).then(i=>{window.location.href="/panitia"}).catch(i=>{let s=i.response.status==422?"Username atau password tidak tepat":i.response.data.message;p.value.open("Error",s),t.value=!1})};return(i,s)=>(c(),v(x,null,[r(I,{ref_key:"alertBox",ref:p},null,512),r(a(w),{title:"Login"}),r(B,{class:"h-screen"},{default:g(()=>[e("div",N,[e("div",P,[S,e("div",$,[e("form",{ref:"form-login",onSubmit:y(_,["prevent"]),class:"w-full px-10"},[e("div",D,[e("h3",M,[r(a(C),{class:"h-6 mb-1"}),f(" Login ")])]),e("div",null,[F,e("div",T,[h(e("input",{type:"text",name:"name",id:"name",placeholder:"Username",class:"w-full placeholder:text-gray-600 rounded-lg focus:outline-teal-800","onUpdate:modelValue":s[0]||(s[0]=n=>o.value.name=n),disabled:t.value},null,8,q),[[b,o.value.name]]),r(a(L),{class:"absolute text-gray-600 h-6 right-0 mr-3"})])]),e("div",Z,[z,e("div",G,[h(e("input",{name:"password",id:"password",placeholder:"Password",type:l.value?"text":"password",class:"w-full placeholder:text-gray-600 rounded-lg focus:outline-teal-800","onUpdate:modelValue":s[1]||(s[1]=n=>o.value.password=n),disabled:t.value},null,8,H),[[k,o.value.password]]),l.value?m("",!0):(c(),u(a(V),{key:0,class:"text-gray-600 absolute h-6 right-0 duration-100 mr-3 cursor-pointer",onClick:s[2]||(s[2]=n=>l.value=!0)})),l.value?(c(),u(a(j),{key:1,class:"text-gray-600 absolute h-6 right-0 mr-3 duration-100 cursor-pointer",onClick:s[3]||(s[3]=n=>l.value=!1)})):m("",!0)])]),e("div",J,[e("button",{type:"submit",class:"bg-sky-600 text-white py-2 px-3 rounded-lg mx-auto w-full flex items-center justify-center disabled:bg-sky-200 disabled:text-gray-400",disabled:t.value},[t.value?(c(),u(a(E),{key:0,class:"animate-spin w-6"})):m("",!0),f(" Login ")],8,K)])],40,A)])])])]),_:1})],64))}};export{ee as default};
