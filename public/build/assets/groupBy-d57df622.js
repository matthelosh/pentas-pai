import{b as i}from"./_baseAssignValue-e26c3332.js";import{k as g,f as b}from"./_baseIsEqual-61354f41.js";import{b as h}from"./isArrayLike-4aa94e85.js";import{a as p}from"./_baseIteratee-e1418dfa.js";function v(e,n,r,a){for(var t=-1,s=e==null?0:e.length;++t<s;){var f=e[t];n(a,f,r(f),e)}return a}function c(e){return function(n,r,a){for(var t=-1,s=Object(n),f=a(n),u=f.length;u--;){var o=f[e?u:++t];if(r(s[o],o,s)===!1)break}return n}}var m=c();const w=m;function A(e,n){return e&&w(e,n,g)}function O(e,n){return function(r,a){if(r==null)return r;if(!h(r))return e(r,a);for(var t=r.length,s=n?t:-1,f=Object(r);(n?s--:++s<t)&&a(f[s],s,f)!==!1;);return r}}var x=O(A);const y=x;function B(e,n,r,a){return y(e,function(t,s,f){n(a,t,r(t),f)}),a}function F(e,n){return function(r,a){var t=b(r)?v:B,s=n?n():{};return t(r,e,p(a),s)}}var d=Object.prototype,k=d.hasOwnProperty,E=F(function(e,n,r){k.call(e,r)?e[r].push(n):i(e,r,[n])});const L=E;export{L as g};