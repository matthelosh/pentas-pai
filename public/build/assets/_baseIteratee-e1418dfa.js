import{f as o,M as E,S as w,q as C,k as T,m as N}from"./_baseIsEqual-61354f41.js";import{S as I,a as $,d as x,i as F}from"./isArrayLike-4aa94e85.js";import{i as c}from"./isSymbol-80af4f08.js";function L(n,r){for(var t=-1,e=n==null?0:n.length,i=Array(e);++t<e;)i[t]=r(n[t],t,n);return i}var D=1/0,P=I?I.prototype:void 0,A=P?P.toString:void 0;function M(n){if(typeof n=="string")return n;if(o(n))return L(n,M)+"";if(c(n))return A?A.call(n):"";var r=n+"";return r=="0"&&1/n==-D?"-0":r}function G(n){return n}var U=/\.|\[(?:[^[\]]*|(["'])(?:(?!\1)[^\\]|\\.)*?\1)\]/,q=/^\w*$/;function p(n,r){if(o(n))return!1;var t=typeof n;return t=="number"||t=="symbol"||t=="boolean"||n==null||c(n)?!0:q.test(n)||!U.test(n)||r!=null&&n in Object(r)}var z="Expected a function";function g(n,r){if(typeof n!="function"||r!=null&&typeof r!="function")throw new TypeError(z);var t=function(){var e=arguments,i=r?r.apply(this,e):e[0],f=t.cache;if(f.has(i))return f.get(i);var u=n.apply(this,e);return t.cache=f.set(i,u)||f,u};return t.cache=new(g.Cache||E),t}g.Cache=E;var K=500;function X(n){var r=g(n,function(e){return t.size===K&&t.clear(),e}),t=r.cache;return r}var Y=/[^.[\]]+|\[(?:(-?\d+(?:\.\d+)?)|(["'])((?:(?!\2)[^\\]|\\.)*?)\2)\]|(?=(?:\.|\[\])(?:\.|\[\]|$))/g,Z=/\\(\\)?/g,H=X(function(n){var r=[];return n.charCodeAt(0)===46&&r.push(""),n.replace(Y,function(t,e,i,f){r.push(i?f.replace(Z,"$1"):e||t)}),r});const B=H;function J(n){return n==null?"":M(n)}function O(n,r){return o(n)?n:p(n,r)?[n]:B(J(n))}var Q=1/0;function a(n){if(typeof n=="string"||c(n))return n;var r=n+"";return r=="0"&&1/n==-Q?"-0":r}function R(n,r){r=O(r,n);for(var t=0,e=r.length;n!=null&&t<e;)n=n[a(r[t++])];return t&&t==e?n:void 0}function W(n,r,t){var e=n==null?void 0:R(n,r);return e===void 0?t:e}var k=1,v=2;function b(n,r,t,e){var i=t.length,f=i,u=!e;if(n==null)return!f;for(n=Object(n);i--;){var s=t[i];if(u&&s[2]?s[1]!==n[s[0]]:!(s[0]in n))return!1}for(;++i<f;){s=t[i];var l=s[0],h=n[l],d=s[1];if(u&&s[2]){if(h===void 0&&!(l in n))return!1}else{var m=new w;if(e)var y=e(h,d,l,n,r,m);if(!(y===void 0?C(d,h,k|v,e,m):y))return!1}}return!0}function S(n){return n===n&&!$(n)}function V(n){for(var r=T(n),t=r.length;t--;){var e=r[t],i=n[e];r[t]=[e,i,S(i)]}return r}function _(n,r){return function(t){return t==null?!1:t[n]===r&&(r!==void 0||n in Object(t))}}function j(n){var r=V(n);return r.length==1&&r[0][2]?_(r[0][0],r[0][1]):function(t){return t===n||b(t,n,r)}}function nn(n,r){return n!=null&&r in Object(n)}function rn(n,r,t){r=O(r,n);for(var e=-1,i=r.length,f=!1;++e<i;){var u=a(r[e]);if(!(f=n!=null&&t(n,u)))break;n=n[u]}return f||++e!=i?f:(i=n==null?0:n.length,!!i&&x(i)&&F(u,i)&&(o(n)||N(n)))}function tn(n,r){return n!=null&&rn(n,r,nn)}var en=1,fn=2;function un(n,r){return p(n)&&S(r)?_(a(n),r):function(t){var e=W(t,n);return e===void 0&&e===r?tn(t,n):C(r,e,en|fn)}}function sn(n){return function(r){return r==null?void 0:r[n]}}function on(n){return function(r){return R(r,n)}}function an(n){return p(n)?sn(a(n)):on(n)}function pn(n){return typeof n=="function"?n:n==null?G:typeof n=="object"?o(n)?un(n[0],n[1]):j(n):an(n)}export{pn as a,R as b,O as c,a as t};
