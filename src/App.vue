<template>
  <v-app>
    <v-text-field v-model="authURL"></v-text-field>
    <v-btn @click="loginSplatNet2(authURL)">Login</v-btn>
    <v-btn @click="openOAuthURL">OPEN URL</v-btn>
  </v-app>
</template>

<script>
export default {
  name: "App",

  components: {},

  data: () => ({
    auth: {
      url:
        "https://accounts.nintendo.com/connect/1.0.0/authorize?state=DthLWOg54YPRnkPpxhY0aMyxEfSdmRplaOtIlIJimBxnAhbM&redirect_uri=npf71b963c1b7b6d119://auth&client_id=71b963c1b7b6d119&scope=openid+user+user.birthday+user.mii+user.screenName&response_type=session_token_code&session_token_code_challenge=8PlJorbqc1oUmynjgtICD3JzrNd3oez9kTeEYBCsXls&session_token_code_challenge_method=S256&theme=login_form",
      verifier: "1Z67BfUuhHK8kk9SQxre81Ffx2_4Kzz42mAUUI0Ir5g",
      code: String
    }
  }),
  methods: {
    openOAuthURL() {
      window.open(this.auth.url, "_blank");
    },
    async loginSplatNet2(authURL) {
      let code = authURL.match("de=(.*)&")[1];
      // console.log(code);
      let session_token = await this.getSessionToken(code, this.auth.verifier);
      console.log("SESSION TOKEN", session_token);
      let access_token = await this.getAccessToken(session_token);
      console.log("ACCESS TOKEN", access_token);
      let hash = await this.callS2SAPI(access_token);
      console.log("HASH", hash);
    },
    async getSessionToken(code, verifier) {
      let url = "https://salmonia.mydns.jp/api/session_token";
      let body = {
        session_token_code: code,
        session_token_code_verifier: verifier
      };
      let response = await fetch(url, {
        method: "POST",
        body: JSON.stringify(body)
      });
      let json = await response.json();
      return json["session_token"];
    },
    async getAccessToken(session_token) {
      let url = "https://salmonia.mydns.jp/api/access_token";
      let body = {
        session_token: session_token
      };
      let response = await fetch(url, {
        method: "POST",
        body: JSON.stringify(body)
      });
      let json = await response.json();
      return json["access_token"];
    },
    async callS2SAPI(access_token) {
      let url = "https://elifessler.com/s2s/api/gen2";
      let timestamp = String(parseInt(new Date().getTime() / 1000));
      let body = {
        naIdToken: access_token,
        timestamp: timestamp
      };
      // s2s APIだけ何故かBodyの形式が違うので変換
      const queryString = require("query-string");
      body = queryString.stringify(body);
      let header = {
        Host: "elifessler.com",
        "Content-Type": "application/x-www-form-urlencoded; charset=utf-8",
        Connection: "keep-alive",
        Accept: "*/*",
        "Accept-Language": "ja-JP;q=1.0, en-CA;q=0.9, zh-Hant-CA;q=0.8",
        "Content-Length": body.length,
        "User-Agent": "Salmonia for ReactNative/0.0.1 @tkgling",
        "Accept-Encoding": "br;q=1.0, gzip;q=0.9, deflate;q=0.8"
      };
      let response = await fetch(url, {
        method: "POST",
        headers: header,
        body: body
        // body: JSON.stringify(body),
      });
      let json = await response.json();
      let hash = json["hash"];
      console.log("s2s API(NSO)", json, hash);
      return hash;
    }
  }
};
</script>
