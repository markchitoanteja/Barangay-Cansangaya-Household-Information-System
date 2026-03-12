const fs = require("fs");
const path = require("path");

const envPath = path.join(__dirname, "../.env");

let env = fs.readFileSync(envPath, "utf8");

const match = env.match(/APP_VERSION=(\d+)\.(\d+)\.(\d+)/);

if (!match) {
    console.error("APP_VERSION not found in .env");
    process.exit(1);
}

let major = parseInt(match[1]);
let minor = parseInt(match[2]);
let patch = parseInt(match[3]);

// Determine which part to increment
const type = process.argv[2] || "patch"; // default to patch

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

env = env.replace(/APP_VERSION=\d+\.\d+\.\d+/, `APP_VERSION=${newVersion}`);

fs.writeFileSync(envPath, env);

console.log(`APP_VERSION updated → ${newVersion}`);