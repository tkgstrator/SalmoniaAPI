<template>
  <v-app dark>
    <v-container id="login" v-if="progress==null">
      <template v-if="isClicked">
        <v-text-field v-model="authURL" label="URL"></v-text-field>
        <v-btn @click="loginSplatNet2(authURL)">Login</v-btn>
      </template>
      <template v-if="!isClicked">
        <v-btn @click="openOAuthURL">OPEN URL</v-btn>
      </template>
    </v-container>
    <v-container id="log" v-if="progress!=null">
      <p>{{log[progress]}}</p>
      <p>{{token.session_token}}</p>
      <p>{{token.access_token}}</p>
      <p>{{token.splatoon_token}}</p>
      <p>{{token.splatoon_access_token}}</p>
      <p>{{token.iksm_session}}</p>
    </v-container>
  </v-app>
</template>

<script>
export default {
  name: "App",

  components: {},

  data: () => ({
    progress: null,
    isClicked: false,
    auth: {
      url:
        "https://accounts.nintendo.com/connect/1.0.0/authorize?state=DthLWOg54YPRnkPpxhY0aMyxEfSdmRplaOtIlIJimBxnAhbM&redirect_uri=npf71b963c1b7b6d119://auth&client_id=71b963c1b7b6d119&scope=openid+user+user.birthday+user.mii+user.screenName&response_type=session_token_code&session_token_code_challenge=8PlJorbqc1oUmynjgtICD3JzrNd3oez9kTeEYBCsXls&session_token_code_challenge_method=S256&theme=login_form",
      verifier: "1Z67BfUuhHK8kk9SQxre81Ffx2_4Kzz42mAUUI0Ir5g",
      code: String
    },
    token: {
      session_token: null,
      access_token: null,
      splatoon_token: null,
      splatoon_access_token: null,
      iksm_session: null,
      username: null
    },
    log: {
      0: "Waiting input the URL...",
      1: "Getting session_token...",
      2: "Getting access_token...",
      3: "Getting f(1/2)...",
      4: "Getting splatoon_token...",
      5: "Getting f(2/2)...",
      6: "Getting splatoon_access_token...",
      7: "Getting iksm_session...",
      8: "Done"
    }
  }),
  methods: {
    openOAuthURL() {
      this.isClicked = !this.isClicked;
      window.open(this.auth.url, "_blank");
    },
    async loginSplatNet2(authURL) {
      let code = authURL.match("de=(.*)&")[1];
      this.progress = 1;
      let session_token = await this.getSessionToken(code, this.auth.verifier);
      console.log(session_token)
      this.token.session_token = session_token;
      this.progress = 2;
      let access_token = await this.getAccessToken(session_token);
      this.token.access_token = access_token;
      this.progress = 3;
      let flapg_nso = await this.callFlapgAPI(access_token, "nso");
      this.progress = 4;
      let response = await this.getSplatoonToken(flapg_nso);
      let splatoon_token = response["splatoon_token"];
      this.token.splatoon_token = session_token
      this.token.username = response["user"]["name"]
      this.progress = 5;
      let flapg_app = await this.callFlapgAPI(splatoon_token, "app");
      this.progress = 6;
      let splatoon_access_token = await this.getSplatoonAccessToken(
        flapg_app,
        splatoon_token
      );
      this.token.splatoon_access_token = splatoon_access_token;
      this.progress = 7;
      let iksm_session = await this.getIksmSession(splatoon_access_token);
      this.token.iksm_session = iksm_session;
      this.progress = 8;
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
    async callFlapgAPI(access_token, type) {
      let url = "https://salmonia.mydns.jp/api/login";
      let body = {
        access_token: access_token,
        type: type
      };
      let response = await fetch(url, {
        method: "POST",
        body: JSON.stringify(body)
      });
      let json = await response.json();
      return json;
    },
    async getSplatoonToken(flapg_nso) {
      let url = "https://salmonia.mydns.jp/api/splatoon_token";
      let body = flapg_nso;
      let response = await fetch(url, {
        method: "POST",
        body: JSON.stringify(body)
      });
      let json = await response.json();
      console.log(json)
      return json
    },
    async getSplatoonAccessToken(flapg_app, splatoon_token) {
      let url = "https://salmonia.mydns.jp/api/splatoon_access_token";
      let body = {
        parameter: flapg_app,
        splatoon_token: splatoon_token
      };
      let response = await fetch(url, {
        method: "POST",
        body: JSON.stringify(body)
      });
      let json = await response.json();
      return json["splatoon_access_token"];
    },
    async getIksmSession(splatoon_access_token) {
      let url = "https://salmonia.mydns.jp/api/iksm_session";
      let body = {
        splatoon_access_token: splatoon_access_token
      };
      let response = await fetch(url, {
        method: "POST",
        body: JSON.stringify(body)
      });
      let json = await response.json();
      return json["iksm_session"];
    }
  }
};
</script>

<style>
@import url("https://fonts.googleapis.com/css2?family=Roboto+Mono&display=swap");

body {
  color: #acacac;
  background-color: #141619;
}

#app {
  display: block;
  margin: 0 auto;
  width: 80%;
  max-width: 800px;
  color: #acacac;
  background-color: #141619;
}

#login {
  padding-top: 30vh;
  display: block;
  margin: 0 auto;
  text-align: center;
}

#login button {
  width: 50%;
  font-size: 3vw;
  min-height: 30px;
  height: 5vh;
}

#log {
  color: #ffffff;
  font-family: "Roboto Mono", monospace;
  background-color: #111111;
}

#log p {
  word-wrap: break-word;
}

input {
  color: #acacac !important;
}

label {
  color: #ffffff !important;
}
</style>