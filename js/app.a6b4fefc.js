(function(e){function n(n){for(var r,a,i=n[0],c=n[1],u=n[2],l=0,f=[];l<i.length;l++)a=i[l],Object.prototype.hasOwnProperty.call(s,a)&&s[a]&&f.push(s[a][0]),s[a]=0;for(r in c)Object.prototype.hasOwnProperty.call(c,r)&&(e[r]=c[r]);p&&p(n);while(f.length)f.shift()();return o.push.apply(o,u||[]),t()}function t(){for(var e,n=0;n<o.length;n++){for(var t=o[n],r=!0,i=1;i<t.length;i++){var c=t[i];0!==s[c]&&(r=!1)}r&&(o.splice(n--,1),e=a(a.s=t[0]))}return e}var r={},s={app:0},o=[];function a(n){if(r[n])return r[n].exports;var t=r[n]={i:n,l:!1,exports:{}};return e[n].call(t.exports,t,t.exports,a),t.l=!0,t.exports}a.m=e,a.c=r,a.d=function(e,n,t){a.o(e,n)||Object.defineProperty(e,n,{enumerable:!0,get:t})},a.r=function(e){"undefined"!==typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},a.t=function(e,n){if(1&n&&(e=a(e)),8&n)return e;if(4&n&&"object"===typeof e&&e&&e.__esModule)return e;var t=Object.create(null);if(a.r(t),Object.defineProperty(t,"default",{enumerable:!0,value:e}),2&n&&"string"!=typeof e)for(var r in e)a.d(t,r,function(n){return e[n]}.bind(null,r));return t},a.n=function(e){var n=e&&e.__esModule?function(){return e["default"]}:function(){return e};return a.d(n,"a",n),n},a.o=function(e,n){return Object.prototype.hasOwnProperty.call(e,n)},a.p="/SalmoniaAPI/";var i=window["webpackJsonp"]=window["webpackJsonp"]||[],c=i.push.bind(i);i.push=n,i=i.slice();for(var u=0;u<i.length;u++)n(i[u]);var p=c;o.push([0,"chunk-vendors"]),t()})({0:function(e,n,t){e.exports=t("56d7")},"034f":function(e,n,t){"use strict";var r=t("85ec"),s=t.n(r);s.a},"56d7":function(e,n,t){"use strict";t.r(n);t("e260"),t("e6cf"),t("cca6"),t("a79d");var r=t("2b0e"),s=function(){var e=this,n=e.$createElement,t=e._self._c||n;return t("v-app",{attrs:{dark:""}},[null==e.progress?t("v-container",{attrs:{id:"login"}},[e.isClicked?[t("v-text-field",{attrs:{label:"URL"},model:{value:e.authURL,callback:function(n){e.authURL=n},expression:"authURL"}}),t("v-btn",{on:{click:function(n){return e.loginSplatNet2(e.authURL)}}},[e._v("Login")])]:e._e(),e.isClicked?e._e():[t("v-btn",{on:{click:e.openOAuthURL}},[e._v("OPEN URL")])]],2):e._e(),null!=e.progress?t("v-container",{attrs:{id:"log"}},[t("p",[e._v(e._s(e.log[e.progress]))]),t("p",[e._v(e._s(e.token.session_token))]),t("p",[e._v(e._s(e.token.access_token))]),t("p",[e._v(e._s(e.token.splatoon_token))]),t("p",[e._v(e._s(e.token.splatoon_access_token))]),t("p",[e._v(e._s(e.token.iksm_session))])]):e._e()],1)},o=[],a=(t("d3b7"),t("ac1f"),t("466d"),t("96cf"),t("1da1")),i={name:"App",components:{},data:function(){return{progress:null,isClicked:!1,auth:{url:"https://accounts.nintendo.com/connect/1.0.0/authorize?state=DthLWOg54YPRnkPpxhY0aMyxEfSdmRplaOtIlIJimBxnAhbM&redirect_uri=npf71b963c1b7b6d119://auth&client_id=71b963c1b7b6d119&scope=openid+user+user.birthday+user.mii+user.screenName&response_type=session_token_code&session_token_code_challenge=8PlJorbqc1oUmynjgtICD3JzrNd3oez9kTeEYBCsXls&session_token_code_challenge_method=S256&theme=login_form",verifier:"1Z67BfUuhHK8kk9SQxre81Ffx2_4Kzz42mAUUI0Ir5g",code:String},token:{session_token:null,access_token:null,splatoon_token:null,splatoon_access_token:null,iksm_session:null},log:{0:"Waiting input the URL...",1:"Getting session_token...",2:"Getting access_token...",3:"Getting f(1/2)...",4:"Getting splatoon_token...",5:"Getting f(2/2)...",6:"Getting splatoon_access_token...",7:"Getting iksm_session...",8:"Done"}}},methods:{openOAuthURL:function(){this.isClicked=!this.isClicked,window.open(this.auth.url,"_blank")},loginSplatNet2:function(e){var n=this;return Object(a["a"])(regeneratorRuntime.mark((function t(){var r,s,o,a,i,c,u,p;return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:return r=e.match("de=(.*)&")[1],n.progress=1,t.next=4,n.getSessionToken(r,n.auth.verifier);case 4:return s=t.sent,n.token.session_token=s,n.progress=2,t.next=9,n.getAccessToken(s);case 9:return o=t.sent,n.token.access_token=o,n.progress=3,t.next=14,n.callFlapgAPI(o,"nso");case 14:return a=t.sent,n.progress=4,t.next=18,n.getSplatoonToken(a);case 18:return i=t.sent,n.token.splatoon_token=i,n.progress=5,t.next=23,n.callFlapgAPI(i,"app");case 23:return c=t.sent,n.progress=6,t.next=27,n.getSplatoonAccessToken(c,i);case 27:return u=t.sent,n.token.splatoon_access_token=u,n.progress=7,t.next=32,n.getIksmSession(u);case 32:p=t.sent,n.token.iksm_session=p,n.progress=8;case 35:case"end":return t.stop()}}),t)})))()},getSessionToken:function(e,n){return Object(a["a"])(regeneratorRuntime.mark((function t(){var r,s,o,a;return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:return r="https://salmonia.mydns.jp/api/session_token",s={session_token_code:e,session_token_code_verifier:n},t.next=4,fetch(r,{method:"POST",body:JSON.stringify(s)});case 4:return o=t.sent,t.next=7,o.json();case 7:return a=t.sent,t.abrupt("return",a["session_token"]);case 9:case"end":return t.stop()}}),t)})))()},getAccessToken:function(e){return Object(a["a"])(regeneratorRuntime.mark((function n(){var t,r,s,o;return regeneratorRuntime.wrap((function(n){while(1)switch(n.prev=n.next){case 0:return t="https://salmonia.mydns.jp/api/access_token",r={session_token:e},n.next=4,fetch(t,{method:"POST",body:JSON.stringify(r)});case 4:return s=n.sent,n.next=7,s.json();case 7:return o=n.sent,n.abrupt("return",o["access_token"]);case 9:case"end":return n.stop()}}),n)})))()},callFlapgAPI:function(e,n){return Object(a["a"])(regeneratorRuntime.mark((function t(){var r,s,o,a;return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:return r="https://salmonia.mydns.jp/api/login",s={access_token:e,type:n},t.next=4,fetch(r,{method:"POST",body:JSON.stringify(s)});case 4:return o=t.sent,t.next=7,o.json();case 7:return a=t.sent,t.abrupt("return",a["result"]);case 9:case"end":return t.stop()}}),t)})))()},getSplatoonToken:function(e){return Object(a["a"])(regeneratorRuntime.mark((function n(){var t,r,s,o;return regeneratorRuntime.wrap((function(n){while(1)switch(n.prev=n.next){case 0:return t="https://salmonia.mydns.jp/api/splatoon_token",r=e,n.next=4,fetch(t,{method:"POST",body:JSON.stringify(r)});case 4:return s=n.sent,n.next=7,s.json();case 7:return o=n.sent,n.abrupt("return",o["result"]["webApiServerCredential"]["accessToken"]);case 9:case"end":return n.stop()}}),n)})))()},getSplatoonAccessToken:function(e,n){return Object(a["a"])(regeneratorRuntime.mark((function t(){var r,s,o,a;return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:return r="https://salmonia.mydns.jp/api/splatoon_access_token",s={parameter:e,splatoon_token:n},t.next=4,fetch(r,{method:"POST",body:JSON.stringify(s)});case 4:return o=t.sent,t.next=7,o.json();case 7:return a=t.sent,t.abrupt("return",a["result"]["accessToken"]);case 9:case"end":return t.stop()}}),t)})))()},getIksmSession:function(e){return Object(a["a"])(regeneratorRuntime.mark((function n(){var t,r,s,o;return regeneratorRuntime.wrap((function(n){while(1)switch(n.prev=n.next){case 0:return t="https://salmonia.mydns.jp/api/iksm_session",r={splatoon_access_token:e},n.next=4,fetch(t,{method:"POST",body:JSON.stringify(r)});case 4:return s=n.sent,n.next=7,s.json();case 7:return o=n.sent,n.abrupt("return",o["iksm_session"]);case 9:case"end":return n.stop()}}),n)})))()}}},c=i,u=(t("034f"),t("2877")),p=t("6544"),l=t.n(p),f=t("7496"),d=t("8336"),k=t("a523"),_=t("8654"),g=Object(u["a"])(c,s,o,!1,null,null,null),h=g.exports;l()(g,{VApp:f["a"],VBtn:d["a"],VContainer:k["a"],VTextField:_["a"]});var m=t("f309");r["a"].use(m["a"]);var v=new m["a"]({});r["a"].config.productionTip=!1,new r["a"]({vuetify:v,render:function(e){return e(h)}}).$mount("#app")},"85ec":function(e,n,t){}});