import{K as x,r as p,G as g,c as o,a as f,u,w as y,F as i,o as r,Z as C,b as e,f as k,v as L,l as b,e as N,t as l,E as j}from"./app-6686f679.js";import{_ as $}from"./Front-8c89b8b2.js";import{c as D}from"./chunk-7461cf73.js";import"./mdi-d71a3133.js";import"./_plugin-vue_export-helper-c27b6911.js";import"./isArrayLike-4aa94e85.js";import"./isSymbol-80af4f08.js";const P={class:"w-full bg-white"},V={class:"toolbar w-full h-12 bg-gray-50 rounded shadow flex items-center px-3 justify-between"},B=e("h1",null,"Data Peserta",-1),S={class:"toolbar-items flex items-center gap-2"},E={class:"content w-full bg-white p-3 mt-2 overflow-x-hidden"},F={class:"table-responsive w-full overflow-x-scroll"},J={class:"table w-full border-collapse bg-white overflow-x-auto"},K=e("thead",null,[e("tr",null,[e("th",{class:"border text-center"},"No"),e("th",{class:"border text-center"},"NISN"),e("th",{class:"border text-center"},"Nama"),e("th",{class:"border text-center"},"JK"),e("th",{class:"border text-center"},"Sekolah"),e("th",{class:"border text-center"},"Lomba")])],-1),T={class:"border p-2"},z={class:"border p-2"},G={class:"border p-2"},H={class:"border p-2"},I={class:"border p-2"},M={class:"border p-2"},U={class:"bg-gray-200 flex items-center justify-between pl-3 flex-wrap w-full"},Z={class:"flex items-center h-full flex-wrap"},q=["onClick"],te={__name:"Peserta",setup(A){const m=x(),n=p(1),a=p(null),d=p(m.props.pesertas),_=g(()=>{d.value.length;let c=[];a.value==null?c=d.value:c=d.value.filter(t=>t.nama.toLowerCase().includes(a.value.toLowerCase())||t.sekolah.nama.toLowerCase().includes(a.value.toLowerCase())||t.nisn.toLowerCase().includes(a.value.toLowerCase()));let s=D(c,10);return{current:s[n.value-1],pageCount:s.length}});return(c,s)=>(r(),o(i,null,[f(u(C),{title:"Data Peserta"}),f($,null,{default:y(()=>[e("div",P,[e("div",V,[B,e("div",S,[k(e("input",{type:"text",placeholder:"Cari",class:"h-8 rounded","onUpdate:modelValue":s[0]||(s[0]=t=>a.value=t)},null,512),[[L,a.value]])])]),e("div",E,[e("div",F,[e("table",J,[K,e("tbody",null,[(r(!0),o(i,null,b(u(_).current,(t,h)=>(r(),o("tr",{class:"odd:bg-gray-50",key:h},[e("td",T,l(h+1),1),e("td",z,l(t.nisn),1),e("td",G,l(t.nama),1),e("td",H,l(t.jk),1),e("td",I,l(t.sekolah.nama),1),e("td",M,[e("ul",null,[(r(!0),o(i,null,b(t.bidangs,(v,w)=>(r(),o("li",{key:w},l(v.label),1))),128))])])]))),128))])])]),e("div",U,[N(" Jml Halaman: "+l(u(_).pageCount)+" ",1),e("div",Z,[e("button",{onClick:s[1]||(s[1]=t=>n.value-=1),class:"flex justify-center w-8 border border-gray-500"},"<"),(r(!0),o(i,null,b(u(_).pageCount,t=>(r(),o("button",{key:t,class:j(["flex justify-center w-8 border border-gray-500",t==n.value?"bg-sky-600 text-white":""]),onClick:h=>n.value=t},l(t),11,q))),128)),e("button",{onClick:s[2]||(s[2]=t=>n.value+=1),class:"flex justify-center w-8 border border-gray-500"},">")])])])])]),_:1})],64))}};export{te as default};
