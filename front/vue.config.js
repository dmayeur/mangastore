module.exports = {
    css: {
        loaderOptions: {
            sass: {
                prependData: `
                    @import "@/scss/_variables.scss";
                    @import "@/scss/_mixin.scss";
                `
            }
        }
    },
    devServer: {
      proxy: {
          // redirect all api calls to the back server
          '^/api': {
             target: 'http://localhost:80',
             changeOrigin: true,
             secure:false,
             pathRewrite: {'^/api': 'mangastore/api'},
             logLevel: 'debug'
          }
      }
    }
};
