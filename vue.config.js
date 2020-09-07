module.exports = {
  "transpileDependencies": [
    "vuetify"
  ],
  publicPath: process.env.NODE_ENV === "production"
    ? "/SalmoniaAPI/"
    : "./",
  productionSourceMap: false,
  assetsDir: "",
  outputDir: "./dist"
}