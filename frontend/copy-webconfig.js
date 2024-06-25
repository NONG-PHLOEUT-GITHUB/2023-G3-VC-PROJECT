import fs from 'fs';
import path from 'path';

const __dirname = path.resolve();

const src = path.join(__dirname, 'web.config');
const destDir = path.join(__dirname, 'dist');
const dest = path.join(destDir, 'web.config');

// Ensure the destination directory exists
if (!fs.existsSync(destDir)) {
  fs.mkdirSync(destDir, { recursive: true });
}

// Copy the file
fs.copyFileSync(src, dest);

console.log(`Copied ${src} to ${dest}`);