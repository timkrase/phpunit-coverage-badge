#!/bin/bash
git add "${INPUT_COVERAGE_BADGE_PATH}";

git commit -m "${INPUT_COMMIT_MESSAGE}"

git push https://"${GITHUB_ACTOR}":"${INPUT_REPO_TOKEN}"@github.com/"${GITHUB_REPOSITORY}".git HEAD:"${GITHUB_REF##*/}";