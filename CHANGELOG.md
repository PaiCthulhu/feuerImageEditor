# Changelog

All notable changes to `FeuerImageEditor` will be documented in this file.

Updates should follow the [Keep a CHANGELOG](http://keepachangelog.com/) principles.

## [0.3.1] - 2018-05-30

### Fixed
- Filled this `CHANGELOG`

### Removed
- Older prototype files from _/src/deprecated/_

## [0.3] - 2018-05-29

### Added
- Greater `Textbox` support on `ImagickEngine`, now it allows a background color, border and text alignment
- Added `Shape` and `Text` traits, changing how `Stencil`s work, allow better reusability

## [0.2] - 2018-05-28

### Added
- New `Image` class to work as a mask to the engine handlers
- Two new `Engine`s, `GDEngine` and `ImagickEngine`. `ImagickEngine` will be the focus of the next updates
- `Stencil`s: after some research, I've decided to name image objects as **Stencil**s, like [Moqups](https://moqups.com/) do
to their html components, some of the suggested names where **Symbol**s(like those from 
[Sketch](https://sketchapp.com/docs/symbols/)) and **Object**s(but those I assumed that would cause certain confusion 
with OOP nomenclature)

### Deprecated
- All older files from the prototype, moved then to _/src/deprecated_

## [0.1] - 2018-05-24

### Added
- Skeleton of [thephpleague/skeleton](https://github.com/thephpleague/skeleton)
- Older files from the prototype of this project that where used in [21Live](http://21live.com.br)
- `Align` class for standardized alignment names
