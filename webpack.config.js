const path = require('path')
const uglify = require("uglifyjs-webpack-plugin")
const dev = process.env.NODE_ENV === "dev"
const ExtractTextPlugin = require("extract-text-webpack-plugin");
const ManifestPlugin = require("webpack-manifest-plugin");
const CleanWebpackPlugin = require('clean-webpack-plugin');
const WebpackBuildNotifierPlugin = require('webpack-build-notifier');
const FaviconsWebpackPlugin = require('favicons-webpack-plugin');
const title = 'Toad Project'

let cssLoaders = [{
    loader: 'css-loader', options: {
        minimize: !dev,
        importLoaders: 1
    }
}, {
    loader: 'postcss-loader', options: {
        plugins: (loader) => [
            require('autoprefixer')({
                browsers: ['last 2 versions', 'ie > 8']
            }),
        ]
    }
},];

let config = {
    entry: {
        app: ['./ressources/assets/css/app.scss', './ressources/assets/js/app.js',],
        404: ['./ressources/assets/css/404.css'],
    },
    watch: dev,
    output: {
        path: path.resolve('./public/dist'),
        filename: dev ? '[name].js' : '[name].[chunkhash:8].js',
        publicPath: (dev ? 'http://localhost:8080' : '') + "/dist/",
    },
    resolve: {
        alias: {
            '@css': path.resolve('./assets/css/'),
            '@js': path.resolve('./assets/js/'),
        }
    },
    devtool: dev ? "cheap-module-eval-source-map" : "Source-map",
    devServer: {
        overlay: true,
        proxy: {
            "/": {
                target: "http://localhost:8000",
                pathRewrite: {"^": ""},
            }
        }
    },
    module: {
        rules: [
            {
                enforce: 'pre',
                test: /\.js$/,
                exclude: /(node_modules|bower_components)/,
                use: {
                    loader: 'eslint-loader',
                },
            },
            {
                test: /\.js$/,
                exclude: /(node_modules|bower_components)/,
                use: {
                    loader: 'babel-loader',
                },
            },
            {
                test: /\.css$/,
                use: ExtractTextPlugin.extract({
                    fallback: "style-loader",
                    use: cssLoaders
                }),
            },
            {
                test: /\.scss$/,
                use: ExtractTextPlugin.extract({
                    fallback: "style-loader",
                    use: [...cssLoaders, 'sass-loader']
                }),
            },
            {
                test: /\.(png|jpe?g|gif|svg)?$/,
                use: [
                    {
                        loader: 'url-loader',
                        options: {
                            limit: 8192,
                            name: '[name].[hash:7].[ext]',
                        }
                    },
                    {
                        loader: 'img-loader',
                        options: {
                            enabled: !dev
                        }
                    }
                ]
            },
            {
                test: /\.(woff2?|eot|ttf|otf|wav)(\?.*)?$/,
                use: [
                    {
                        loader: 'file-loader',
                    }
                ]
            },
        ]
    },
    plugins: [
        new ExtractTextPlugin({
            filename: dev ? '[name].css' : '[name].[contenthash:8].css',
        }),
        new CleanWebpackPlugin(['dist'], {
            root: path.resolve('./public/'),
            verbose: true,
        }),

    ]
}

if (!dev) {
    config.plugins.push(new uglify),
        config.plugins.push(new ManifestPlugin()),
        config.plugins.push(new FaviconsWebpackPlugin(
            {
                logo: path.resolve('./assets/images/logo.png'),
                // The prefix for all image files (might be a folder or a name)
                prefix: 'icons-[hash]/',
                // Emit all stats of the generated icons
                emitStats: false,
                // The name of the json containing all favicon information
                statsFilename: 'iconstats-[hash].json',
                // Generate a cache file with control hashes and
                // don't rebuild the favicons until those hashes change
                persistentCache: true,
                // favicon background color (see https://github.com/haydenbleasel/favicons#usage)
                background: '#fff',
                // favicon app title (see https://github.com/haydenbleasel/favicons#usage)
                title: title,
            }
        ))
} else {
    config.plugins.push(new WebpackBuildNotifierPlugin({
        title: title,
        suppressSuccess: true
    }))
}


module.exports = config
