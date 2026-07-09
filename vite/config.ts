import symfonyPlugin from 'vite-plugin-symfony'

import { AssetPaths, BuildPaths, TestConfig } from './constants'

export const plugins = [symfonyPlugin()]

export const resolve = {
  alias: {
    '@': AssetPaths.ROOT,
  },
}

export const build = {
  rollupOptions: {
    input: {
      styles: BuildPaths.STYLES,
      scripts: BuildPaths.SCRIPTS,
    },
  },
}

export const test = {
  globals: TestConfig.GLOBALS,
  environment: TestConfig.ENVIRONMENT,
  include: TestConfig.include,
  coverage: TestConfig.COVERAGE,
}
