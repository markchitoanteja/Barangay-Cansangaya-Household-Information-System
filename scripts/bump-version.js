const fs = require("fs");
const path = require("path");

const envPath = path.join(__dirname, "../.env");

let env = fs.readFileSync(envPath, "utf8");

// Match version
const match = env.match(/APP_VERSION=(\d+)\.(\d+)\.(\d+)/);

if (!match) {
    console.error("APP_VERSION not found in .env");
    process.exit(1);
}

let major = parseInt(match[1]);
let minor = parseInt(match[2]);
let patch = parseInt(match[3]);

// Determine increment type
const type = process.argv[2] || "patch";

switch (type) {
    case "major":
        major++;
        minor = 0;
        patch = 0;
        break;

    case "minor":
        minor++;
        patch = 0;
        break;

    case "patch":
        patch++;
        break;

    default:
        console.error("Invalid version type. Use major, minor, or patch.");
        process.exit(1);
}

const newVersion = `${major}.${minor}.${patch}`;

// 📅 Auto-generate today's date (ISO format: YYYY-MM-DD)
const today = new Date().toISOString().split("T")[0];

// Replace APP_VERSION
env = env.replace(
    /APP_VERSION=\d+\.\d+\.\d+/,
    `APP_VERSION=${newVersion}`
);

// Replace or insert APP_LAST_UPDATED
if (env.match(/APP_LAST_UPDATED=/)) {
    env = env.replace(
        /APP_LAST_UPDATED=.*/,
        `APP_LAST_UPDATED=${today}`
    );
} else {
    env += `\nAPP_LAST_UPDATED=${today}\n`;
}

fs.writeFileSync(envPath, env);

console.log(`APP_VERSION updated → ${newVersion}`);
console.log(`APP_LAST_UPDATED updated → ${today}`);