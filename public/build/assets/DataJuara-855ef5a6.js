import{r as c,n as T,o as i,c as p,b as e,d as B,e as u,f,k as V,F as C,l as A,t as o,v as S,h as P,u as d,i as J,j as w,E as O,K as M,a as m,Z as E,w as H,y as R,H as X,O as q}from"./app-01791401.js";import{A as K,c as z,S as F,X as G,P as Q,b as W}from"./mdi-c4c90586.js";import{P as Z}from"./PiagamJuara-870c0740.js";import{r as Y,u as $,w as ee,a as te}from"./xlsx-9d47e74b.js";import"./_plugin-vue_export-helper-c27b6911.js";import"./misc-66c4e50d.js";import"./vue-qrcode.esm-3546f055.js";const ae={class:"dialog bg-white md:w-4/12 rounded shadow-xl h-[400px] mt-24"},se={class:"dialog-content py-3 px-4"},oe=e("h1",null,"Formulir Juara",-1),re=["onSubmit"],le={for:"bidang_id",class:"flex items-center justify-between"},ne=e("option",{value:"0"},"Pilih Bidang Lomba",-1),ie=["value"],de={for:"peserta_id",class:"my-1 flex items-center justify-between"},ce={for:"peserta_id",class:"my-1 flex items-center justify-between"},pe={for:"bidang_id",class:"flex items-center justify-between"},ue=O('<option value="0">Peringkat</option><option value="1">1 (SATU)</option><option value="2">2 (DUA)</option><option value="3">3 (TIGA)</option><option value="4">HARAPAN 1</option><option value="5">HARAPAN 2</option>',6),be=[ue],ge={for:"bidang_id",class:"flex items-center justify-between"},he=["disabled"],ye={__name:"FormJuara",props:{juara:Object},setup(D){const x=D,a=c({bidang_id:"0",peringkat:"0"}),_=[{kode:"adz",label:"Adzan"},{kode:"pdc",label:"Pildacil"},{kode:"bjr",label:"Banjaro"},{kode:"lcc",label:"Cerdas Cermat"},{kode:"mtq",label:"MTQ"},{kode:"mhq",label:"MHQ"}],v=c([]),b=c(!1),k=async h=>{await w.post(route("dashboard.peserta.index")).then(n=>{let s=[];n.data.pesertas.forEach((g,I)=>{s.push({nisn:g.nisn,nama:g.nama})}),v.value=s})},j=async()=>{b.value=!0,await w.post(route("juara.store"),{data:JSON.stringify(a.value)}).then(h=>{b.value=!1})};return T(()=>{x.juara&&(a.value=x.juara)}),(h,n)=>(i(),p("div",{class:"fixed top-0 right-0 bottom-0 left-0 bg-gray-800 bg-opacity-60 flex justify-center",onClick:n[5]||(n[5]=B(s=>h.$emit("close"),["self"]))},[e("div",ae,[e("div",se,[oe,e("form",{onSubmit:B(j,["prevent"]),class:"form"},[e("label",le,[u(" Bidang lomba: "),f(e("select",{name:"bidang_id","onUpdate:modelValue":n[0]||(n[0]=s=>a.value.bidang_id=s),class:"py-1 pr-10 caret-slate-800 rounded focus:shadow-lime-400 my-2",onChange:k},[ne,(i(),p(C,null,A(_,(s,g)=>e("option",{key:g,value:s.kode},o(s.label),9,ie)),64))],544),[[V,a.value.bidang_id]])]),e("label",de,[u("No. Peserta: "),f(e("input",{type:"text",name:"peserta_id",placeholder:"No. Peserta/NISN ",class:"py-1 rounded focus:shadow my-2","onUpdate:modelValue":n[1]||(n[1]=s=>a.value.peserta_id=s)},null,512),[[S,a.value.peserta_id]])]),e("label",ce,[u("Nilai: "),f(e("input",{type:"number",name:"nilai",placeholder:"Nilai ",class:"py-1 rounded focus:shadow my-2","onUpdate:modelValue":n[2]||(n[2]=s=>a.value.nilai=s)},null,512),[[S,a.value.nilai]])]),e("label",pe,[u(" Peringkat: "),f(e("select",{name:"peringkat","onUpdate:modelValue":n[3]||(n[3]=s=>a.value.peringkat=s),class:"py-1 pr-10 caret-slate-800 rounded focus:shadow-lime-400 my-2"},be,512),[[V,a.value.peringkat]])]),e("label",ge,[u(" Keterangan: "),f(e("textarea",{name:"keterangan","onUpdate:modelValue":n[4]||(n[4]=s=>a.value.keterangan=s),class:"py-1 pr-10 caret-slate-800 rounded focus:shadow-lime-400 my-2"},null,512),[[S,a.value.keterangan]])]),e("button",{class:"bg-sky-400 text-white py-1 px-2 rounded mx-auto flex gap-2",type:"sumbit",disabled:b.value},[u(" Simpan "),b.value?(i(),P(d(K),{key:0,class:"h-8 animate-spin text-white"})):J("",!0)],8,he)],40,re)])])]))}},me={class:"w-full bg-white"},xe={class:"toolbar bg-white h-12 py-2 px-3 flex items-center justify-between shadow print:hidden sticky top-0"},_e={class:"toolbar-items flex items-center gap-1"},ve={class:"w-full p-6 print:p-0 min-h-[80vh]"},fe={class:"table border border-collapse w-full"},ke=e("thead",null,[e("tr",{class:"bg-sky-100"},[e("th",{class:"border border-gray-400 py-2 px-3"},"No"),e("th",{class:"border border-gray-400 py-2 px-3"},"NISN"),e("th",{class:"border border-gray-400 py-2 px-3"},"Nama"),e("th",{class:"border border-gray-400 py-2 px-3"},"JK"),e("th",{class:"border border-gray-400 py-2 px-3"},"Lomba"),e("th",{class:"border border-gray-400 py-2 px-3"},"Peringkat"),e("th",{class:"border border-gray-400 py-2 px-3"},"Nilai"),e("th",{class:"border border-gray-400 py-2 px-3"},"Lembaga"),e("th",{class:"border border-gray-400 py-2 px-3 print:hidden"},"Opsi")])],-1),we={class:"text-center py-1 px-2 border border-gray-400 bg-gray-200"},je={class:"text-center py-1 px-2 border border-gray-400"},Ne={class:"py-1 px-2 border border-gray-400"},Se={class:"text-center py-1 px-2 border border-gray-400"},$e={class:"text-center py-1 px-2 border border-gray-400"},Ce={class:"text-center py-1 px-2 border border-gray-400"},Ae={class:"text-center py-1 px-2 border border-gray-400"},Pe={class:"py-1 px-2 border border-gray-600"},Je={class:"text-center py-1 px-2 border border-gray-600 print:hidden"},De=["onClick"],Ie={key:2,class:"w-full border bg-gray-100"},Be={class:"toolbar bg-gray-100 h-12 w-full flex items-center justify-between p-3 sticky top-12 shadow-md"},Ve={class:"toolbar-items flex items-center gap-1"},Fe={class:"w-full bg-white"},Te={class:"table table-responsive w-full border border-collapse"},Ke=e("thead",null,[e("tr",{class:"bg-gray-200"},[e("th",{class:"border p-2"},"No"),e("th",{class:"border p-2"},"Id"),e("th",{class:"border p-2"},"NISN"),e("th",{class:"border p-2"},"Kode Lomba"),e("th",{class:"border p-2"},"Kode Bidang Lomba"),e("th",{class:"border p-2"},"Peringkat"),e("th",{class:"border p-2"},"Nilai"),e("th",{class:"border p-2"},"Ketarangan")])],-1),Le={class:"text-center py-1 px-2 border"},Ue={class:"text-center py-1 px-2 border"},Oe={class:"text-center py-1 px-2 border"},Me={class:"text-center py-1 px-2 border"},Ee={class:"text-center py-1 px-2 border"},He={class:"text-center py-1 px-2 border"},Re={class:"text-center py-1 px-2 border"},Xe={class:"text-center py-1 px-2 border"},et={__name:"DataJuara",props:{lomba:Object},setup(D){const x=M(),a=c("list"),_=c([]),v=c(!1),b=async()=>{v.value=!0,await w.post(route("juara.index")).then(l=>{_.value=l.data.juaras.filter(r=>x.props.auth.user.level=="admin"?r:r.peserta.sekolah_id==x.props.sekolahs[0].npsn),v.value=!1})},k=c(null),j=l=>{a.value="piagam",k.value=l},h=c(!1),n=()=>{h.value=!1,q.reload({only:["juaras"]})},s=c([]),g=c("Impor Data"),I=l=>{let r=l.target.files[0];g.value=r.name,a.value="impor";let t=new FileReader;t.onload=async y=>{let N=await Y(y.target.result);s.value=await $.sheet_to_json(N.Sheets[N.SheetNames[0]])},t.readAsArrayBuffer(r)},L=()=>{let l=$.book_new();l.Props={Title:"Data Juara Pentas PAIS",Subject:"Laporan",Author:"KKG PAI Wagir",CreatedDate:new Date},l.SheetNames.push("Data Juara");let r=$.json_to_sheet(_.value);l.Sheets["Data Juara"]=r,ee(l,{bookType:"xlsx",type:"binary"}),te(l,"Juara Pentas PAIS.xlsx")},U=async()=>{await w.post(route("juara.impor"),{data:JSON.stringify(s.value)}).then(l=>{a.value="list",b()}).catch(l=>console.log(l))};return T(()=>{b()}),(l,r)=>(i(),p("div",me,[m(d(E),{title:"Data Juara"}),e("div",xe,[e("span",null," DATA PERAIH JUARA "+o(d(x).props.sekolahs[0].nama),1),e("div",_e,[e("input",{type:"file",name:"fileJuara",ref:"fileJuara",onChange:I,accept:".xlsx, .xls, .ods, .csv",class:"hidden"},null,544),e("button",{class:"bg-green-400 hover:bg-green-600 active:bg-orange-400 text-white py-1 px-2 flex items-center rounded",onClick:L}," Download "),e("button",{class:"bg-green-400 hover:bg-green-600 active:bg-orange-400 text-white py-1 px-2 flex items-center rounded",onClick:r[0]||(r[0]=t=>l.$refs.fileJuara.click())},[m(d(F),{type:"mdi",path:d(z)},null,8,["path"]),u(" "+o(g.value),1)]),e("button",{class:"bg-teal-400 hover:bg-teal-600 active:bg-orange-400 text-white py-1 px-2 rounded",onClick:b},[m(d(K),{class:"h-6 text-white"})]),e("button",{class:"bg-teal-400 hover:bg-teal-600 active:bg-orange-400 text-white py-1 px-2 rounded",onClick:r[1]||(r[1]=t=>h.value=!0)},"Baru"),m(d(G),{class:"text-red-600 h-8 hover:text-red-800 active:text-orange-400 cursor-pointer",onClick:r[2]||(r[2]=t=>l.$emit("close"))})])]),e("div",ve,[h.value?(i(),P(ye,{key:0,onClose:n})):J("",!0),m(X,{type:"fade"},{default:H(()=>[a.value=="piagam"?(i(),P(Z,{key:0,juara:k.value,onClose:r[3]||(r[3]=t=>a.value="list")},null,8,["juara"])):a.value=="list"?(i(),p("div",{key:1,class:R(["table table-responsive w-full ease-linear transition-all",v.value?"bg-gray-50":""])},[e("table",fe,[ke,e("tbody",null,[(i(!0),p(C,null,A(_.value,(t,y)=>(i(),p("tr",{key:y,class:"odd:bg-gray-100"},[e("td",we,o(y+1),1),e("td",je,o(t.peserta.nisn),1),e("td",Ne,o(t.peserta.nama),1),e("td",Se,o(t.peserta.jk),1),e("td",$e,o(t.bidang.label),1),e("td",Ce,o(t.peringkat),1),e("td",Ae,o(t.nilai),1),e("td",Pe,o(t.peserta.sekolah.nama),1),e("td",Je,[e("button",{class:"px-2 py-1 rounded-md hover:bg-sky-600 active:bg-orange-400 bg-sky-400 text-white flex items-center mx-auto",onClick:N=>j(t)},[m(d(Q),{class:"text-white h-6"}),u(" Cetak ")],8,De)])]))),128))])])],2)):a.value=="impor"?(i(),p("div",Ie,[e("div",Be,[u(" Data Juara "),e("div",Ve,[e("button",{class:"bg-green-400 hover:bg-green-600 active:bg-orange-400 text-white py-1 px-2 flex items-center rounded",onClick:U}," Simpan "),e("button",{class:"aspect-square bg-red-400 text-white h-8 flex items-center justify-center rounded",onClick:r[4]||(r[4]=t=>{a.value="list",g.value="Impor Data"})},[m(d(F),{type:"mdi",path:d(W)},null,8,["path"])])])]),e("div",Fe,[e("table",Te,[Ke,e("tbody",null,[(i(!0),p(C,null,A(s.value,(t,y)=>(i(),p("tr",{key:y,class:"odd:bg-gray-100"},[e("td",Le,o(y+1),1),e("td",Ue,o(t.id),1),e("td",Oe,o(t.peserta_id),1),e("td",Me,o(t.lomba_id),1),e("td",Ee,o(t.bidang_id),1),e("td",He,o(t.peringkat),1),e("td",Re,o(t.nilai),1),e("td",Xe,o(t.keterangan),1)]))),128))])])])])):J("",!0)]),_:1})])]))}};export{et as default};