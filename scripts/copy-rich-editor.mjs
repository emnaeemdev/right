import { mkdirSync, readFileSync } from 'node:fs';
import { dirname, join } from 'node:path';
import { fileURLToPath } from 'node:url';
import { buildSync } from 'esbuild';

const root = join(fileURLToPath(import.meta.url), '..', '..');
const entry = join(root, 'resources/js/filament/rich-editor.js');
const outFile = join(root, 'public/js/filament/forms/components/rich-editor.js');

mkdirSync(dirname(outFile), { recursive: true });

buildSync({
    entryPoints: [entry],
    outfile: outFile,
    bundle: true,
    format: 'esm',
    platform: 'browser',
    target: ['es2020'],
    logLevel: 'info',
});

const output = readFileSync(outFile, 'utf8');

if (! output.includes('export{') && ! output.includes('export default') && ! output.includes('export {')) {
    throw new Error('Rich editor bundle is missing its default export.');
}

if (! output.includes('trixValue')) {
    throw new Error('Rich editor bundle is missing the Alpine form component.');
}

console.log('Built rich-editor bundle at public/js/filament/forms/components/rich-editor.js');
