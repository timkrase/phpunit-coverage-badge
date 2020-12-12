#!/bin/bash
git add "${INPUT_COVERAGE_BADGE_PATH}"
git add "${INPUT_CLOVER_REPORT}"

git config user.email "${INPUT_COMMIT_EMAIL}"
git config user.name "${INPUT_COMMIT_NAME}"

git commit -m "${INPUT_COMMIT_MESSAGE}"

git push https://"${GITHUB_ACTOR}":"${INPUT_REPO_TOKEN}"@github.com/"${GITHUB_REPOSITORY}".git HEAD:"${GITHUB_REF##*/}";