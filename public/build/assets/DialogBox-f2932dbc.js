import{r as s,o as p,c as x,b as e,a as m,u as g,t as b,d as h,i as y}from"./app-01791401.js";import{Q as k}from"./mdi-c4c90586.js";import"./_plugin-vue_export-helper-c27b6911.js";const _={class:"dialog min-w-[400px] min-h-[250px] rounded-xl shadow bg-white flex items-center justify-center"},w={class:"w-full px-4"},B={class:"text-xl text-gray-800 mb-4 text-center"},D={__name:"DialogBox",setup(C,{expose:c}){const t=s(!1);s([]);const l=s(""),a=s(null),i=s(null),u=async(n,o)=>(t.value=!0,l.value=n,new Promise((r,v)=>{a.value=r,i.value=v})),d=()=>{t.value=!1,a.value(!0)},f=()=>{t.value=!1,a.value(!1)};return c({open:u}),(n,o)=>t.value?(p(),x("div",{key:0,class:"overlay fixed top-0 right-0 bottom-0 left-0 z-50 bg-black bg-opacity-50 flex items-center justify-center",onClick:o[0]||(o[0]=h(r=>t.value=!1,["self"]))},[e("div",_,[e("div",w,[m(g(k),{class:"text-red-400 h-32 animate-bounce mx-auto"}),e("h1",B,b(l.value),1),e("div",{class:"flex justify-around gap-2 w-full"},[e("button",{onClick:f,class:"px-3 py-2 rounded hover:bg-red-600 active:bg-orange-400 bg-red-400 text-white"},"Batal"),e("button",{onClick:d,class:"px-3 py-2 rounded hover:bg-sky-600 active:bg-orange-400 bg-sky-400 text-white"},"Yakin")])])])])):y("",!0)}};export{D as default};