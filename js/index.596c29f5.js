(function(e){function t(t){for(var r,a,c=t[0],u=t[1],i=t[2],l=0,f=[];l<c.length;l++)a=c[l],Object.prototype.hasOwnProperty.call(s,a)&&s[a]&&f.push(s[a][0]),s[a]=0;for(r in u)Object.prototype.hasOwnProperty.call(u,r)&&(e[r]=u[r]);p&&p(t);while(f.length)f.shift()();return o.push.apply(o,i||[]),n()}function n(){for(var e,t=0;t<o.length;t++){for(var n=o[t],r=!0,c=1;c<n.length;c++){var u=n[c];0!==s[u]&&(r=!1)}r&&(o.splice(t--,1),e=a(a.s=n[0]))}return e}var r={},s={index:0},o=[];function a(t){if(r[t])return r[t].exports;var n=r[t]={i:t,l:!1,exports:{}};return e[t].call(n.exports,n,n.exports,a),n.l=!0,n.exports}a.m=e,a.c=r,a.d=function(e,t,n){a.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:n})},a.r=function(e){"undefined"!==typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},a.t=function(e,t){if(1&t&&(e=a(e)),8&t)return e;if(4&t&&"object"===typeof e&&e&&e.__esModule)return e;var n=Object.create(null);if(a.r(n),Object.defineProperty(n,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var r in e)a.d(n,r,function(t){return e[t]}.bind(null,r));return n},a.n=function(e){var t=e&&e.__esModule?function(){return e["default"]}:function(){return e};return a.d(t,"a",t),t},a.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},a.p="/SalmoniaAPI/";var c=window["webpackJsonp"]=window["webpackJsonp"]||[],u=c.push.bind(c);c.push=t,c=c.slice();for(var i=0;i<c.length;i++)t(c[i]);var p=u;o.push([0,"chunk-vendors"]),n()})({0:function(e,t,n){e.exports=n("56d7")},"034f":function(e,t,n){"use strict";var r=n("85ec"),s=n.n(r);s.a},"56d7":function(e,t,n){"use strict";n.r(t);n("e260"),n("e6cf"),n("cca6"),n("a79d");var r=n("2b0e"),s=function(){var e=this,t=e.$createElement,n=e._self._c||t;return n("v-app",{attrs:{dark:""}},[n("v-container",{staticClass:"oauth"},[n("button",{on:{click:e.openOAuthURL}},[e._v("Open URL")]),n("v-text-field",{attrs:{label:"OAuth URL",required:"",dark:""},model:{value:e.authURL,callback:function(t){e.authURL=t},expression:"authURL"}}),n("button",{on:{click:function(t){return e.loginSplatNet2(e.authURL)}}},[e._v("Generate")])],1),n("v-container",{staticClass:"log"},e._l(e.tokens,(function(t){return n("p",{key:t.key},[e._v(" "+e._s(t.type+"\n"+t.value)+" ")])})),0)],1)},o=[],a=(n("a434"),n("d3b7"),n("ac1f"),n("466d"),n("96cf"),n("1da1"));function c(e,t){this.message=t,this.server=e}var u={name:"App",components:{},data:function(){return{authURL:"",url:"",auth:{url:"https://accounts.nintendo.com/connect/1.0.0/authorize?state=DthLWOg54YPRnkPpxhY0aMyxEfSdmRplaOtIlIJimBxnAhbM&redirect_uri=npf71b963c1b7b6d119://auth&client_id=71b963c1b7b6d119&scope=openid+user+user.birthday+user.mii+user.screenName&response_type=session_token_code&session_token_code_challenge=8PlJorbqc1oUmynjgtICD3JzrNd3oez9kTeEYBCsXls&session_token_code_challenge_method=S256&theme=login_form",verifier:"1Z67BfUuhHK8kk9SQxre81Ffx2_4Kzz42mAUUI0Ir5g",code:String},tokens:[]}},methods:{openOAuthURL:function(){this.isClicked=!this.isClicked,window.open(this.auth.url,"_blank")},loginSplatNet2:function(e){var t=this;return Object(a["a"])(regeneratorRuntime.mark((function n(){var r,s,o,a,c,u,i,p;return regeneratorRuntime.wrap((function(n){while(1)switch(n.prev=n.next){case 0:return t.tokens.splice(0,t.tokens.length),n.prev=1,r=e.match("de=(.*)&")[1],console.log(r),n.next=6,t.getSessionToken(r,t.auth.verifier);case 6:return s=n.sent,t.tokens.push({type:"session_token",value:s}),console.log(s),n.next=11,t.getAccessToken(s);case 11:return o=n.sent,t.tokens.push({type:"access_token",value:o}),console.log(o),n.next=16,t.callFlapgAPI(o,"nso");case 16:return a=n.sent,console.log(a),n.next=20,t.getSplatoonToken(a);case 20:return c=n.sent,t.tokens.push({type:"splatoon_token",value:c}),console.log(c),n.next=25,t.callFlapgAPI(c,"app");case 25:return u=n.sent,console.log(u),n.next=29,t.getSplatoonAccessToken(u,c);case 29:return i=n.sent,t.tokens.push({type:"splatoon_access_token",value:i}),console.log(i),n.next=34,t.getIksmSession(i);case 34:p=n.sent,t.tokens.push({type:"iksm_session",value:p}),console.log(p),n.next=42;break;case 39:n.prev=39,n.t0=n["catch"](1),t.tokens.push({type:n.t0.server,value:n.t0.message});case 42:case"end":return n.stop()}}),n,null,[[1,39]])})))()},getSessionToken:function(e,t){return Object(a["a"])(regeneratorRuntime.mark((function n(){var r,s,o,a,u;return regeneratorRuntime.wrap((function(n){while(1)switch(n.prev=n.next){case 0:return r="https://salmonia.mydns.jp/api/session_token",s={session_token_code:e,session_token_code_verifier:t},n.next=4,fetch(r,{method:"POST",body:JSON.stringify(s)});case 4:if(o=n.sent,200==o.status){n.next=10;break}return n.next=8,o.json();case 8:throw a=n.sent,new c("session_token",a["error_description"]);case 10:return n.next=12,o.json();case 12:return u=n.sent,n.abrupt("return",u["session_token"]);case 14:case"end":return n.stop()}}),n)})))()},getAccessToken:function(e){return Object(a["a"])(regeneratorRuntime.mark((function t(){var n,r,s,o,a;return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:return n="https://salmonia.mydns.jp/api/access_token",r={session_token:e},t.next=4,fetch(n,{method:"POST",body:JSON.stringify(r)});case 4:if(s=t.sent,200==s.status){t.next=10;break}return t.next=8,s.json();case 8:throw o=t.sent,new c("access_token",o["error_description"]);case 10:return t.next=12,s.json();case 12:return a=t.sent,t.abrupt("return",a["access_token"]);case 14:case"end":return t.stop()}}),t)})))()},callFlapgAPI:function(e,t){return Object(a["a"])(regeneratorRuntime.mark((function n(){var r,s,o,a,u;return regeneratorRuntime.wrap((function(n){while(1)switch(n.prev=n.next){case 0:return r="https://salmonia.mydns.jp/api/login",s={access_token:e,type:t},n.next=4,fetch(r,{method:"POST",body:JSON.stringify(s)});case 4:if(o=n.sent,200==o.status){n.next=10;break}return n.next=8,o.json();case 8:throw a=n.sent,new c("flapg api",a["error_description"]);case 10:return n.next=12,o.json();case 12:return u=n.sent,n.abrupt("return",u);case 14:case"end":return n.stop()}}),n)})))()},getSplatoonToken:function(e){return Object(a["a"])(regeneratorRuntime.mark((function t(){var n,r,s,o,a;return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:return n="https://salmonia.mydns.jp/api/splatoon_token",r=e,t.next=4,fetch(n,{method:"POST",body:JSON.stringify(r)});case 4:if(s=t.sent,200==s.status){t.next=10;break}return t.next=8,s.json();case 8:throw o=t.sent,new c("splatoon_token",o["error_description"]);case 10:return t.next=12,s.json();case 12:return a=t.sent,t.abrupt("return",a["splatoon_token"]);case 14:case"end":return t.stop()}}),t)})))()},getSplatoonAccessToken:function(e,t){return Object(a["a"])(regeneratorRuntime.mark((function n(){var r,s,o,a,u;return regeneratorRuntime.wrap((function(n){while(1)switch(n.prev=n.next){case 0:return r="https://salmonia.mydns.jp/api/splatoon_access_token",s={parameter:e,splatoon_token:t},n.next=4,fetch(r,{method:"POST",body:JSON.stringify(s)});case 4:if(o=n.sent,200==o.status){n.next=10;break}return n.next=8,o.json();case 8:throw a=n.sent,new c("splatoon_access_token",a["error_description"]);case 10:return n.next=12,o.json();case 12:return u=n.sent,n.abrupt("return",u["splatoon_access_token"]);case 14:case"end":return n.stop()}}),n)})))()},getIksmSession:function(e){return Object(a["a"])(regeneratorRuntime.mark((function t(){var n,r,s,o,a;return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:return n="https://salmonia.mydns.jp/api/iksm_session",r={splatoon_access_token:e},t.next=4,fetch(n,{method:"POST",body:JSON.stringify(r)});case 4:if(s=t.sent,200==s.status){t.next=10;break}return t.next=8,s.json();case 8:throw o=t.sent,new c("iksm_session",o["error_description"]);case 10:return t.next=12,s.json();case 12:return a=t.sent,t.abrupt("return",a["iksm_session"]);case 14:case"end":return t.stop()}}),t)})))()}}},i=u,p=(n("034f"),n("2877")),l=n("6544"),f=n.n(l),h=n("7496"),d=n("a523"),k=n("8654"),m=Object(p["a"])(i,s,o,!1,null,null,null),g=m.exports;f()(m,{VApp:h["a"],VContainer:d["a"],VTextField:k["a"]});var _=n("f309");r["a"].use(_["a"]);var b=new _["a"]({});r["a"].config.productionTip=!1,new r["a"]({vuetify:b,render:function(e){return e(g)}}).$mount("#app")},"85ec":function(e,t,n){}});