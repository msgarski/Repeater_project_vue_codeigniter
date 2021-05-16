// vue.config.js
module.exports = {
    configureWebpack: {
        output: {
          libraryExport: 'default',
        }
      },
    chainWebpack: (config) => {
        config.resolve.symlinks(false)
      },
      
}