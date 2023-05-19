import{K as L,p,r as h,c as s,a as o,u as a,w as B,F as _,o as l,Z as C,b as e,l as y,_ as f,t as i,y as D,j as w,O as E}from"./app-01791401.js";import{_ as O}from"./Dash-4feebf60.js";import{C as P}from"./mdi-c4c90586.js";import"./_plugin-vue_export-helper-c27b6911.js";const A={class:"w-full bg-white"},T=e("div",{class:"toolbar bg-gray-100 h-12 flex items-center justify-between p-3 sticky top-0 print:hidden"},[e("span",null,"Data Lomba"),e("div",{class:"toolbar-items flex items-center"})],-1),V={class:"content"},$={class:"table w-full border border-collapse"},I=e("caption",{class:"text-center text-xl font-bold my-2"},"Data Lomba",-1),N=e("thead",null,[e("tr",{class:"bg-gray-200"},[e("th",{class:"py-2 px-3 border-b border-e border-gray-400"},"No"),e("th",{class:"py-2 px-3 border-b border-e border-gray-400"},"Label"),e("th",{class:"py-2 px-3 border-b border-e border-gray-400"},"Tahun"),e("th",{class:"py-2 px-3 border-b border-e border-gray-400"},"Lokasi"),e("th",{class:"py-2 px-3 border-b border-gray-400 print:hidden"},"Opsi")])],-1),j={class:"border-e border-gray-400 text-center"},F={class:"border-e border-gray-400 px-3"},R={class:"border-e border-gray-400 text-center"},S={class:"border-e border-gray-400 px-3"},z={name:"lokasi_id"},K=e("option",{value:"0"},"Pilih Lokasi",-1),Z=["value","selected"],q={class:"border-e border-gray-400 text-center"},U={__name:"Lomba",setup(G){const g=L(),x=p(()=>f(()=>import("./AlertBox-2fdc7126.js"),["assets/AlertBox-2fdc7126.js","assets/app-01791401.js","assets/app-8586ea4a.css","assets/mdi-c4c90586.js","assets/_plugin-vue_export-helper-c27b6911.js","assets/mdi-3ea76a33.css"])),n=h(null),m=p(()=>f(()=>import("./DialogBox-f2932dbc.js"),["assets/DialogBox-f2932dbc.js","assets/app-01791401.js","assets/app-8586ea4a.css","assets/mdi-c4c90586.js","assets/_plugin-vue_export-helper-c27b6911.js","assets/mdi-3ea76a33.css"])),b=h(null),k=async t=>{if(t.status=="1")return n.value.open("Error","Lomba "+t.label+" sudah aktif."),!1;if(await b.value.open("Aktifkan Lomba "+t.label+"?")){if(!t.sekolah_id)return n.value.open("Error","Tentukan Lokasi Perlombaan Dulu"),!1;w.put(route("lomba.activate",{id:t.id})).then(c=>{E.reload({only:["lombas"]}),n("Ok",`${t.label} diaktifkan.`)}).catch(c=>console.log(c))}};return(t,c)=>(l(),s(_,null,[o(a(C),{title:"Data Perlombaan"}),o(a(m),{ref_key:"dialogBox",ref:b},null,512),o(a(x),{ref_key:"alertBox",ref:n},null,512),o(O,null,{default:B(()=>[e("div",A,[T,e("div",V,[e("table",$,[I,N,e("tbody",null,[(l(!0),s(_,null,y(a(g).props.lombas,(r,u)=>(l(),s("tr",{class:"odd:bg-gray-100",key:u},[e("td",j,i(u+1),1),e("td",F,i(r.label),1),e("td",R,i(r.tahun),1),e("td",S,[e("select",z,[K,(l(!0),s(_,null,y(t.$page.props.sekolahs,(d,v)=>(l(),s("option",{key:v,value:d.npsn,selected:d.npsn==r.lokasi_id},i(d.nama),9,Z))),128))])]),e("td",q,[e("button",null,[o(a(P),{class:D(["h-8",r.status=="1"?"text-lime-400":"text-gray-200"]),onClick:d=>k(r)},null,8,["class","onClick"])])])]))),128))])])])])]),_:1})],64))}};export{U as default};