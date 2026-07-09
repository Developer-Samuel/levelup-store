import { defineConfig } from 'vitest/config'

import { plugins, resolve, build, test } from './vite/config'
import server from './vite/server'

export default defineConfig({
  plugins,
  resolve,
  build,
  server,
  test,
})
