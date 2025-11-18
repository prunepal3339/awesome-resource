import path from 'path';
import MiniCssExtractPlugin from 'mini-css-extract-plugin';
import RemoveEmptyScriptsPlugin from 'webpack-remove-empty-scripts';
import { fileURLToPath } from 'url';

const __filename = fileURLToPath(import.meta.url);
const __dirname  = path.dirname(__filename);

export default {
    mode: 'production',
    entry: {
        shortcodes: './assets/src/scss/shortcodes.scss'
    },
    output: {
        path: path.resolve(__dirname, 'assets/dist'),
        clean: true
    },
    module: {
        rules: [
            {
                test: /\.(scss|sass)$/i,
                use: [
                    MiniCssExtractPlugin.loader,
                    'css-loader',
                    'sass-loader'
                ],
            },
        ],
    },

    plugins: [
        new RemoveEmptyScriptsPlugin(),
        new MiniCssExtractPlugin({
            filename: 'css/[name].css',
        }),
    ],
    optimization: {
        runtimeChunk: false,
    }
};
