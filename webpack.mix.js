const mix = require("laravel-mix");
const fs = require("fs");

const theme = "searchx";
const path = `./wp-content/themes/${theme}`;

const moduleOpts = {
	rules: [
		{
			test: /\.scss/,
			loader: "glob-import-loader",
		},
		{
			test: /\.js/,
			loader: "glob-import-loader",
		},
	],
};

const optionsOpts = {
	processCssUrls: false,
	postCss: [require("autoprefixer")],
	autoprefixer: {
		options: {
			browsers: ["defaults"],
		},
	},
};

mix
	.webpackConfig({ module: moduleOpts })
	.options(optionsOpts)
	.setResourceRoot(`${path}/dist`)
	.setPublicPath(`${path}/dist`)
	.browserSync({
		proxy: "https://searchx.local",
		files: [
			`${path}/dist/css/*.css`,
			`${path}/dist/js/*.js`,
			`${path}/**/*.php`,
		],
	});

mix
	.js(`${path}/assets/js/scripts.js`, "js")
	.sass(`${path}/assets/scss/style.scss`, "css");

mix.alias({
	"@": `${path}/assets/scss/`,
});

const components = fs
	.readdirSync(`${path}/components`, { withFileTypes: true })
	.filter((item) => item.isDirectory())
	.map((item) => item.name);

components.forEach((component) => {
	var jsPath = `${path}/components/${component}/js/${component}.js`;
	if (fs.existsSync(jsPath)) {
		mix.js(jsPath, "js");
	}

	var cssPath = `${path}/components/${component}/scss/${component}.scss`;
	if (fs.existsSync(cssPath)) {
		mix.sass(cssPath, "css");
	}
});

const templates = fs
	.readdirSync(`${path}/assets/scss/templates`, { withFileTypes: true })
	.filter((item) => item.isFile())
	.map((item) => item.name);

templates.forEach((template) => {
	mix.sass(`${path}/assets/scss/templates/${template}`, "templates");
});

mix.sass(`${path}/assets/scss/header.scss`, "css");

mix
	.sass(`${path}/assets/scss/bootstrap.scss`, "css")
	.js(`${path}/assets/js/bootstrap.js`, "js");
