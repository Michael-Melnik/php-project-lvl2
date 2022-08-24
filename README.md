The util shows a difference between two files. It supports two file input formats: json and yaml. Result string my be text or json-format or tree-structure.

### Hexlet tests and linter status:
[![Actions Status](https://github.com/Michael-Melnik/php-project-lvl2/workflows/hexlet-check/badge.svg)](https://github.com/Michael-Melnik/php-project-lvl2/actions)
[![Lint](https://github.com/Michael-Melnik/php-project-lvl2/actions/workflows/test_and_lint.yml/badge.svg)](https://github.com/Michael-Melnik/php-project-lvl2/actions/workflows/test_and_lint.yml)

### Code Climate:
[![Maintainability](https://api.codeclimate.com/v1/badges/d93dd9959da09ae1e481/maintainability)](https://codeclimate.com/github/Michael-Melnik/php-project-lvl2/maintainability)
[![Test Coverage](https://api.codeclimate.com/v1/badges/d93dd9959da09ae1e481/test_coverage)](https://codeclimate.com/github/Michael-Melnik/php-project-lvl2/test_coverage)

# Usage
###### setup
```
make install
```
###### show help
```
bin/gendiff -h
```

###### show version
```
bin/gendiff -v
```
###### show diff between files
* firstFile, secondFile - paths to files
* fmt - format (default - stylish)
```
bin/gendiff --format <fmt> <firstFile> <secondFile>
``` 
### Example comparison Json | Yaml (default format 'stylish')
[![asciicast](https://asciinema.org/a/cjK0oifXMVuV1vdtIetJX182d.svg)](https://asciinema.org/a/cjK0oifXMVuV1vdtIetJX182d)

### Example comparison ('plain' and 'json' format)
[![asciicast](https://asciinema.org/a/rtZz3pFvwnq6cxBacuzn1Zuw2.svg)](https://asciinema.org/a/rtZz3pFvwnq6cxBacuzn1Zuw2)

