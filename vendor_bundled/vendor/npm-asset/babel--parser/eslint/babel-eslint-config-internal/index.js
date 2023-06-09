"use strict";

module.exports = {
  parser: "@babel/eslint-parser/experimental-worker",
  extends: "eslint:recommended",
  parserOptions: {
    sourceType: "module",
  },
  globals: {
    // Flow
    Iterator: true,
    $Keys: true,
  },
  env: {
    node: true,
    es2022: true,
    browser: true,
  },
  rules: {
    curly: ["error", "multi-line"],
    "linebreak-style": ["error", "unix"],
    "no-case-declarations": "error",
    "no-confusing-arrow": "error",
    "no-empty": ["error", { allowEmptyCatch: true }],
    "no-process-exit": "error",
    "no-var": "error",
    "prefer-const": "error",
  },
};
