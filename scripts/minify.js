const fs = require("fs");
const path = require("path");
const terser = require("terser");

const jsDir = path.join(__dirname, "..", "public", "assets", "js");

async function minifyFile(filePath) {
    if (filePath.endsWith(".min.js")) return;

    const code = fs.readFileSync(filePath, "utf8");

    const result = await terser.minify(code, {
        compress: true,
        mangle: true
    });

    const minPath = filePath.replace(/\.js$/, ".min.js");

    fs.writeFileSync(minPath, result.code, "utf8");

    // delete original file after successful minify
    fs.unlinkSync(filePath);

    console.log(`Minified: ${minPath}`);
}

async function walk(dir) {
    const files = fs.readdirSync(dir);

    for (const file of files) {
        const full = path.join(dir, file);
        const stat = fs.statSync(full);

        if (stat.isDirectory()) {
            await walk(full);
        } else if (file.endsWith(".js") && !file.endsWith(".min.js")) {
            await minifyFile(full);
        }
    }
}

walk(jsDir);