const i=e=>{if(e.includes("=")){let t=e.split("=");return`https://drive.google.com/uc?export=view&id=${t[t.length-1]}`}else return e[0]=="/"?e:"/"+e};export{i};
