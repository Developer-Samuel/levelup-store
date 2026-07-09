// 🧰 tools/eslint/constants/test/globals.js

import globals from "globals";

import { TEST_NAMES } from "./names.js";

export const TEST_GLOBALS = {
  ...globals.browser,
  ...Object.fromEntries(TEST_NAMES.map(name => [name, "readonly"])),
};
