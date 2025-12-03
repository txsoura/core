# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/), and this project adheres
to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [unreleased]

## [7.0.0] - 2021-05-09

### Added

- First project release

## [7.0.1] - 2021-06-15

### Fixed

- Fix base query paramns dates validation

## [7.0.1.1] - 2021-06-15

### Changed

- Add controllers methods success and fail messages
- Improve CRUD methods services

### Added

- Add new dictionaries words

## [7.0.2] - 2021-07-30

### Fixed

- Remove query params request include transformation

### Added

- Add git merge pull cli
- Create git cmd shortcuts
- Repository soft delete trait methods

## [7.0.3] - 2021-10-17

### Added

- Block unhallowed find & findOfFail relations
- Update/add new base exceptions
- .gitignore

### Fixed

- Fix base softDeletes service functions

### Changed

- Remove request param from destroy controller function
- Remove request param from softDeletes controller functions

### Removed

- ./idea directory

## [7.0.3.1] - 2021-10-17

### Fixed

- Fix access denied exception

## [7.0.4] - 2025-05-04

### Added

- Create CheckAuthLocale middleware to get the locale from the authenticated user

## [7.1.0] - 2025-12-03

### Added

- Add boolean filtering capability to CoreRepository
