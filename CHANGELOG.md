# Changelog

[//]: # "All notable changes to `FeuerImageEditor` will be documented in this file."
[//]: # "Updates should follow the [Keep a CHANGELOG](http://keepachangelog.com/) principles."

## [0.5.6] - 2020-02-10

### Fixed
- Word-wrapping on high dpi images

## [0.5.5] - 2020-01-24

### Added
- Word-wrapping for textboxes

## [0.5.4] - 2019-11-22

### Added
- Option to create a new image without a file
- Funcition to export image as text
- Options to set image format and change the background color

## [0.5.3] - 2019-09-25

### Changed
- Added a parameter on `Image::open()` to set the dpi resolution of the file

## [0.5.2] - 2019-09-25

### Added
- `setColorProfile` to allow profile color management

## [0.5.1] - 2019-09-24

### Added
- `ImagickEngine::setRGB()` to allow the user to force RGB colorspace for drawing on CMYK files 

## [0.5.0] - 2019-07-19

### Added
- Pixel to point conversion on different DPI ratios
- Get colorspace from file

### Fixed
- `getDPI()` on `ImagickEngine` now uses `Imagick::identifyImage()` 

## [0.4.6] - 2019-06-11

### Fixed
- Fix for `ImagickEngine.getDPI()` in case `'Undefined'` is returned


## [0.4.5] - 2019-06-04

### Added
- DPI manipulation in `ImagickEngine`

## [0.4.4] - 2019-02-25

- Fixed `ImagickEngine.resize()` to not fill backgrounds, as it was causing a issue with `.png` image files

## [0.4.3] - 2018-12-20

### Fixed

- Fixed font file not being loaded for `Textbox`

## [0.4.2] - 2018-08-29

### Fixed

- Fixed composite constant on `ImagickEngine.drawImage()` to work across different ImageMagick versions

## [0.4.1] - 2018-06-27

### Added
- Font weight option for `Text`

## [0.4] - 2018-06-04

### Added
- `ImageLayer` created to allow `Layers` from image files
- Refactored `Image` into `ImageBase` to allow both Image and ImageLayers to inherit 

### Fixed
- Changed composer name to **pai-Cthulhu/feuerimageeditor** as composer don't allow uppercase characters

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
