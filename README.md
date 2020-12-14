# phpunit-coverage-badge

![Code Coverage Badge](./badge.svg) 

This action calculates the test coverage using a PHPUnit Clover report and generates an SVG badge from it.
This badge can then also be pushed to the repository to be displayed in the README (or wherever else you might need it).
An example is the badge above this text block, which shows the current test coverage of this project. 
There is something ironic about this project showcasing its own poor test coverage.

Inspired by [cicirello/jacoco-badge-generator](https://github.com/cicirello/jacoco-badge-generator) and [richardregeer/phpunit-coverage-check](https://github.com/richardregeer/phpunit-coverage-check).

The template for the svg badge was created using [Method Draw](http://github.com/duopixel/Method-Draw). The color scheme for the background of the coverage percentage number has been adapted from [cicirello/jacoco-badge-generator](https://github.com/cicirello/jacoco-badge-generator).

# Configuration
This action has no required inputs. However, probably at least the path to the Clover.xml file must be adjusted if it is not saved in the project root as clover.xml.

The default configuration does **NOT** push the badge back into the repository. 
Setting the input **push_badge** in your workflow to true will enable the commit and push process and the badge will be pushed into the repository after it's been generated.
Please note: The clover.xml file will also be committed and pushed if it changes during the workflow.

If you do not enable **push_badge** you'll need extra steps in your workflow to commit and push the file into the repository.
Please have a look at the inputs for all configuration options.

# Inputs

## Badge generation
### `clover_report`
The path to the clover report file generated by PHPUnit.

**default: clover.xml**

### `coverage_badge_path`
The path inside the repository where the created badge should be saved. Can be anywhere except inside the .github folder.

**default: badge.svg**

## Badge commit and push

### `push_badge`
Defines whether the badge will be committed and pushed to the repository.

**default: false**

Please note: If you enable push_badge you **MUST** add the repo_token, otherwise an exception will be thrown.

### `repo_token`
Token to push the badge into the repository. Just add "${{ secrets.GITHUB_TOKEN }}" as the input.

**default: NOT_SUPPLIED**

### `commit_message`
Commit message that will be used to commit the updated badge and clover file.

**default: Update code coverage badge**

### `commit_email`
Email that will be used for the commit.

**default: 41898282+github-actions[bot]@users.noreply.github.com**

This will display all commits as added by the official github actions account/page.

### `commit_name`
Name that will be used for the commit.

**default: Github Actions Bot**

